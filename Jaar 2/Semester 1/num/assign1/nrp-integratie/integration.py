import numpy as np


def riemann_sum(f, x_min, x_max, n=100, method='left'):
    """
    Finds the approximate integral using the riemann sum method.
    """
    h = (x_max - x_min) / n

    sum_result = 0
    for k in range(1, n):
        if method == 'right':
            sum_result += f(x_min + (k*h))
        elif method == 'middle':
            sum_result += f(x_min + (k-0.5)*h)
        else:
            sum_result += f(x_min + (k-1)*h)

    return h*sum_result


def trapezoidal_rule(f, x_min, x_max, n=100):
    """
    Finds the approximate integral using the trapezoid method.
    """
    h = (x_max - x_min) / n

    sum_result = 0
    for k in range(1, n-1):
        sum_result += f(x_min + (k*h))

    return (h/2)*(f(x_min) + f(x_max) + (2*sum_result))


def simpson_rule(f, x_min, x_max, n=100):
    """
    Finds the approximate integral using Simpson's rule.
    """
    trap = trapezoidal_rule(f, x_min, x_max, n)
    rieman = riemann_sum(f, x_min, x_max, n, method='middle')
    return (trap/3) + (2*(rieman/3))
