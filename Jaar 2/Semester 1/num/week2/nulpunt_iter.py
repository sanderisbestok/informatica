import numpy as np
import matplotlib.pyplot as plt

def f1(x):
    return (4-x**3)/(3*x)

def f2(x):
    return (4-3*x)/(x**2)

def f3(x):
    return x**(3) + 4*x - 4

def f4(x):
    return (x - (1/6)*(x**(3) + 3 * x -4))

def f5(x):
    return (2*x**3 + 4)/(3*x**2 + 3)

def test(f):
    for x in range(-10, 10):
        startingx = x
        for i in range(100):
            try:
                x = f(x)
            except:
                print("Nothing found for starting x %d" %(startingx))
                break
            try:
                if (x - 1.0 < 0.001 and x - 1.0 > -0.001):
                    print("Result on iteration: %d with starting x = %d"%(i + 1, startingx))
                    print("%.5f"%x)
                    break
            except:
                print("Some error did take place")
                break

if __name__ == "__main__":
    print("Function 1")
    test(f1)
    print("\nFunction 2")
    test(f2)
    print("\nFunction 3")
    test(f3)
    print("\nFunction 4")
    test(f4)
    print("\nFunction 5")
    test(f5)
