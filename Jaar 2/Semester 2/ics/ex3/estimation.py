import numpy as np
import matplotlib.pyplot as plt
import car_flow

def get_flow(xvals):
    """This function will return the interpolated flow per density"""
    density_flow = np.genfromtxt('density_flow.csv', delimiter=' ')

    density_flow = np.swapaxes(density_flow, 0, 1)
    density = density_flow[0]
    flow = density_flow[1]


    # Density per Flow
    interp_flow = np.interp(xvals, density, flow)

    return(interp_flow)

if __name__ == '__main__':
    xvals = np.linspace(0.0, 1.0, 1000)

    flow = get_flow(xvals)
    critical_i = np.argmax(flow)
    critical = xvals[critical_i]

    N = 50
    R = 10
    density_values = 40

    density = np.linspace(0, 1, density_values)
    T_array = np.arange(71)
    prob = np.zeros(71)

    for T in range(1, 71):
        print(T)
        for _ in range(10):
            flow = np.zeros(density_values)
            for i, dens in enumerate(density):
                for _ in range(R):
                    flow[i] += car_flow.find_flow(dens, T, N)
                flow[i] = flow[i] / float(R)
            if abs(density[np.argmax(flow)] - critical) < 0.05:
                prob[T - 1] += 0.1

    ax = plt.subplot(1, 1, 1)

    plt.plot(T_array, prob, 'o', color='black')
    ax.get_xaxis().tick_bottom()
    ax.get_yaxis().tick_left()
    plt.axis([0.0, 70.0, 0.0, 1.0])
    plt.title('Probability of a correct critical density')
    plt.xlabel('T')
    plt.ylabel('Probability')

    plt.show()
