import numpy as np
import matplotlib.pyplot as plt
import matplotlib.mlab as ml

def random_number(x):
    return x**2 + (np.random.uniform(-0.001, 0.001))


if __name__ == "__main__":
    x = np.linspace(-1, 1, 101)
    y = [random_number(a) for a in x]



    dy = np.convolve(y, [1, -8, 0, 8, -1], "same") / (12 * (2/101))
    dy2 = np.convolve(dy, [1, -8, 0, 8, -1], "same") / (12 * (2/101))

    print(dy2)

    plt.plot(x, y, 'k')
    plt.plot(x, dy, 'r')
    plt.plot(x, dy2, 'b')
    plt.axis([-1, 1, -2, 3])
    plt.title("Tweede afgeleide")
    plt.legend(['data', "Diff", "Cross", "roll"])
    plt.show()
