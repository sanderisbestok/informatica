import numpy as np
import matplotlib.pyplot as plt

def standard_normal_pdf(x):
    return np.e**(-0.5 * (x**2)) / np.sqrt(2 * np.pi)

def normal_pdf(x, mu, sigma):
    return standard_normal_pdf((x- mu) * 1/sigma) * 1/sigma

x = np.linspace(-5, 5, 101)
y = standard_normal_pdf(x)

plt.plot(x,y)
plt.show()

x = np.linspace(-10, 10, 101)
y = normal_pdf(x, 3, 4)
plt.plot(x,y)
plt.show()
