import scipy as sp
import numpy as np
from scipy.interpolate import InterpolatedUnivariateSpline
import matplotlib.pyplot as plt

if __name__ == "__main__":
    x = sp.linspace(0, 1, 6)
    y = x**3 + 2

    S = InterpolatedUnivariateSpline(x, y)  # natuurlijke kubische splines interpolatie
    benaderx = np.array([0.1, 0.3, 0.5, 0.7, 0.9])
    benadery = S(benaderx)
    exacty = benaderx**3 + 2


    print("x\tExact\t\t\tBenader\t\t\tAfbreekfout")
    print("0.1\t%.20f\t%.20f\t%.20f" %(exacty[0], benadery[0], np.absolute(exacty[0] - benadery[0])))
    print("0.3\t%.20f\t%.20f\t%.20f" %(exacty[1], benadery[1], np.absolute(exacty[1] - benadery[1])))
    print("0.5\t%.20f\t%.20f\t%.20f" %(exacty[2], benadery[2], np.absolute(exacty[2] - benadery[2])))
    print("0.7\t%.20f\t%.20f\t%.20f" %(exacty[3], benadery[3], np.absolute(exacty[3] - benadery[3])))
    print("0.9\t%.20f\t%.20f\t%.20f" %(exacty[4], benadery[4], np.absolute(exacty[4] - benadery[4])))

    exactx = sp.linspace(0, 1, 100)
    dy = S.derivative()(exactx)
    ddy = S.derivative(2)(exactx)

    exactdy = 3 * exactx**2
    exactddy = 6 * exactx
    print("\nEerste afgeleide")
    print("x\tExact\t\t\tBenadering\t\tAfbreekfout")
    print("0.1\t%.20f\t%.20f\t%.20f" %(exactdy[9], dy[9], np.absolute(exactdy[9] - dy[9])))
    print("0.3\t%.20f\t%.20f\t%.20f" %(exactdy[29], dy[29], np.absolute(exactdy[29] - dy[29])))
    print("0.5\t%.20f\t%.20f\t%.20f" %(exactdy[49], dy[49], np.absolute(exactdy[49] - dy[49])))
    print("0.7\t%.20f\t%.20f\t%.20f" %(exactdy[69], dy[69], np.absolute(exactdy[69] - dy[69])))
    print("0.9\t%.20f\t%.20f\t%.20f" %(exactdy[89], dy[89], np.absolute(exactdy[89] - dy[89])))

    print("\nTweede afgeleide")
    print("x\tExact\t\t\tBenadering\t\tAfbreekfout")
    print("0.1\t%.20f\t%.20f\t%.20f" %(exactddy[9], ddy[9], np.absolute(exactddy[9] - ddy[9])))
    print("0.3\t%.20f\t%.20f\t%.20f" %(exactddy[29], ddy[29], np.absolute(exactddy[29] - ddy[29])))
    print("0.5\t%.20f\t%.20f\t%.20f" %(exactddy[49], ddy[49], np.absolute(exactddy[49] - ddy[49])))
    print("0.7\t%.20f\t%.20f\t%.20f" %(exactddy[69], ddy[69], np.absolute(exactddy[69] - ddy[69])))
    print("0.9\t%.20f\t%.20f\t%.20f" %(exactddy[89], ddy[89], np.absolute(exactddy[89] - ddy[89])))

    # xs = sp.linspace(0,2*sp.pi,100)
    # ys = S(xs)
    # yps = S.derivative()(xs)
    # ypps = S.derivative(2)(xs)
