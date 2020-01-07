import numpy as np
import matplotlib.pyplot as plt
import matplotlib.mlab as ml

if __name__ == "__main__":
    data = ml.csv2rec('bierkraag.csv', delimiter=';')
    dtype = [('tijd', '<i4'), ('hoogte', '<i4')]

    fig = plt.figure()
    fig.canvas.set_window_title("Bierkaag hoogte")

    plt.plot(data["tijd"], data["hoogte"], 'ro')
    plt.axis([0, 300, 5, 13])
    plt.title("Hoogte van bierkraag")
    plt.xlabel('H (cm)')
    plt.ylabel('t (s)')
    plt.legend(['H'])
    plt.show()
