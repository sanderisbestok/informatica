import scipy as sp
from scipy.optimize import fsolve
from scipy.optimize import minimize_scalar
from scipy.optimize import brute
import numpy as np
import matplotlib.pyplot as plt

def f(x):
    return (x**3 + 4*x**2 + 2*x - 1)

if __name__ == "__main__":
    x = sp.linspace(-4, 1, 100)
    y = f(x)

    nulpunt = fsolve(f, -4)
    nulpunt2 = fsolve(f, -2)
    nulpunt3 = fsolve(f, 0)

    print("Nulpunten")
    print(nulpunt)
    print(nulpunt2)
    print(nulpunt3)

    grid=(-4, 1, 0.1)
    minimum = brute(f, (grid, ))
    print("Minimum")
    print(minimum)

    grid=(-2, 1, 0.1)
    maximum = brute(f, (grid, ))
    print("Maximum")
    print(maximum)

    fig = plt.figure()
    fig.canvas.set_window_title("Functieonderzoek")
    plt.plot(x, y, 'k')
    plt.axis([-4, 1, np.amin(y), np.amax(y)])
    plt.title("Functieonderzoek")
    plt.legend(['f(x)'])
    plt.show()
