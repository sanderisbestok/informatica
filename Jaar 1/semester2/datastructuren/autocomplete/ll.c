/*  Author:         Sander Hansen
    Name:           ll.c
    Description:    Datastructure of linked list
    Usage:          Use in file call with functions
    Comments:       The usage of (*l).length etc is on purpose, I presonally
                    think it is more clear to see what's happening instead of
                    the -> notation */
#include <stdio.h>
#include <assert.h>
#include <stdlib.h>
#include <string.h>

#include "ll.h"

/* Node of list*/
struct node {
     char data;
     struct node *pointer;
};

/* Head of list */
struct list {
    struct node *first;
    int length;
};

typedef struct list list_t;
typedef struct node node_t;

/* Initialise list by allocating memory to the list*/
list_t* list_init() {
    list_t *l = malloc(sizeof(list_t));
    (*l).first = NULL;
    (*l).length = 0;

    return l;
}

/* Print the list */
void list_print(struct list *l) {
    if (!l) {
        printf("List is NULL!\n");
    } else {
        node_t *cur_node;

        /* If the first pointer is zero, the list is empty*/
        if (!(*l).first) {
            printf("List is empty!\n");
        } else {
            /* Set current node to first node and print it's data */
            cur_node = (*l).first;
            printf("%c",(*cur_node).data);

            /* As long as the pointer to next node is not null, go to next node
            and print data of this node */
            while ((*cur_node).pointer) {
                cur_node = ((*cur_node).pointer);
                printf("%c",(*cur_node).data);
            }
        }
    }
}

/* Add element to the list */
void list_add(struct list *l, char d) {
    node_t *new_node = malloc(sizeof(node_t));
    (*new_node).pointer = NULL;
    /* If first pointer is empty, set the pointer of new element to zero */
    if (!(*l).first) {
        (*l).first = new_node;
    } else {
        node_t *cur_node = (*l).first;

        while ((*cur_node).pointer) {
            cur_node = ((*cur_node).pointer);
        }

        (*cur_node).pointer = new_node;
    }
    /* Set data of new node*/
    (*new_node).data = d;
    (*l).length++;
}

/* Remove given word form given list by itterating over the list return 0
if unsuccesfull */
char list_remove(struct list *l, char d) {
    node_t *prev_node;
    node_t *cur_node;
    int first_round = 1;
    /* Check if the data in the node is the same as the data given, if so
    remove this node. Check if next node is not empty. If it's the first_round
    "round" it will be read from the head */
    do {
        if (first_round) {
            cur_node = (*l).first;
        } else {
            cur_node = (*cur_node).pointer;
        }

        if (!(*cur_node).pointer) {
            if (first_round) {
                (*l).first = (*cur_node).pointer;
            } else {
                (*prev_node).pointer = (*cur_node).pointer;
            }

            (*l).length--;
            free(cur_node);
            return d;
        }

        prev_node = cur_node;
        first_round = 0;
    } while ((*cur_node).pointer);

    printf("Word not found, so it cannot be removed \n");
    return 0;
}

/* Checks if the given index is avaiable in the given list, if not return 0
if so return the word that is stored in the node of the given index*/
char list_at_index(struct list *l, int index) {
    node_t *cur_node;
    int index_count = 0;
    if (index > ((*l).length - 1)) {
        printf("Index bigger then list\n");
        return 0;
    }

    cur_node = (*l).first;

    /* As long as index_count is smaller as the given index go to the next
       node if equal it will return the data */
    while (index_count < index) {
        cur_node = (*cur_node).pointer;
        index_count++;
    }

    return (*cur_node).data;
}

/* Free's the memory used by the nodes of the list, argument given is the list
it will clean*/
void list_cleanup(struct list *l) {
    node_t *cur_node;
    node_t *next_node;

    if (!(*l).first) {
        free(l);

        return;
    }

    cur_node = (*l).first;

    while ((*cur_node).pointer) {
        next_node = (*cur_node).pointer;
        free(cur_node);
        cur_node = next_node;
    }

    free(cur_node);
    free(l);

}
