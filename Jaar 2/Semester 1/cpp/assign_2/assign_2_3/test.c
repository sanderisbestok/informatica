#include "mybcast.h"
#include <stdio.h>
#include <stdlib.h>

int main(int argc, char *argv[]) {
	if(argc != 3) {
		fprintf(stderr, "Usage: %s [root] [message]\n", argv[0]);
		exit(1);
	}

	int root, rank, size;

	MPI_Init(NULL, NULL);

	MPI_Comm_rank(MPI_COMM_WORLD, &rank);
	MPI_Comm_size(MPI_COMM_WORLD, &size);

	root = atoi(argv[1]);

	if(root > size || root < 0) {
		fprintf(stderr, "Invalid root %i\n", root);
		exit(1);
	}

	char *m = argv[2];
	int count = 0;
	while(m[count] != '\0') count++;
	count++; 

	void *buffer;

	if(root == rank) {
		buffer = m;
	} else {
		buffer = malloc(count * sizeof(char));
	}

	MYMPI_Bcast(buffer, count, MPI_CHAR, root, MPI_COMM_WORLD);

	if(root == rank) {
		printf("Root (%i) sent message '%s'.\n", root, (char *)buffer);
	} else {
		printf("Receiver (%i) received message '%s'.\n", rank, (char *)buffer);
	}

	MPI_Finalize();
	return 0;
}