#include <pthread.h>
#include <stdlib.h>
#include <stdio.h>
#include "queue.h"

void add(queue *q, int item) {
	node *n = malloc(sizeof(node));
	n->prev = NULL;
	n->val = item;

	if(q->rear != NULL) 
		q->rear->prev = n;
	q->rear = n;

	if(q->front == NULL)
		q->front = n;
}

int pop(queue *q) {
	if(q->front == NULL) return -1;

	node *n = q->front;
	int val = n->val;
	q->front = n->prev;
	if(q->front == NULL)
		q->rear = NULL;

	free(n);

	return val;

}

queue *init_queue() {
	queue *q = malloc(sizeof(queue));
    q->front = NULL;
    q->rear = NULL;
    pthread_mutex_init(&q->mutex, NULL);
    pthread_cond_init(&q->cond, NULL);
    return q;
}
