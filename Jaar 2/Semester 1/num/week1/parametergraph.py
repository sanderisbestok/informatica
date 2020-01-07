import numpy as np
import matplotlib.pyplot as plt

def ber_x(t):
    return (np.cos(t) / (1 + np.sin(t)**2))

def ber_y(t):
    return ((np.cos(t)*np.sin(t)) / (1 + np.sin(t)**2))

def blad_x(t):
    return (R(t) * np.cos(t))

def blad_y(t):
    return (R(t) * np.sin(t))

def R(t):
    return (S(t) * (2 - np.sin(7*t) - 0.5 * np.cos(30*t)))

def S(t):
    return (100 / (100 + (t - 0.5 * np.pi)**8))

if __name__ == "__main__":
    t = np.linspace(-np.pi, np.pi, 1000)

    x = ber_x(t)
    y = ber_y(t)

    t = np.linspace((-0.5 * np.pi), ( (3/2) * np.pi), 1000)
    xblad = blad_x(t)
    yblad = blad_y(t)

    aspect = 2 / (np.abs(np.amin(y)) + np.abs(np.amax(y)))


    fig = plt.figure(figsize=(5,10))
    fig.canvas.set_window_title("Bernoulli en het blad")

    ax = fig.add_subplot(2,1,1)
    ax.set_aspect(aspect)
    plt.plot(x, y, 'r-')
    plt.title("Bernoulli")
    ax.spines["left"].set_position("center")
    ax.spines['bottom'].set_position('center')
    ax.spines['right'].set_color('none')
    ax.spines['top'].set_color('none')
    ax.xaxis.set_ticks_position('bottom')
    ax.yaxis.set_ticks_position('left')
    plt.axis([-1, 1, np.amin(y), np.amax(y)])

    ax = fig.add_subplot(2,1,2)
    ax.set_aspect("equal")
    plt.plot(xblad, yblad, 'r-')
    plt.title("Blad")
    ax.spines["left"].set_position("center")
    ax.spines['bottom'].set_position('center')
    ax.spines['right'].set_color('none')
    ax.spines['top'].set_color('none')
    ax.xaxis.set_ticks_position('bottom')
    ax.yaxis.set_ticks_position('left')
    plt.axis([np.amin(xblad), np.amax(xblad), np.amin(yblad), np.amax(yblad)])

    plt.show()
