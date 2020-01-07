#Pylab inline is not a good habit to use
import numpy
import matplotlib
import cv2
import wget
import imageio
import skimage.color

from matplotlib import pylab, mlab, pyplot
from skimage.feature import match_template
from pylab import *
from numpy import *
from os.path import isfile
from pprint import pprint

np = numpy
plt = pyplot

def get_video():
    plt.ion()

    if not isfile('ball2.mp4'):
        print('Downloading the video')
        imageio.plugins.ffmpeg.download()
        wget.download('https://staff.fnwi.uva.nl/r.vandenboomgaard/IPCV20162017/_static/ball2.mp4')
    reader = imageio.get_reader('ball2.mp4')

    pprint(reader.get_meta_data())

    return reader



def show_video(reader):
    img = None
    txt = None
    for i in range(40,350):
       im = reader.get_data(i)
       if img is None:
           img = plt.imshow(im)
       else:
           img.set_data(im)

       plt.pause(0.01)
       plt.draw()


def get_template(reader):
    image = reader.get_data(40)
    template = image[275:325, 75:120]

    template = skimage.color.rgb2gray(template)
    image = skimage.color.rgb2gray(image)
    plt.imshow(image, cmap=plt.cm.gray)
    plt.show()
    plt.imshow(template, cmap=plt.cm.gray)
    plt.show()

    return template


def get_locations(reader, template):
    locations = []

    for i in range(40,350):
        im = reader.get_data(i)
        image = skimage.color.rgb2gray(im)

        result = match_template(image, template)
        locations.append(argmax(result))

    index = np.unravel_index(locations, result.shape)

    return index


if __name__ == "__main__":
    reader = get_video()
    show_video(reader)
