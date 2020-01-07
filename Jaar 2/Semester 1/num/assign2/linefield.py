import matplotlib.pyplot as plt
import numpy as np


def dydt(t, y):
    return 1 - 2 * t * y


def subplot(ax, color='b', axis=[-0.2, 2.2, -0.2, 2.2]):
    """
    Adds a subplot with the right lines
    """
    line = plt.Line2D([-0.2, 2.2], [0, 0], color=color)
    ax.add_line(line)
    line = plt.Line2D([0, 0], [-0.2, 2.2], color=color)
    ax.add_line(line)
    plt.axis(axis)


def calculate_lines(t, y, f, plot, color='b'):
    """
    Calculates the length and position of the lines
    """
    slope = f(t, y)
    length = np.sqrt(1 + np.power(slope, 2))
    tlength = (1 / length) * 0.05
    vlength = (slope / length) * 0.05
    line = plt.Line2D([t - tlength, t + tlength],
                      [y - vlength, y + vlength], color=color)
    plot.add_line(line)


if __name__ == "__main__":
    tarray = np.linspace(0.0, 2.0, 10)
    yarray = np.linspace(0.0, 2.0, 10)
    tbigarray = np.random.uniform(0.0, 2.0, 2000)
    ybigarray = np.random.uniform(0.0, 2.0, 2000)

    fig = plt.figure(figsize=(15, 7))
    ax = fig.add_subplot(1, 2, 1)

    # Loop over t and y array and get the lines
    for t in tarray:
        for y in yarray:
            calculate_lines(t, y, dydt, ax)

    plt.title("lijnelementveld bij y' = 1 - 2ty")
    subplot(ax)
    ax = fig.add_subplot(1, 2, 2)

    # Get the lines for the big array
    for i in range(0, len(tbigarray) - 1):
        calculate_lines(tbigarray[i], ybigarray[i], dydt, ax)

    plt.title("groot lijnelementveld bij y' = 1 - 2ty")
    subplot(ax)

    fig.canvas.set_window_title('Lijnelementveld groot')
    plt.show()
