import numpy as np;
import matplotlib.pylab as plt
import scipy.special

def standard_normal_cdf(x):
    return 0.5 * (1 + scipy.special.erf(x/np.sqrt(2)))

def normal_cdf(x, mu, sigma):
    return standard_normal_cdf((x - mu) / sigma)

x = np.linspace(-5, 5,1000)

plt.plot(x, standard_normal_cdf(x));
plt.show()

plt.plot(x, normal_cdf(x, 2,3))
plt.show()
