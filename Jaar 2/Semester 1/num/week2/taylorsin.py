import numpy as np
import matplotlib.pyplot as plt
from scipy.special import factorial

def taylor(x, n):
    result = 0

    for k in range(0, n + 1):
        result += ((-1)**k)/(factorial(2*k+1))*x**(2*k+1)

    return result

if __name__ == "__main__":
    x = np.linspace(-np.pi, np.pi, 1000)
    y = np.sin(x)

    taylory = taylor(x,6)

    plt.figure()
    plt.plot(x, y, 'r-', x, taylory, 'g-')
    plt.axis([-np.pi, np.pi, np.amin(y), np.amax(y)])
    plt.show()
