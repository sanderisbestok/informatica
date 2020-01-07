import numpy as np
from math import ceil, floor
from random import uniform


def find_y_range(f, x_min, x_max, step=0.1):
    """
    Finds min and max y values of function f in range x_min, x_max.
    """
    y_min = f(x_min)
    y_max = f(x_min)
    xrange = np.arange(x_min, x_max, step)

    for x in xrange:
        y = f(x)
        if y < y_min:
            y_min = y
        else:
            y_max = y

    return (floor(y_min), ceil(y_max))


def monte_carlo(f, x_min, x_max, n=1000):
    """
    Finds the integral of function f using the monte carlo method.
    """
    y_min, y_max = find_y_range(f, x_min, x_max)
    n_in = 0

    for _ in range(n):
        x_rand = uniform(x_min, x_max)
        y_rand = uniform(y_min, y_max)
        if y_rand < f(x_rand):
            n_in += 1

    exess = (x_max - x_min) * y_min
    return ((n_in/n)*(y_max - y_min)*(x_max - x_min)) + exess

def uniform_integration(f, x_min, x_max, n=100):
    """
    Implement this function and provide documentation here.
    """
    y_sum = 0
    for _ in range(n):
        x = uniform(x_min, x_max)
        y_sum += f(x)
    return (y_sum / n)*(x_max - x_min)
