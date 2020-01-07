import numpy as np
from pyics import Model

def base_k_to_decimal(k, n):
    """Converts a given base-k list to a decimal (i.e. base-10 integer)"""
    result = 0
    power = n.size - 1

    for index, i in enumerate(n):
        result += i * (k**(power - index))

    return result


def random_table(r, k, l):
    """Creates a random rule based on a certain lambda"""
    length = k ** (2 * r + 1)
    states = np.arange(1, k)
    result = np.zeros(length)
    Sq = 0

    for i in range(length):
        if (np.random.uniform(0, 1) > l):
            result[i] = Sq
        else:
            result[i] = np.random.choice(states)

    return result


def table_walk_through(r, k, l):
    """Generate rule with the table walk through method"""
    states = np.arange(1, k)
    length = k ** (2 * r + 1)
    result = np.zeros(length)
    amount_indexes = int(round(length * l))
    indexes = np.random.randint(0, (length - 1), size=amount_indexes)

    for i in indexes:
        result[i] = np.random.choice(states)

    return result


class CASim(Model):
    def __init__(self, ran, basek, lam):
        Model.__init__(self)

        self.t = 0
        self.rule_set = []
        self.config = None

        self.make_param('r', ran)
        self.make_param('k', basek)
        self.make_param('l', lam)
        self.make_param('width', 50)
        self.make_param('height', 50)
        self.make_param('random_table', True)
        self.make_param('rule', 30, setter=self.setter_rule)

    def setter_rule(self, val):
        """Setter for the rule parameter, clipping its value between 0 and the
        maximum possible rule number."""
        rule_set_size = self.k ** (2 * self.r + 1)
        max_rule_number = self.k ** rule_set_size
        return max(0, min(val, max_rule_number - 1))

    def build_rule_set(self):
        """Sets the rule set for the current rule.
        A rule set is a list with the new state for every old configuration.

        For example, for rule=34, k=3, r=1 this function should set rule_set to
        [0, ..., 0, 1, 0, 2, 1] (length 27). This means that for example
        [2, 2, 2] -> 0 and [0, 0, 1] -> 2."""
        if self.random_table:
            self.rule_set = random_table(self.r, self.k, self.l)
        else:
            self.rule_set = table_walk_through(self.r, self.k, self.l)

    def check_rule(self, inp):
        """Returns the new state based on the input states.

        The input state will be an array of 2r+1 items between 0 and k, the
        neighbourhood which the state of the new cell depends on."""
        length = self.k ** (2 * self.r + 1)
        decimal = base_k_to_decimal(self.k, inp)
        state = self.rule_set[int(length) - 1 - int(decimal)]

        return state

    def setup_initial_row(self, random=True):
        """Returns an array of length `width' with the initial state for each of
        the cells in the first row. Values should be between 0 and k."""

        if random:
            setup = np.random.randint(0, self.k, size=(self.width,))
        else:
            setup = np.zeros(self.width)
            setup[int(self.width / 2)] = 1

        return setup

    def reset(self, random=True):
        """Initializes the configuration of the cells and converts the entered
        rule number to a rule set."""

        self.t = 0
        self.config = np.zeros([self.height, self.width])
        self.config[0, :] = self.setup_initial_row(random)
        self.build_rule_set()

    def draw(self):
        """Draws the current state of the grid."""

        import matplotlib
        import matplotlib.pyplot as plt

        plt.cla()
        if not plt.gca().yaxis_inverted():
            plt.gca().invert_yaxis()
        plt.imshow(self.config, interpolation='none', vmin=0, vmax=self.k - 1,
                   cmap=matplotlib.cm.binary)
        plt.axis('image')
        plt.title('t = %d' % self.t)

    def step(self):
        """Performs a single step of the simulation by advancing time (and thus
        row) and applying the rule to determine the state of the cells."""
        self.t += 1
        if self.t >= self.height:
            return True

        for patch in range(self.width):
            # We want the items r to the left and to the right of this patch,
            # while wrapping around (e.g. index -1 is the last item on the row)
            # Since slices do not support this, we create an array with the
            # indices we want and use that to index our grid.
            indices = [i % self.width
                       for i in range(patch - self.r, patch + self.r + 1)]
            values = self.config[self.t - 1, indices]
            self.config[self.t, patch] = self.check_rule(values)


if __name__ == '__main__':
    sim = CASim(2, 3, 0.5)
    from pyics import GUI
    cx = GUI(sim)
    cx.start()
