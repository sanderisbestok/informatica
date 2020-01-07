import scipy as sp
import numpy as np
from scipy.optimize import curve_fit
import matplotlib.pyplot as plt



def f(t,a,b,c,d): return a* sp.e * sp.exp(-b*t) - c * sp.e * sp.exp(-d*t)

if __name__ == "__main__":
    x = sp.array([0.25, 0.5, 0.75, 1.00, 1.5, 2.0, 3.0, 4.0, 6.0, 8.0, 10.00, 24.00])
    y = sp.array([0.0, 19.2, 74.6, 125.0, 200.0, 223.1, 215.4, 192.3, 157.7, 130.8, 115.4, 38.5])

    gok = [300,0.1, 500, 1.0]
    params, params_covariance = curve_fit(f, x, y, gok)
    stdevs = sp.sqrt(sp.diag(params_covariance))
    gefit = f(x, params[0], params[1], params[2], params[3])

    fig = plt.figure()
    fig.canvas.set_window_title("Regressie")
    plt.plot(x, y, 'kx')
    plt.plot(x, gefit, 'r-')
    plt.axis([0.25, 24, np.amin(y), np.amax(y) + 1])
    plt.title("Regressie")
    plt.legend(['f(x)'])
    plt.show()
