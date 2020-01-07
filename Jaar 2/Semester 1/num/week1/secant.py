import numpy as np
import matplotlib.pyplot as plt

def f(x):
    return (x**3 + 2 * x - 1)

def secant_solve(a, b, tol=0.001, maxiter=100):
    i = 0
    p = float("Inf")

    while(i < maxiter):
        fa = f(a)
        fb = f(b)
        oldp = p
        p = (b - fb * ((b - a) / (fb - fa)))
        fp = f(p)

        if (fp == 0 or (np.abs(p - oldp) < tol)):
            return p, fp, i
        else:
            a = b
            b = p

        i += 1

    return p, fp, i

if __name__ == "__main__":
    p, fp, _ = secant_solve(0, 1, 0.0000001)
    result_table = []

    print("We vonden %f" %fp)
    print("Op x = %f" %p)

    result_table.append(("Tolerantie", "Iteraties"))
    for j in range(1, 16):
        _, _, i = secant_solve(0, 1, (10**(-1*j)))
        result_table.append(("10^-%d"%j,i))

    for row in result_table:
        print(row)
