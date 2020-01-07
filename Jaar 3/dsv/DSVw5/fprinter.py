import matplotlib.mlab as ml
import matplotlib.pyplot as plt
import scipy.ndimage.morphology as morph
import scipy.ndimage.filters as filters
import numpy as np
import wavio
import hashlib

amplitude_threshold = 30


class FingerPrinter(object):

    def find_peak_index(self, t, range, peaks):
        i = 0
        for tt, _ in peaks:
            if tt > t + range and tt < t + range*2:
                return i
            else:
                i += 1
        return 0

    def fprint(self, filename, blocksize=4096):
        sr, sw, channels = wavio.readwav(filename)

        channel = np.mean(channels, axis=0) # Stereo to mono

        spec = ml.specgram(channel, Fs=sr, NFFT=blocksize,
                    noverlap=blocksize / 2)[0]
        np.seterr(divide='ignore')
        spec = 10 * np.log10(spec)
        spec[spec == -np.inf] = 0  # replace infs with zeros
        np.seterr(divide='warn')
        
        struct = morph.generate_binary_structure(2, 1)
        footprint = morph.iterate_structure(struct, 20)
        filt = filters.maximum_filter(spec, footprint=footprint)
        maxima = spec == filt

        background = (spec == 0)
        eroded_background = morph.binary_erosion(background,
                                structure=footprint, border_value=1)
        maxima = maxima - eroded_background

        f, t = np.where(maxima)

        amplitude = spec[maxima].flatten()
        amplitude = amplitude[amplitude != 0]

        # Filter only peaks with high amplitude
        best_peaks = []
        for t, f, a in zip(t, f, amplitude):
            if a > amplitude_threshold:
                best_peaks.append((t,f))

        # Sort best peaks by time
        peaks_sorted = sorted(best_peaks, key=lambda p: p[0])

        # Get peak pairs 
        pairs = set()
        for t, f in peaks_sorted:
            # get another peak that is close
            index = self.find_peak_index(t, 10, peaks_sorted)
            if index !=0:
                string = str(f) + str(peaks_sorted[index][1]) + str(peaks_sorted[index][0] - t)
                string = string.encode(encoding='UTF-8', errors='strict')
                pairs.add(hashlib.md5(string).hexdigest())
      
        return list(pairs)

            # fig, ax = plt.subplots()
            # ax.imshow(spec, aspect='auto')
            # ax.scatter(t, f)
            # ax.set_xlabel('Time')
            # ax.set_ylabel('Frequency')
            # ax.set_title("Spectrogram")
            # plt.gca().invert_yaxis()
            # plt.show()

