import numpy as np
import matplotlib.pyplot as plt


n = np.random.uniform(-1,1,10000)
plt.hist(n, 100, normed=True)
plt.show()
