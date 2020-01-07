import numpy as np
import matplotlib.pyplot as plt
from mpl_toolkits.mplot3d.axes3d import Axes3D
from matplotlib import cm

def f(x,y):
    return 1/2 * (1-np.sin(2*x**2-y-1))

if __name__ == "__main__":
     x = np.linspace(-1.5, 1.5, 500)
     y = np.linspace(-1.5, 1.5, 500)
     x, y = np.meshgrid(x, y)
     z = f(x,y)
     fig = plt.figure()
     ax = fig.add_subplot(1,2,1, projection='3d')
     ax.contour(x, y, z, cmap=cm.coolwarm)
     ax.set_xlabel('$x$')
     ax.set_ylabel('$y$')
     ax.set_zlabel('$z$')
     ax.plot_surface(x, y, z, rstride=4, cstride=4, cmap=cm.coolwarm,
            linewidth=0, alpha=0.4)
     ax.view_init(35, 25)
     ax.set_zlim([-0.1, 1.1])

     ax2 = fig.add_subplot(1,2,2)
     ax2.contour(x, y, z, cmap=cm.coolwarm)
     ax2.set_xlabel('$x$')
     ax2.set_ylabel('$y$')
     plt.show()
