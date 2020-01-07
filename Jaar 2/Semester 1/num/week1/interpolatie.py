import numpy as np
import matplotlib.pyplot as plt
import scipy.interpolate as ip
import math

def f(t):
    return 1/(math.pow(t,2)+1)

def interpolation(graad):
    twaarde = (10 / (graad))
    x = -5

    xlijst = []
    ylijst = []

    for i in range(graad + 1):
        xlijst.append(x)
        x += twaarde

    for x in xlijst:
        ylijst.append(f(x))

    function = lagrange(xlijst, ylijst)
    steps = np.arange(-5, 5, 0.1)
    yvalues = function(steps)

    return steps, yvalues


def lagrange(xlijst, ylijst):
    length = len(xlijst)
    def calculation(t):
        value = 0
        for i in range(length):
            temp = 1
            for j in range(length):
                if i != j:
                    temp *= ((t - xlijst[j]) / (xlijst[i] - xlijst[j]))
            value += (temp * ylijst[i])
        return value
    return calculation



if __name__ == "__main__":
    n = 5
    x1, y1 = interpolation(6)
    x2, y2 = interpolation(14)
    x3, y3 = interpolation(n)


    fig = plt.figure()
    plt.plot(x1, y1, 'r-', x2, y2, 'g-',x3, y3, 'b-')
    plt.axis([-5, 5, -5, 5])
    plt.xlabel("t")
    plt.ylabel("y")
    plt.title("Lagrange")
    plt.show()
    fig.savefig("grafieken.png")


    # t = np.array([0,1,4], float)
    # y = f(t)
    # g1 = ip.interp1d(t,y, kind='linear')
    # g2 = ip.interp1d(t,y, kind='quadratic')
    # tnew = np.arange(0,4.1,0.1)
    # ynew = f(tnew)
    # ynew1 = g1(tnew) # lineaire interpolatiefunctie van interp1d
    # ynew2 = g2(tnew) # kwadratische interpolatiefunctie van interp1d
    #
    #
    #
    # # Plot de grafieken
    # fig = plt.figure()
    # plt.plot(t,y, 'o', tnew, ynew1, 'r-', tnew, ynew2, 'g-', tnew, ynew, 'b-')
    # plt.axis([-.1, 4.1, -6.5, 6.5])
    # plt.xlabel('t')
    # plt.ylabel('y')
    # plt.legend(['punten', 'lineair', 'kwadratisch','kubisch'], loc=4)
    # plt.title('interpolatie')
    # plt.show()
    # fig.savefig('grafieken.png')
