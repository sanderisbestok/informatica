/*
 * simulate.c
 * Sander Hansen 10995080
 * Bas van Berckel 10343725
 */

#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <string.h>
#include <iostream>
#include "simulate.hpp"

using namespace std;

/* Utility function, use to do error checking.

   Use this function like this:

   checkCudaCall(cudaMalloc((void **) &deviceRGB, imgS * sizeof(color_t)));

   And to check the result of a kernel invocation:

   checkCudaCall(cudaGetLastError());
*/
static void checkCudaCall(cudaError_t result) {
    if (result != cudaSuccess) {
        cerr << "cuda error: " << cudaGetErrorString(result) << ": " << result << endl;
        exit(1);
    }
}


__global__ void waveStepKernel(double* deviceCur, double* deviceOld, double* deviceNext, int i_max) {
    unsigned index = blockIdx.x * blockDim.x + threadIdx.x;
    if(!index || index >= i_max - 1) {
        deviceNext[index] = 0;
    } else {
        deviceNext[index] = (2 * deviceCur[index]) - deviceOld[index] + (0.15 *
                            (deviceCur[index - 1] - (2 * deviceCur[index] -
                            deviceCur[index + 1])));
    }
}


/*
 * Executes the entire simulation.
 *
 *
 * i_max: how many data points are on a single wave
 * t_max: how many iterations the simulation should run
 * num_threads: how many threads to use
 * old_array: array of size i_max filled with data for t-1
 * current_array: array of size i_max filled with data for t
 * next_array: array of size i_max. You should fill this with t+1
 */

double *simulate(const int i_max, const int t_max, const int threadBlockSize,
        double *old_array, double *current_array, double *next_array)
{

    // allocate the vectors on the GPU
    double* deviceOld = NULL;
    checkCudaCall(cudaMalloc((void **) &deviceOld, i_max * sizeof(double)));
    if (deviceOld == NULL) {
        cout << "could not allocate memory!" << endl;
        return NULL;
    }
    double* deviceCur = NULL;
    checkCudaCall(cudaMalloc((void **) &deviceCur, i_max * sizeof(double)));
    if (deviceCur == NULL) {
        checkCudaCall(cudaFree(deviceOld));
        cout << "could not allocate memory!" << endl;
        return NULL;
    }
    double* deviceNext = NULL;
    checkCudaCall(cudaMalloc((void **) &deviceNext, i_max * sizeof(double)));
    if (deviceNext == NULL) {
        checkCudaCall(cudaFree(deviceOld));
        checkCudaCall(cudaFree(deviceCur));
        cout << "could not allocate memory!" << endl;
        return NULL;
    }

    cudaEvent_t start, stop;
    cudaEventCreate(&start);
    cudaEventCreate(&stop);

    // copy the original vectors to the GPU
    checkCudaCall(cudaMemcpy(deviceOld, old_array, i_max*sizeof(double), cudaMemcpyHostToDevice));
    checkCudaCall(cudaMemcpy(deviceCur, current_array, i_max*sizeof(double), cudaMemcpyHostToDevice));

	double *temp;

	int t;
    cudaEventRecord(start, 0);
	for (t = 0; t < t_max; t++) {
		waveStepKernel<<<i_max/threadBlockSize, threadBlockSize>>>(deviceCur, deviceOld, deviceNext, i_max);
        checkCudaCall(cudaGetLastError());
        cudaDeviceSynchronize();
        /* Swap buffers */
        temp = deviceOld;
        deviceOld = deviceCur;
        deviceCur = deviceNext;
        deviceNext = temp;
	}
    cudaEventRecord(stop, 0);

    // print the time the kernel invocation took, without the copies!
    float elapsedTime;
    cudaEventElapsedTime(&elapsedTime, start, stop);

    checkCudaCall(cudaMemcpy(current_array, deviceCur, i_max * sizeof(double), cudaMemcpyDeviceToHost));

    checkCudaCall(cudaFree(deviceOld));
    checkCudaCall(cudaFree(deviceCur));
    checkCudaCall(cudaFree(deviceNext));

    cout << "Wave simulation took " << elapsedTime << " milliseconds with blocksize " << threadBlockSize << endl;

    return current_array;
}
