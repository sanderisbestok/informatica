import numpy as np
import matplotlib.pyplot as plt

#
#
# x_1 = np.random.uniform(-1, 1, 10000)
# x_2 = np.random.uniform(-1, 1, 10000)
# plt.plot(x_1, x_2, 'o', markersize=1)
# plt.show()
#
# s_2 = x_1 + x_2
# plt.hist(s_2, 100, normed=True)
# plt.show()
#
#
#
# s_3 = np.sum(np.random.uniform(-1, 1, size = (10000, 3)) ,axis=1)
# s_5 = np.sum(np.random.uniform(-1, 1, size = (10000, 5)) ,axis=1)
# s_10 = np.sum(np.random.uniform(-1, 1, size = (10000, 10)) ,axis=1)
# plt.hist(s_3, 100, normed=True)
# plt.hist(s_5, 100, normed=True)
# plt.hist(s_10, 100, normed=True)
# plt.show()

sample_variance = ((1 + 1 + 1)**2 -1) / 12
i = np.linspace(0, 10, 10)
y = [x * sample_variance for x in i]

plt.plot(i,y)
plt.show()
