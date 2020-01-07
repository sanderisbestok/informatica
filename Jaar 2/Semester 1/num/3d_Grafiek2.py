import numpy as np
import matplotlib.pyplot as plt
from mpl_toolkits.mplot3d.axes3d import Axes3D
from matplotlib import cm

def f(x,y):
    return np.log(np.sqrt((x+1)**2+y**2)) - np.log(np.sqrt((x-1)**2+y**2))

if __name__ == "__main__":
    x = np.linspace(-2, 2, 100)
    y = np.linspace(-1, 1, 100)
    x, y = np.meshgrid(x, y)
    z = f(x,y)
    fig = plt.figure(figsize=(14,5))
    ax1 = fig.add_subplot(1,2,1)
    ax1.contour(x, y, z, 20, cmap=cm.coolwarm)
    ax1.set_xlabel('$x$')
    ax1.set_ylabel('$y$')
    ax2 = fig.add_subplot(1,2,2)
    p2 = ax2.contourf(x, y, z, 20, cmap=cm.coolwarm)
    fig.colorbar(p2)
    ax2.set_xlabel('$x$')
    ax2.set_ylabel('$y$')
    plt.show()
