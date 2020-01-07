import numpy as np
import matplotlib.pyplot as plt

def Newton_solve(f, fp, x0, tol=0.001, maxiter=100):
    x = x0
    for i in range(maxiter):
        try:
            x = x - f(x)/fp(x)
        except ZeroDivisionError:
            print("Dividing by zero, skipping")
            return 0, 0

        if (np.absolute(f(x)) < tol):
            ri = i
            break

        ri = i


    return ri, x

def f(x):
    return x**2-x-1

def fp(x):
    return 2*x-1

def f2(x):
    return x**(3)+x**(2)-2

def fp2(x):
    return 3*x**(2)+2*x

def f3(x):
    return x**3 - 3*x**2 + 2

def fp3(x):
    return 3*x - 6*x**2


if __name__ == "__main__":
    print("Formule 1, start 1.0")
    print("Significance\tx\t\titerations")
    sig = 0.1
    for i in range (10):
        ri, x = Newton_solve(f, fp, 1.0, sig)
        print("%.10f\t%.10f\t\t%d" %(sig,x, ri))
        sig = (sig / 10)

    print("\nFormule 2, start 1.5")
    sig = 0.1
    for i in range (10):
        ri, x = Newton_solve(f2, fp2, 1.5, sig)
        print("%.10f\t%.10f\t\t%d" %(sig,x, ri))
        sig = (sig / 10)

    print("\nFormule 2, start -1.5")
    sig = 0.1
    for i in range (10):
        ri, x = Newton_solve(f2, fp2, -1.5, sig)
        print("%.10f\t%.10f\t\t%d" %(sig,x, ri))
        sig = (sig / 10)

    print("\nFormule 3, start 1.77")
    sig = 0.1
    for i in range (10):
        ri, x = Newton_solve(f3, fp3, 1.77, sig)
        print("%.10f\t%.10f\t\t%d" %(sig,x, ri))
        sig = (sig / 10)

    print("\nFormule 3, start 1.78")
    sig = 0.1
    for i in range (10):
        ri, x = Newton_solve(f3, fp3, 1.78, sig)
        print("%.10f\t%.10f\t\t%d" %(sig,x, ri))
        sig = (sig / 10)
