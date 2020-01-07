import numpy as np

def f(t):
    return ((3*(t)**(2))-(2*t)-1)

def differentie(t, dt):
    return ((f(t + dt) - f(t))/dt)

if __name__ == "__main__":
    print("n\tdf/dt")
    print("---------------------------")
    for i in range(1, 17):
        dif = differentie(1, (10**(-1*i)))
        print("%d\t%.17f" %(i, dif))
