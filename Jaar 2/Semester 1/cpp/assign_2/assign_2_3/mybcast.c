/* mybcast.c
 *
 * Own implementation of a MPI broadcast
 *
 * Sander Hansen 10995080
 * Bas van Berckel 10735917
 *
 */

#include <mpi.h>
#include <stdlib.h>
#include <stdio.h>

// C's % gives negative results
int mod(int i, int j) {
	int m = i % j;
	// If the result is negative, add the dividend
	return m < 0 ? m + j : m;
}

int MYMPI_Bcast(void *buffer, int count, MPI_Datatype datatype,
			int root, MPI_Comm communicator) {
	int rank, size, left, right;

	MPI_Comm_rank(communicator, &rank);
	MPI_Comm_size(communicator, &size);

	left = mod((rank - 1), size);
	right = mod((rank + 1), size);

	if(rank == root) { // Sender
		// Send the initial message both ways
		MPI_Send(buffer, count, datatype, left, root, communicator);
		MPI_Send(buffer, count, datatype, right, root, communicator);

	} else { // Receiver
		MPI_Status status;
		int src, dest;
		// Receive message from either side
		MPI_Recv(buffer, count, datatype,
				 MPI_ANY_SOURCE, root, communicator, &status);
		src = status.MPI_SOURCE;
		// Determine the destination for the forwarded message
		dest = src == left ? right : left;
		// Forward message, don't care if it is recv'd or not
		MPI_Request req;
		MPI_Isend(buffer, count, datatype, dest, root, communicator, &req);
		MPI_Request_free(&req);
	}
	return 0;
}
