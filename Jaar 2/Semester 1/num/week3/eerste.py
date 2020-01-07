import numpy as np
import matplotlib.pyplot as plt
import matplotlib.mlab as ml


if __name__ == "__main__":
    x = np.linspace(0, (2 * np.pi), 25)
    y = np.sin(x)

    dy = np.append((np.diff(y) / ((2 * np.pi)/25)), [1])
    dy2 = (((1/(2*np.pi/25))/2) * (np.correlate(y, [-1, 0, 1], "same")))
    dy3 = (np.roll(y, -1) - np.roll(y, 1)) / (2 * ((2 * np.pi) / 25))

    fig = plt.figure()
    fig.canvas.set_window_title("Eerste afgeleide")

    plt.plot(x, y, 'b')
    plt.plot(x, dy, 'k')
    plt.plot(x, dy2, 'g')
    plt.plot(x, dy3, 'r')
    plt.axis([0, (2 * np.pi), -1, 1])
    plt.title("Eerste afgeleide")
    plt.legend(['data', "Diff", "Cross", "roll"])
    plt.show()
