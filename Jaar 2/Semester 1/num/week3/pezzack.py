import numpy as np
import matplotlib.pyplot as plt

if __name__ == "__main__":
    tijd, hoek, hoek2, a_analoog = np.loadtxt('Pezzack.txt', skiprows=6, unpack=True)
    plt.figure(figsize=(11,4))
    plt.suptitle("Pezzack's benchmark data", fontsize=20)

    dy = np.convolve(hoek2, [1, -2, 1], "same") / (((tijd[len(tijd) - 1]) / len(tijd))**2)
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
