#Pylab inline is not a good habit to use
import numpy
import matplotlib
import cv2

from matplotlib import pylab, mlab, pyplot
np = numpy
plt = pyplot

from IPython.core.pylabtools import figsize, getfigs
from skimage.transform import matrix_transform
from skimage.transform import SimilarityTransform

from pylab import *
from numpy import *

from skimage.transform import warp

# Points need to be given in the following manner: [x, y, newX, newY]
def perspectiveTransformMatrix(points):
    M = np.zeros([2 * points.shape[0],9])

    for i in range(points.shape[0]):
            M[i * 2] = points[i][0], points[i][1], 1, 0, 0, 0, -points[i][2] * points[i][0], \
                       -points[i][2] * points[i][1], -points[i][2]
            M[i * 2 + 1] = 0, 0, 0, points[i][0], points[i][1], 1, -points[i][3] * points[i][0], \
                           -points[i][3] * points[i][1], -points[i][3]

    _, _, V = np.linalg.svd(M)

    p = V[-1]
    A = p.reshape(3, 3)

    return A

def fit_image(f1, f2, P):
    tx = 0
    ty = 0

    xy1 = matrix_transform([0, 0], np.linalg.inv(P))
    xy2 = matrix_transform([0, f2.shape[0]], np.linalg.inv(P))
    xy3 = matrix_transform([f2.shape[1], f2.shape[0]], np.linalg.inv(P))
    xy4 = matrix_transform([f2.shape[1], 0], np.linalg.inv(P))

    x_min = min(xy1[0][0], xy2[0][0], xy3[0][0], xy4[0][0], 0)
    x_max = max(xy1[0][0], xy2[0][0], xy3[0][0], xy4[0][0], f1.shape[1])
    y_min = min(xy1[0][1], xy2[0][1], xy3[0][1], xy4[0][1], 0)
    y_max = max(xy1[0][1], xy2[0][1], xy3[0][1], xy4[0][1], f1.shape[0])

    x = int(x_max - x_min)
    y = int(y_max - y_min)

    if y_min < 0:
        ty = y_min
    if x_min < 0:
        tx = x_min

    f_stitched = warp(f2, P, output_shape=(y,x))
    M, N = f1.shape[:2]
    f_stitched[0:M, 0:N, :] = f1
    tform = SimilarityTransform(translation=(tx, ty))
    warped = warp(f_stitched, tform)
    plt.imshow(warped); plt.axis('off')
    plt.show()

def return_matches(f1, f2):
    f1cv2 = f1[:,:,::-1] # OpenCV uses BGR ordering of color channels
    f2cv2 = f2[:,:,::-1] # OpenCV uses BGR ordering of color channels

    sift = cv2.xfeatures2d.SIFT_create()

    kps1, dscs1 = sift.detectAndCompute(f1cv2, mask=None)
    kps2, dscs2 = sift.detectAndCompute(f2cv2, mask=None)

    matcher = cv2.BFMatcher()
    matches = matcher.match(dscs1,dscs2)

    return matches, kps1, kps2

def get_random(points, n):
    ind = np.arange(points.shape[0])
    np.random.shuffle(ind)

    h_inliers = ind[:n]
    h_model = ind[n:]

    return points[h_inliers], points[h_model]

def get_error(P, h_inliers, h_model, b_error, b_model):
    inliers = np.array([])

    for i in h_model:
        new_pos = matrix_transform([i[0], i[1]], P)
        error = np.linalg.norm([i[2], i[3]] - new_pos)

        if error < t:
            inliers = np.append(inliers, i)

    if (inliers.shape[0] / 4) > d:
        inliers = np.append(inliers, h_inliers)
        inliers = inliers.reshape(((int(inliers.shape[0] / 4), 4)))
        P2 = perspectiveTransformMatrix(inliers)

        for i in h_model:
            new_pos = matrix_transform([i[0], i[1]], P)
            error += np.linalg.norm([i[2], i[3]] - new_pos)
            error = error / inliers.shape[0]

        if error < b_error:
            print("Found better match")
            b_error = error
            b_model =  P2

    return b_model, b_error

def ransac(points, n, k, t, d):
    b_error = 1000000000
    b_model = 0

    for _ in range(k):
        h_inliers, h_model = get_random(points, n)
        P = perspectiveTransformMatrix(h_inliers)
        b_model, b_error = get_error(P, h_inliers, h_model, b_error, b_model)

    return b_model


if __name__ == "__main__":
    n = 4
    k = 1000
    t = 5
    d = 10

    # First image stitch
    f1 = plt.imread('img/nachtwacht1.jpg')
    f2 = plt.imread('img/nachtwacht2.jpg')

    matches, kps1, kps2 = return_matches(f1, f2)
    points = np.array([])

    for m in matches:
         points = np.append(points,
                            [kps1[m.queryIdx].pt[0], kps1[m.queryIdx].pt[1], \
                            kps2[m.trainIdx].pt[0], kps2[m.trainIdx].pt[1]])

    points = points.reshape(((int(points.shape[0] / 4), 4)))

    ransac_p = ransac(points, n, k, t, d)

    f1 = f1/255
    f2 = f2/255

    fit_image(f1, f2, ransac_p)


    # Second image stitch
    f3 = plt.imread('img/links.jpg')
    f4 = plt.imread('img/rechts.jpg')

    matches, kps1, kps2 = return_matches(f3, f4)
    points = np.array([])

    for m in matches:
         points = np.append(points,
                            [kps1[m.queryIdx].pt[0], kps1[m.queryIdx].pt[1], \
                            kps2[m.trainIdx].pt[0], kps2[m.trainIdx].pt[1]])

    points = points.reshape(((int(points.shape[0] / 4), 4)))

    ransac_p = ransac(points, n, k, t, d)

    f3 = f3/255
    f4 = f4/255

    fit_image(f3, f4, ransac_p)
