import numpy as np
import matplotlib.pyplot as plt
import ca

def find_cycle(rule):
    """This function will find the correct cycle length for every wolfram CA
    the width and height can be set in this function. If no cycle length has
    been found it will return 0"""

    cela = ca.CASim()
    cela.width = 15
    cela.height = 10
    cela.rule = rule
    cela.reset(False)

    results = {}
    results[np.array_str(cela.config[0])] = 0
    cela.step()
    t = 1

    while True:
        if(t == 10):
            cycle_length = 0
            break
        elif(np.array_str(cela.config[t]) in results):
            cycle_length = (t - results[np.array_str(cela.config[t])])
            break
        results[np.array_str(cela.config[t])] = t
        cela.step()
        t += 1

    return cycle_length

if __name__ == '__main__':
    results = np.empty(257)
    for i in range(256):
        print(i)
        for j in range(9):
             results[i] += find_cycle(i)
        results[i] = find_cycle(i) // 10

    index = np.arange(257)

    fig, ax = plt.subplots()
    bar = ax.bar(index, results, 0.5, color='b')
    plt.axis([0, 257, 0, np.amax(results)])
    ax.set_ylabel('Average cycle length')
    ax.set_xlabel('Wolfram Rule')
    ax.set_title('Average cycle length')
    plt.show()
