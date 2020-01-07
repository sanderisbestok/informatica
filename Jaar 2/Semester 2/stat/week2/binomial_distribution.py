import numpy as np
import matplotlib.pyplot as plt


def binomial(n, j, p):
    return (np.math.factorial(n) / (np.math.factorial(j) * np.math.factorial(n-j))) * (p**j) * (1-p)**(n-j)

x = np.linspace(0, 20, 21)
y_1 = [binomial(20, i, 0.25) for i in x]
y_2 = [binomial(20, i, 0.5) for i in x]
y_3 = [binomial(20, i, 0.75) for i in x]

plt.figure(figsize=(16,8), facecolor='white')
plt.plot(x,y_1, x, y_2, x, y_3)
plt.legend(['p = 0.25', 'p = 0.5', 'p = 0.75'])
plt.show()


h = np.linspace(0, 300, 301)
for n in [300, 400, 500]:
    results = [binomial(n, k, 0.5) for k in h]
    print('n is = ' + str(n) + ' result is: ' + str(sum(results)))
