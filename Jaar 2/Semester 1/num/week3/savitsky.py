import numpy as np
import matplotlib.pyplot as plt
import scipy as sp
from scipy.signal import savgol_filter
from scipy.interpolate import UnivariateSpline

if __name__ == "__main__":
    tijd, hoek, hoek2, a_analoog = np.loadtxt('Pezzack.txt', skiprows=6, unpack=True)
    plt.figure(figsize=(11,4))
    plt.suptitle("Pezzack's benchmark data", fontsize=20)

    #TODO vraag over stellen in werkcollege, maar was hier te laat voor ivm deadline
    dy = savgol_filter(hoek2,5,3,deriv=1,delta=(((tijd[len(tijd) - 1]) / len(tijd))))
    dy2 = UnivariateSpline(tijd, hoek2,k=5, s=0.0005)
    # plt.plot(tijd, hoek, 'b-')
    # plt.xlabel('tijd (s)', fontsize=12)
    # plt.ylabel('hoek (rad)', fontsize=12)
    # plt.subplot(1,2,2)
    plt.plot(tijd, a_analoog, 'g-')
    plt.plot(tijd, dy, 'r-')
    plt.xlabel('tijd (s)')
    plt.ylabel('versnelling (rad/s$^2$)', fontsize=12)
    plt.subplots_adjust(wspace=0.3)
    plt.show()
