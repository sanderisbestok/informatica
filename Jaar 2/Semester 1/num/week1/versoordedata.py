import numpy as np
import matplotlib.pyplot as plt

def f(x):
    return ((2 * x))

if __name__ == "__main__":
    x = np.linspace(0, 5, 51)
    y = f(x)
    yrand = list(y)

    random = np.random.uniform(-0.5, 0.5, 51)
    for i in range(len(y)):
        yrand[i] = y[i] + random[i]

    plt.plot(x, y, 'b')
    plt.axis([0, 5, np.amin(y), np.amax(y)])
    plt.plot(x, yrand, 'ro')
    plt.axis([0, 5, np.amin(y), np.amax(y)])
    plt.show()
