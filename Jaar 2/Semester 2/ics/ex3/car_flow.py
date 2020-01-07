import numpy as np
import matplotlib.pyplot as plt
import ca
import csv

def find_flow(density, T, N):
    """This function will return the flow (of cars per time unit) of a CA
    simulation for cars."""

    cela = ca.CASim()
    cela.width = N
    cela.height = T
    cela.density = density
    cela.reset()
    cars = 0

    for i in range(T):
        if (cela.config[cela.t, cela.width - 1] == 1 and
            cela.config[cela.t, 0] == 0):
            cars += 1
        cela.step()

    return float(cars) / float(T)


if __name__ == '__main__':
    N = 50
    T = 1000
    R = 10
    density_values = 40

    density = np.linspace(0, 1, density_values)
    flow = np.zeros(density_values)

    with open('density_flow.csv', 'w') as csvfile:
        writer = csv.writer(csvfile, delimiter=' ',
                                quotechar='|', quoting=csv.QUOTE_MINIMAL)

        for i, dens in enumerate(density):
            for _ in range(R):
                flow[i] += find_flow(dens, T, N)
            flow[i] = flow[i] / float(R)
            writer.writerow([dens, flow[i]])
            print(i)

    ax = plt.subplot(1, 1, 1)

    plt.plot(density, flow, 'o', color='black')
    ax.get_xaxis().tick_bottom()
    ax.get_yaxis().tick_left()
    plt.axis([0.0, 1.0, 0.0, 1.0])
    plt.title('Flow of cars with certain density')
    plt.xlabel('Density')
    plt.ylabel('Flow per time unit')

    plt.show()
