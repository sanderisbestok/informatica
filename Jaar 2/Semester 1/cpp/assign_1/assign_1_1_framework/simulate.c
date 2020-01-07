/*
 * simulate.c
 * Sander Hansen 10995080
 * Bas van Berckel 10343725
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <pthread.h>

#include "simulate.h"


/* Add any global variables you may need. */
pthread_mutex_t lock = PTHREAD_MUTEX_INITIALIZER;
pthread_cond_t  wait = PTHREAD_COND_INITIALIZER;
double *old, *current, *next, *temp;
int occupied;

typedef struct parameters {
	int id;
    int i_max;
    int num_threads;
    int t_max;
} parameters;

void swap_buffers(void) {
    temp = old;
    old = current;
    current = next;
    next = temp;

    return;
}

/* Worker function, this function can be called parallel */
void *worker(void *args) {
    parameters p = *((parameters *) args);
    int thread_length, start, stop;

    thread_length = p.i_max / p.num_threads;

	/* Change i start and i stop accordingly to the id of the thread */
    if (p.id == 0) {
        start = 1;
    } else {
        start = p.id * thread_length;
    }

    if (p.id == (p.num_threads - 1)) {
        stop = p.i_max - 1;
    } else {
        stop = (p.id + 1) * thread_length;
    }

	/* Calculate the wave */
	for (int t = 0; t < p.t_max; t++) {
        for (int i = start; i < stop; i++) {
            next[i] = ((2 * current[i]) - old[i] + (0.15 * (current[i - 1] -
                      (2 * current[i] - current[i + 1]))));
        }

		/* Let threads wait, if last thread swap buffers and release the lock */
        pthread_mutex_lock(&lock);
        occupied++;
        if (occupied < p.num_threads) {
            pthread_cond_wait(&wait, &lock);
        } else {
            swap_buffers();
            occupied = 0;
            pthread_cond_broadcast(&wait);
        }
        pthread_mutex_unlock(&lock);
    }

    return NULL;
}

/*
 * Executes the entire simulation.
 *
 *
 * i_max: how many data points are on a single wave
 * t_max: how many iterations the simulation should run
 * num_threads: how many threads to use (excluding the main threads)
 * old_array: array of size i_max filled with data for t-1
 * current_array: array of size i_max filled with data for t
 * next_array: array of size i_max. You should fill this with t+1
 */
double *simulate(const int i_max, const int t_max, const int num_threads,
        double *old_array, double *current_array, double *next_array)
{
    pthread_t thread_ids[num_threads];

	/* Set globals */
    old = old_array;
    current = current_array;
    next = next_array;
    occupied = 0;

	/* Create a thread with parameters */
    for (int j = 0; j < num_threads; j++) {
        parameters *parameter = malloc(sizeof(parameters));
		parameter->id = j;
        parameter->num_threads = num_threads;
        parameter->i_max = i_max;
        parameter->t_max = t_max;

        pthread_create(&thread_ids[j], NULL, &worker, (void *)parameter);
    }

    /* Join pthreads to close them */
    for (int j = 0; j < num_threads; j++){;
        pthread_join(thread_ids[j], NULL);
    }

    /* You should return a pointer to the array with the final results. */
    return current_array;
}
