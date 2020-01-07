import matplotlib as mpl
from mpl_toolkits.mplot3d import Axes3D
import numpy as np
import matplotlib.pyplot as plt

def f(t):
    return (t * np.cos(t), t * np.sin(t), (1/5 * t))

if __name__ == "__main__":
    fig = plt.figure()
    ax = fig.gca(projection='3d')
    t = np.linspace(0, 50, 250)
    x, y, z = f(t)

    ax.scatter(x, y, z, c = (256 * z/max(z)))

    plt.show()
