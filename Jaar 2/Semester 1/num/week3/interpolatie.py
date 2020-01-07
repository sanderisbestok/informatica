import scipy as sp
import numpy as np
from scipy.interpolate import interp1d
import matplotlib.pyplot as plt

if __name__ == "__main__":
    originalx = np.linspace(0, 4, 100)
    originaly = (originalx - 1) * (originalx - 2) * (originalx - 3)
    x = np.array([0, 1 ,4])
    y = (x - 1) * (x - 2) * (x - 3)

    P1 = interp1d(x,y)  # lineaire interpolatiefunctie
    P2 = interp1d(x,y, kind='quadratic')  # kwadratische interpolatiefunctie
    xx = sp.linspace(0,4,100)
    y1 = P1(xx)
    y2 = P2(xx)
    plt.figure(figsize=(8,8))
    plt.plot(x,y, 'bs', originalx, originaly, 'b', xx, y1, 'r--', xx, y2, 'g-.')
    plt.legend(['punten', 'lineaire interpolatie', 'kwadratische interpolatie', 'kubisch'], loc='upper left')
    plt.show()
