/*
 * simulate.c
 *
 * MPI implementation of the wave equation
 *
 * Sander Hansen 10995080
 * Bas van Berckel 10735917
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <mpi.h>

#include "simulate.h"

/*
 * Executes the entire simulation.
 *
 * i_max: how many data points are on a single wave
 * t_max: how many iterations the simulation should run
 * old_array: array of size i_max filled with data for t-1
 * current_array: array of size i_max filled with data for t
 * next_array: array of size i_max. You should fill this with t+1
 */
double *simulate(int argc, char *argv[], const int i_max, const int t_max,
                 double *old_array, double *current_array, double *next_array)
{
    double *temp_array;
    int mpi_success, size, id, left_neighbour, right_neighbour;
    MPI_Status status;

    mpi_success = MPI_Init(&argc, &argv);

    if(mpi_success) {
        printf("Error: %s\n", strerror(errno));
        MPI_Abort(MPI_COMM_WORLD, mpi_success);
    }

    MPI_Comm_size(MPI_COMM_WORLD, &size);
    MPI_Comm_rank(MPI_COMM_WORLD, &id);

    int local_size = i_max / size;

    /* Allocate size of local array */
    double *cur = (double *)calloc(local_size + 2, sizeof(double));
    double *next = (double *)calloc(local_size + 2, sizeof(double));
    double *old = (double *)calloc(local_size + 2, sizeof(double));

    left_neighbour = id - 1;
    right_neighbour = id + 1;

    /* Master, will divide the array to all the workers */
    if (id == 0) {
        for (int t = 1; t < size; t++) {
            MPI_Send(current_array + (t * local_size), local_size, MPI_DOUBLE,
                     t, t, MPI_COMM_WORLD);
            MPI_Send(old_array + (t * local_size), local_size, MPI_DOUBLE,
                     t, t, MPI_COMM_WORLD);
        }
        memcpy(cur + 1, current_array, (sizeof(double) * local_size));
        memcpy(old + 1, old_array, (sizeof(double) * local_size));
    } else {
        /* Workers, will receive their part from the master */
        MPI_Recv(cur + 1, local_size, MPI_DOUBLE, 0, id, MPI_COMM_WORLD,
                 &status);
        MPI_Recv(old + 1, local_size, MPI_DOUBLE, 0, id, MPI_COMM_WORLD,
                 &status);
    }

    /* For every time stamp calculate local array with the halo cells */
    for (int t = 0; t < t_max; t++) {
        if (id > 0) {
            /* Send to and receive from left neighbour (halo cells) */
            MPI_Send(cur + 1, 1, MPI_DOUBLE, left_neighbour, t, MPI_COMM_WORLD);
            MPI_Recv(cur, 1, MPI_DOUBLE, left_neighbour, t, MPI_COMM_WORLD,
                     &status);
        }

        if (id != size - 1) {
            /* Send to and receive from right neighbour (halo cells) */
            MPI_Send(cur + local_size, 1, MPI_DOUBLE, right_neighbour, t,
                     MPI_COMM_WORLD);
            MPI_Recv(cur + local_size + 1, 1, MPI_DOUBLE, right_neighbour, t,
                     MPI_COMM_WORLD, &status);
        }

        for (int i = 1; i <= local_size; i++) {
            next[i] = ((2 * cur[i]) - old[i] + (0.15 * (cur[i - 1] -
                       (2 * cur[i] - cur[i + 1]))));
        }
        /* Swap buffers */
        temp_array = old;
        old = cur;
        cur = next;
        next = temp_array;
    }

    /* If not master send final array to master */
    if (id > 0) {
        MPI_Send(cur + 1, local_size, MPI_DOUBLE, 0, id, MPI_COMM_WORLD);
    } else {
        /* If master copy local to global final array, and receive from
         * all the workers
         */
        memcpy(current_array, cur + 1, (sizeof(double) * local_size));
        for (int i = 1; i < size; i++) {
            MPI_Recv(current_array + i * local_size, local_size, MPI_DOUBLE, i,
                     i, MPI_COMM_WORLD, &status);

        }
    }

    free(old);
	free(next);
	free(cur);

    MPI_Finalize();

    if (id == 0) {
        return current_array;
    } else {
        return NULL;
    }
}
