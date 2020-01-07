#ifndef QUEUE_H
#define QUEUE_H

typedef struct node_s node;
typedef struct queue_s queue;

struct node_s
{
	node *prev;
	int val;
};

struct queue_s {
    pthread_mutex_t mutex;
    pthread_cond_t cond;
    node* rear;
    node* front;
};

void add(queue *q, int item);
int pop(queue *q);
queue *init_queue();

#endif