import warnings
import random
import os
import time

import numpy as np

class Human:
    def __init__(self):
        self.infected = False
        self.immune = False
        self.age = 0
        self.prevent_net = False

    def __repr__(self):
        return 'Human'


    def step(self):
        self.age += 1


class Mosquito:
    def __init__(self):
        self.hungry = False
        self.hunger_time = 0
        self.infected = False
        self.age = 0


    def __repr__(self):
        return 'Mosquito'


    def step(self, x, y, grid, ttl):
        """
            Return the coordinates of the next
            position in the grid for the mosquito
        """
        if(x == 0):
            next_x = random.choice([0, 1])
        elif(x == len(grid[0]) - 1):
            next_x = random.choice([-1, 0])
        else:
            next_x = random.choice([-1, 0, 1])

        if(y == 0):
            next_y = random.choice([0, 1])
        elif(y == len(grid) - 1):
            next_y = random.choice([-1, 0])
        else:
            next_y = random.choice([-1, 0, 1])

        self.age += 1

        return (y + next_y, x + next_x)


class Cell:
    def __init__(self):
        self.human = None
        self.mosq = []
        self.mosq_count = 0

    def __repr__(self):
        if(self.human == None and self.mosq == []):
            return '--'
        elif(self.human != None and self.mosq == []):
            return 'Human'
        elif(self.mosq != [] and self.human == None):
            return 'Mosquito ' + str(self.mosq_count)
        else:
            return 'Both!'

    def step(self, ttl, grid, model):
        if(self.human != None):
            self.human.step()
            if(self.human.infected == True and self.human.age == ttl):
                self.human = None
                grid = spawn(model, grid, 'human')

        if(self.mosq != []):
            for mosq in self.mosq:

                if(mosq.hungry == True and mosq.age == ttl):
                    self.mosq.remove(mosq)
                    self.mosq_count -= 1

                if(mosq.hungry == False and mosq.age == ttl):
                    mosq.hungry = True
                    mosq.age = 0

        if(self.human != None and self.mosq != []):
            for mosq in self.mosq:
                if(mosq.hungry == True):
                    if(self.human.prevent_net == True):
                        self.mosq.remove(mosq)
                        self.mosq_count -= 1
                        continue

                    if(mosq.infected == True and self.human.immune == False and self.human.infected == False):
                        self.human.infected = True
                        self.human.age = 0

                    if(mosq.infected == False and self.human.infected == True):
                        mosq.infected = True
                        mosq.age = 0

                    mosq.hungry = False
                    mosq.age = 0
        return grid


class Model:
    def __init__(self):
        self.width = 10
        self.height = 10

        self.density_human = 0.5
        self.immune_human = 0.3
        self.infected_human = 0.7
        self.net_density = 0.2
        self.human_TTL = 5

        self.density_mosq = 0.7
        self.infected_mosq = 0.7
        self.hungry_mosq = 0.5
        self.mosq_TTL = 5
        self.spawn_rate = 0.3

        self.gridsize = self.width * self.height
        self.grid = self.setup()

        self.prevalance = 0


    def setup(self):
        s = (self.width, self.height)
        # Generate grid with randomly placed 1s (Humans),
        # distributed using the density_human
        grid1 = self.generate_map(s, self.density_human, 1, 2)
        num_people = self.gridsize * self.density_human


        # Generate grid with randomly placed 2s (Mosquitos),
        # distributed using the density_mosq
        grid2 = self.generate_map(s, self.density_mosq, 2, 2)
        num_mosq = self.gridsize * self.density_mosq


        # Sum two grids
        grid = [[sum(x) for x in zip(grid1[i], grid2[i])] for i in range(len(grid1))]

        mosq_coords = []
        human_coords = []

        # Convert list of numbers to list of objects, using Cell as parent object
        for idx_y, i in enumerate(grid):
            for idx_x, j in enumerate(i):
                #Set every cell to a Cell object, and the correct configurations
                grid[idx_y][idx_x] = Cell()
                current = grid[idx_y][idx_x]
                if j == 1 or j == 3:
                    human_coords.append((idx_y, idx_x))
                    current.human = Human()

                if j == 2 or j == 3:
                    mosq_coords.append((idx_y, idx_x))
                    current.mosq.append(Mosquito())
                    current.mosq_count += 1


        # Generate a map for a given density of the given parameter,
        # Then apply this map to the grid

        # For mosquitos
        inf_mosq_map = self.generate_map(num_mosq, self.infected_mosq, 1, 1)
        hun_mosq_map = self.generate_map(num_mosq, self.hungry_mosq, 1, 1)
        grid = self.apply_map_mosq(mosq_coords, 'infected', inf_mosq_map, grid)
        grid = self.apply_map_mosq(mosq_coords, 'hungry', hun_mosq_map, grid)

        #For humans
        imm_human_map = self.generate_map(num_people, self.immune_human, 1, 1)
        inf_human_map = self.generate_map(num_people, self.infected_human, 1, 1)
        prevent_human_map = self.generate_map(num_people, self.net_density, 1, 1)

        grid = self.apply_map_human(human_coords, 'infected', inf_human_map, grid)
        grid = self.apply_map_human(human_coords, 'immune', imm_human_map, grid)
        grid = self.apply_map_human(human_coords, 'prevent_net', prevent_human_map, grid)

        return grid


    def apply_map_human(self, coords, param, mapping, grid):
        for i, coord in enumerate(coords):
            if mapping[i] == 1:
                if(grid[coord[0]][coord[1]].human.infected == True and param == 'immune'):
                    continue
                else:
                    setattr(grid[coord[0]][coord[1]].human, param, True)

        return grid


    def apply_map_mosq(self, coords, param, mapping, grid):
        for i, coord in enumerate(coords):
            if mapping[i] == 1:
                setattr(grid[coord[0]][coord[1]].mosq[0], param, True)

        return grid


    def generate_map(self, size, density, value, dimension):
        output = np.zeros(size)

        if(dimension == 1):
            number = size * density
            np.put(output, np.random.choice(range(int(size)), number, replace = False), value)
        elif(dimension == 2):
            number = (size[0] * size[1] * density)
            np.put(output, np.random.choice(range(size[0] * size[1]), number, replace = False), value)
        return output


    def step(self):
        grid = self.grid

        for idx_y , row in enumerate(grid):
            for idx_x, cell in enumerate(row):
                cell.step(self.human_TTL, self.grid, self)
                if(cell.mosq != []):

                    for i in cell.mosq:
                        y, x = i.step(idx_x, idx_y, grid, self.mosq_TTL)
                        self.grid[y][x].mosq.append(i)
                        self.grid[y][x].mosq_count += 1

                        if(cell.mosq_count == 1):
                            cell.mosq = []

                        elif(cell.mosq_count > 1):
                            cell.mosq.remove(i)

                        cell.mosq_count -= 1

        # Every timestep there is a probability that a new mosquito spawns
        options = [1] * (int(100 * self.spawn_rate)) + [0] * (100 - (int(100 * self.spawn_rate)))
        if(random.choice(options)):
            self.grid = spawn(self, grid, 'mosq')

        infected_count = 0
        for i in grid:
            for j in i:
                if(j.human != None and j.human.infected == True):
                    infected_count += 1
        self.prevalance = infected_count / (self.density_human * self.gridsize)


def spawn(self, grid, object_type):
    x = random.randint(0, len(grid[0]) - 1)
    y = random.randint(0, len(grid) - 1)

    if(object_type == 'human'):
        while(grid[y][x].human != None):
            x = random.randint(0, len(grid[0]) - 1)
            y = random.randint(0, len(grid) - 1)

        grid[y][x].human = Human()

        options = [1] * (int(100 * self.infected_human)) + [0] * (100 - (int(100 * self.infected_human)))
        if(random.choice(options)):
            grid[y][x].human.infected = True


    elif(object_type == 'mosq'):
        grid[y][x].mosq.append(Mosquito())
        grid[y][x].mosq_count += 1

        options = [1] * (int(100 * self.infected_mosq)) + [0] * (100 - (int(100 * self.infected_mosq)))
        if(random.choice(options)):
            grid[y][x].mosq[0].infected = True

    return grid


def output_grid(grid):
    s = [[str(e) for e in row] for row in grid]
    lens = [max(map(len, col)) for col in zip(*s)]
    formatting = '\t'.join('{{:{}}}'.format(x) for x in lens)
    table = [formatting.format(*row) for row in s]
    print('\n'.join(table))


if __name__ == '__main__':
    # Just to ignore a deprecation warning of numpy
    warnings.filterwarnings('ignore')

    result = []
    for i in range(0, 10):
        model = Model()

        outcome = []
        for i in range(0, 500):
        #    output_grid(model.grid)
            model.step()
            outcome.append(model.prevalance)
        #    print('\n\n\n\n')
            time.sleep(0.5)
            print(model.prevalance)
        result.append(outcome)
    print(np.mean(result, axis=0))
