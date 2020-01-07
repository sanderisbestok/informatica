import numpy as np
import matplotlib.pyplot as plt

def f_PDF(x):
    if x <= 9 and x >= 3:
        return 1/6
    return 0

def f_UDF(x):
    if x <= 9 and x >= 3:
        return (x-3) / 6
    elif x > 9:
        return 1

    return 0

t = np.linspace(-1,12, 500)
y_1 = [f_PDF(i) for i in t]
y_2 = [f_UDF(i) for i in t]

plt.figure(figsize=(16,8), facecolor='white')
plt.subplot(1,2,1)
plt.axis([-1,12,-0.2,1.2])
plt.title('Probability Density Function')
plt.plot(t,y_1)

plt.subplot(1,2,2)
plt.axis([-1,12,-0.2,1.2])
plt.plot(t,y_2)
plt.title('Cumulative Uniform Distribution')
plt.show()
