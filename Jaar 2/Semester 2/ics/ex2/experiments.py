import numpy as np
import matplotlib.pyplot as plt
import math
import ca

def shannon_entropy(l, method):
    """This function will calculate the shannon entropy of a certain rule """
    cela = ca.CASim(2, 3, l)
    cela.width = 10
    cela.height = 55
    cela.reset(True)
    cela.random_table = method

    for i in range(50):
        cela.step()

    entropy = 0
    length = cela.k ** (2 * cela.r + 1)
    entropy_array = np.zeros(length)

    for patch in range(cela.width):
        indices = [i % cela.width
                   for i in range(patch - cela.r, patch + cela.r + 1)]
        values = cela.config[cela.t - 1, indices]
        decimal = int(ca.base_k_to_decimal(cela.k, values))
        entropy_array[decimal] += 1

    for neighbour in entropy_array:
        if neighbour:
            entropy += ((neighbour / float(cela.width)) *
                        (math.log((neighbour / float(cela.width)), 2)))

    return entropy * -1

if __name__ == '__main__':
    plot_array = np.linspace(0, 1, 1000)
    entropy_array = np.empty(1000)

    for index, number in enumerate(plot_array):
        print(number)
        entropy_array[index] = shannon_entropy(number, True)

    ax = plt.subplot(2, 1, 1)

    plt.plot(plot_array, entropy_array, 'o', color='black')
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    ax.get_xaxis().tick_bottom()
    ax.get_yaxis().tick_left()
    plt.axis([0.0, 1.0, 0.0, 4])
    plt.title('Shannon Entropy with Random Table')
    plt.xlabel('Lambda')
    plt.ylabel('Shannon entropy')
    entropy_array = np.empty(1000)

    for index, number in enumerate(plot_array):
        print(number)
        entropy_array[index] = shannon_entropy(number, False)

    ax = plt.subplot(2,1,2)

    plt.plot(plot_array, entropy_array, 'o', color='black')
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    ax.get_xaxis().tick_bottom()
    ax.get_yaxis().tick_left()

    plt.axis([0.0, 1.0, 0.0, 4])
    plt.title('Shannon Entropy with Table Walkthrough')
    plt.xlabel('Lambda')
    plt.ylabel('Shannon entropy')
    plt.show()
