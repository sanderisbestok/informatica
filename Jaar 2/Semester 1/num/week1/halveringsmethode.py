import numpy as np
import matplotlib.pyplot as plt

def f(x):
    return (x**3 + 2 * x - 1)

def bisection_solve(a, b, tol=0.001, maxiter=100):
    i = 0

    p = ((a + b) / 2)
    fp = f(p)
    fa = f(a)

    while(i < maxiter and ((np.abs(b - a) / 2) > tol)):
        if (fp == 0):
            return p, fp, i
        elif ((fp < 0 and fa > 0) or (fp > 0 and fa < 0)):
            a = a
            b = p
        else:
            a = p
            b = b

        p = ((a + b) / 2)
        fp = f(p)
        fa = f(a)

        i += 1

    return p, fp, i

def bisection_solve_c(a, b, tol=0.001, maxiter=100):
    i = 0

    p = ((a + b) / 2)
    fp = f(p)
    fa = f(a)

    while(i < maxiter and ((np.abs(b - a) / np.abs(b + a)) > tol)):
        if (fp == 0):
            return p, fp, i
        elif ((fp < 0 and fa > 0) or (fp > 0 and fa < 0)):
            a = a
            b = p
        else:
            a = p
            b = b

        p = ((a + b) / 2)
        fp = f(p)
        fa = f(a)

        i += 1

    return p, fp, i

if __name__ == "__main__":
    p, fp, _ = bisection_solve(0, 1, 0.00001)
    result_table = []

    print("We vonden %f" %fp)
    print("Op x = %f" %p)

    result_table.append(("Tolerantie", "Iteraties"))
    for j in range(1, 16):
        _, _, i = bisection_solve(0, 1, (10**(-1*j)))
        result_table.append(("10^-%d"%j,i))

    for row in result_table:
        print(row)

    print("Het verband is inderdaad linear")

    p, fp, i = bisection_solve_c(0,1, 0.001)
    print("\nIteraties bij afbreekfout = %d" %i)
    print("We vonden %f" %fp)
    print("Op x = %f" %p)
