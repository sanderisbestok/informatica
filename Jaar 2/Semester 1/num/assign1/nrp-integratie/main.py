#!env/bin/python

from functools import partial
import numpy as np

from integration import riemann_sum, trapezoidal_rule, simpson_rule
from monte_carlo import monte_carlo, uniform_integration

functions = [
        ('f(x) = 4 / (x ^ 2 + 1)', lambda x: 4 / (x ** 2 + 1), 0, 1, np.pi),
        ('f(x) = sin(x)', np.sin, 0, np.pi, 2.0),
    ]

integration_methods = [
        ('left riemann sum', riemann_sum),
        ('right riemann sum', partial(riemann_sum, method='right')),
        ('middle riemann sum', partial(riemann_sum, method='middle')),
        ('trapezoidal rule', trapezoidal_rule),
        ('simpson rule', simpson_rule),
    ]

monte_carlo_methods = [
        ('monte carlo', monte_carlo),
        ('uniform', uniform_integration),
    ]

def minimal_interval(solver, f, x_min, x_max, result, tol=0.1, maxiter=1000000):
    for n in range(1, maxiter):
        solver_result = solver(f, x_min, x_max, n)
        if abs(solver_result - result) <= tol:
            return n
    return -1


def main():
    print('numerical integration:')

    for n in [10, 100, 1000, 10000]:
        print('\tprecision: {}'.format(1.0 / n))

        for display, f, x_min, x_max, result in functions:
            print('\t\t{}:'.format(display))

            for name, solver in integration_methods:
                print('\t\t\t{}:\t{}'.format(name, solver(f, x_min, x_max, n)))

    for n in [10, 100, 1000, 10000, 100000]:
        print('\tprecision: {}'.format(1.0 / n))

        display, f, x_min, x_max, result = functions[0]
        for display, f, x_min, x_max, result in functions:
            print('\t\t{}:'.format(display))

            for name, solver in monte_carlo_methods:
                print('\t\t\t{}: {}'.format(name, solver(f, x_min, x_max, n)))


def min_sample(iters=20):
    print('Average calculation takes {} samples'.format(iters))

    for n in [10, 100, 1000, 10000]:
        print('\tprecision: {}'.format(1.0 / n))

        display, f, x_min, x_max, result = functions[0]
        for display, f, x_min, x_max, result in functions:
            print('\t\t{}:'.format(display))

            for name, solver in monte_carlo_methods:
                min_sum = 0
                for _ in range(iters):
                    minimal = minimal_interval(solver, f, x_min, x_max,
                                               result, 1.0/n)
                    if minimal < 0:
                        print('\t\t\tPrecision not met after maximum iterations')
                        break
                    min_sum += minimal

                print('\t\t\tAverage minimal samplesize of {}:\t{}'.format(name, int(min_sum/iters)))

def min_interval():
    for n in [10, 100, 1000, 10000]:
        print('\tprecision: {}'.format(1.0 / n))

        for display, f, x_min, x_max, result in functions:
            print('\t\t{}:'.format(display))

            for name, solver in integration_methods:
                minimal = minimal_interval(solver, f, x_min, x_max,
                                           result, 1.0/n)
                print('\t\t\tMinimal Interval of {}: {}'.format(name, minimal))

if __name__ == '__main__':
    main()
    # min_sample()
    # min_interval()
