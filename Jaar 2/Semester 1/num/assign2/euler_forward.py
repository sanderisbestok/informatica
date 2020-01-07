import matplotlib.pyplot as plt
import numpy as np
from linefield import subplot, calculate_lines


def f(t, y):
    return 1 - 2*t*y


def f2(t, y):
    return y*(1 - (1/3)*y)


def euler(phi, t0, y0, t1, n):
    """
    Args:
        phi (func pointer) - is de functie bij de GDV dy/dt = phi(t,y)
        beginwaarde(float) - y(t0) = y0 tijdinterval is [t0, t1]
        n(int) - is het aantal stappen in de EUler metode
        t(np.array) - is de numpy array van tijdstippen
        y(np.array) - is de numpy array van berekende functiewaarden
    """
    dt = t1 - t0
    t = np.linspace(t0, t0 + n*dt, n)

    # Solution array
    y = np.empty((n,))
    y[0] = y0

    for k in range(n - 1):
        tk = t0 + k*dt
        y[k + 1] = y[k] + phi(tk, y[k]) * dt

    return t, y


if __name__ == "__main__":
    tbigarray = np.random.uniform(0.0, 3.2, 2000)
    ybigarray = np.random.uniform(0.0, 3.2, 2000)

    fig = plt.figure(figsize=(15, 7))

    # First plot
    ax = fig.add_subplot(1, 2, 1)

    # Get the linefield
    for i in range(0, len(tbigarray) - 1):
        calculate_lines(tbigarray[i], ybigarray[i], f, ax, '#d3d3d3')

    plt.title("lijnelementveld bij y' = 1 - 2t")
    subplot(ax, '#d3d3d3')

    # Euler lines for f
    beginwaardes = [(f, 0, 1.5, 0.12, 50, 'r-'),
                    (f, 0, 0.25, 0.12, 50, 'g-')]

    for phi, t0, y0, t1, n, line in beginwaardes:
        t, y = euler(phi, t0, y0, t1, n)
        plt.plot(t, y, line)

    # Second plot
    ax = fig.add_subplot(1, 2, 2)

    # Get the linefield
    for i in range(0, len(tbigarray) - 1):
        calculate_lines(tbigarray[i], ybigarray[i], f2, ax, '#d3d3d3')

    plt.title("lijnelementveld bij y' = y(1 - 1/3y)")
    subplot(ax, '#d3d3d3', [0, 2, 0, 3.2])

    # Euler lines for f2
    beginwaardes = [(f2, -1, 0.25, -0.75, 50, 'b-'),
                    (f2, -1, 2.5, -0.75, 50, 'k-')]

    for phi, t0, y0, t1, n, line in beginwaardes:
        t, y = euler(phi, t0, y0, t1, n)
        plt.plot(t, y, line)

    fig.canvas.set_window_title('Lijnelementveld met euler')
    plt.show()
