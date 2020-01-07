import numpy as np
import matplotlib.pyplot as plt

def f(x):
    return x/2 + 1/x

if __name__ == "__main__":
    x = 1000

    print("Iteratie\tx")

    for i in range(20):
        x = f(x)
        print("%d\t%.16f" %(i+1,x))

    print("Dekpunt ligt bij 14")
