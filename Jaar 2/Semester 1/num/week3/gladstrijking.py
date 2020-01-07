import numpy as np
import matplotlib.pyplot as plt
import matplotlib.mlab as ml

def gladstrijking(data, parameter):
    resultlist = np.copy(data)

    # resultlist["hoogte"][0] = parameter * resultlist["hoogte"][0]
    resultlist["hoogte"][0] = resultlist["hoogte"][0]

    for i in range(1, len(resultlist)):
        resultlist["hoogte"][i] = ((parameter * resultlist["hoogte"][i]) + ((1 - parameter) * resultlist["hoogte"][i - 1]))
    return resultlist

def gladstrijkingachter(data, parameter):
    resultlist = np.copy(data)
    length = len(resultlist) - 1

    # resultlist["hoogte"][0] = parameter * resultlist["hoogte"][0]
    resultlist["hoogte"][length] = resultlist["hoogte"][length]

    for i in range(1, len(resultlist)):
        resultlist["hoogte"][length - i] = ((parameter * resultlist["hoogte"][length - i]) + ((1 - parameter) * resultlist["hoogte"][length - i + 1]))
    return resultlist

if __name__ == "__main__":
    data = ml.csv2rec('bierkraag.csv', delimiter=';')
    dtype = [('tijd', '<i4'), ('hoogte', '<i4')]

    filter1 = gladstrijking(data, 0.5)
    filter2 = gladstrijkingachter(data, 0.5)


    fig = plt.figure()
    fig.canvas.set_window_title("Exponentiele gladstrijking")
    plt.plot(data["tijd"], data["hoogte"], 'rx')
    plt.plot(filter1["tijd"], filter1["hoogte"], 'b')
    plt.plot(filter2["tijd"], filter1["hoogte"], 'g')

    plt.axis([0, 300, 5, 13])
    plt.title("EMG")
    plt.xlabel('tijd (s)')
    plt.ylabel('hoogte (cm)')
    plt.legend(['data'])
    plt.show()
