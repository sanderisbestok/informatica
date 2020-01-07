import numpy as np
import matplotlib.pyplot as plt
import matplotlib.mlab as ml

def vgem(data, filterwidth):
    resultlist = np.zeros(shape=(701, 2), dtype=[("tijd", "<f8"),("emg", "<f8")])
    i = 0
    for _ in data:
        result = 0.0
        for j in range(-filterwidth, filterwidth + 1):
            try:
                result += data["emg"][i + j]
            except:
                print("out of bounds")
        resultlist["tijd"][i] = data["tijd"][i]
        resultlist["emg"][i] = (1 / ((2 * filterwidth) + 1) * result)
        i += 1
    return resultlist

def RMS(data, filterwidth):
    resultlist = np.zeros(shape=(701, 2), dtype=[("tijd", "<f8"),("emg", "<f8")])
    i = 0
    for _ in data:
        result = 0.0
        for j in range(-filterwidth, filterwidth + 1):
            try:
                result += ((data["emg"][i + j])**2)
            except:
                print("out of bounds")
        resultlist["tijd"][i] = data["tijd"][i]
        resultlist["emg"][i] = np.sqrt(1/(2 * filterwidth + 1)* result)
        i += 1
    return resultlist


if __name__ == "__main__":
    data = ml.csv2rec('emg.csv', delimiter=';', names=['tijd', 'emg'])
    print(data.dtype)

    fig = plt.figure()
    fig.canvas.set_window_title("EMG signaal")

    total = 0
    for i in range(299, 1000):
        total += data["emg"][i]

    average = total / 701

    workingdata = np.zeros(shape=(701, 2), dtype=[("tijd", "<f8"),("emg", "<f8")])
    absdata = np.zeros(shape=(701, 2), dtype=[("tijd", "<f8"),("emg", "<f8")])
    for i in range(299, 1000):
        workingdata["emg"][i - 299] = (data["emg"][i] - average)
        workingdata["tijd"][i - 299] = (data["tijd"][i])
        absdata["emg"][i - 299] = np.absolute((data["emg"][i] - average))
        absdata["tijd"][i - 299] = (data["tijd"][i])


    vgem = vgem(absdata, 25)
    rms = RMS(absdata, 25)



    plt.plot(data["tijd"], data["emg"], 'k')
    plt.plot(vgem["tijd"], vgem["emg"], 'r')
    plt.plot(rms["tijd"], rms["emg"], 'b')
    plt.axis([0.3, 1, -0.15, 0.15])
    plt.title("EMG")
    plt.xlabel('tijd (s)')
    plt.ylabel('amplitude')
    plt.legend(['data', "ARV", "RMS"])
    plt.show()
