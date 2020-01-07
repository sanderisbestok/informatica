/*
 * sieve.c
 * Sander Hansen 10995080
 * Bas van Berckel 10343725
 */
#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include "queue.h"
#include "timer.h"

// Set TIMER to 1 to run timing code
#define TIMER 1

void *filter(void *args) {
	queue *inqueue = (queue *)args;
	queue *outqueue;
	int prime = -1;
	while(prime == -1) {
		prime = pop(inqueue);
	}

#if TIMER == 0
	printf("%i\n", prime);
#else
	if(prime == 541 || prime == 7919 || prime == 17389 || prime == 27449 || prime == 32609 || prime == 48611)
		printf("%i found after %.2f seconds.\n", prime, timer_end());
#endif

	int end = 1;
	int next;
	while(1) {
		pthread_mutex_lock(&inqueue->mutex);
		pthread_cond_wait(&inqueue->cond, &inqueue->mutex);
		next = pop(inqueue);
		pthread_mutex_unlock(&inqueue->mutex);

		if (next % prime == 0) continue;
		if(end) {
			outqueue = init_queue();

			pthread_t child;
			pthread_create(&child, NULL, filter, (void *)outqueue);
			end = 0;
		}
		pthread_mutex_lock(&outqueue->mutex);
		add(outqueue, next);
		pthread_cond_signal(&outqueue->cond);
		pthread_mutex_unlock(&outqueue->mutex);
	}
	return NULL;
}

/* will paralize the calculation */
void generator(void) {
	queue *q = init_queue();

	pthread_t child;
	pthread_create(&child, NULL, filter, (void *)q);

	int next = 2;

	timer_start();
	while(1) {
		pthread_mutex_lock(&q->mutex);
		add(q, next);
		pthread_cond_signal(&q->cond);
		pthread_mutex_unlock(&q->mutex);
		next++;
	}
}

int main(int argc, char *argv[]) {
	generator();
}
