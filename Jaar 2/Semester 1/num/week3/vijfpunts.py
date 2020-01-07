import numpy as np
import matplotlib.pyplot as plt
import matplotlib.mlab as ml


if __name__ == "__main__":
    x = np.linspace(0, (2 * np.pi), 25)
    y = np.sin(x)

    dy = (((1/(2*np.pi/25))/12) * (np.correlate(y, [1, -8, 0, 8, -1], "same")))
    dy2 = (np.roll(y, -1) - np.roll(y, 8) + np.roll(y, -8) - np.roll(y, 1)) / (2 * ((2 * np.pi) / 6))

    fig = plt.figure()
    fig.canvas.set_window_title("Eerste afgeleide")

    plt.plot(x, y, 'k')
    plt.plot(x, dy, 'b')
    plt.plot(x, dy2, 'g')
    plt.axis([0, (2 * np.pi), -1, 1])
    plt.title("Eerste afgeleide")
    plt.legend(['data', "Cross", "Roll"])
    plt.show()
