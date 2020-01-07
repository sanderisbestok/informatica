/*
*   File: ll.c
*
*   Implementation of a doubly linked list.
*
*   Author: Jan Schutte
*   Studentnumber : 11030844
*   Date: 04/03/2016
*
*   Usage:
*   include 'll.h' and initialise a list with the list_init function.
*
*/

#include <stdio.h>
#include <assert.h>
#include <stdlib.h>
#include <string.h>

#include "ll.h"

/* Allocates list header in memory, return pointer to list */
list* list_init() {
    list *tmp = malloc(sizeof(list));

    if (!tmp) {
        printf("Out of memory\n");
        exit(EXIT_FAILURE);
    }

    tmp->first = NULL;
    tmp->last = NULL;
    tmp->size = 0;

    return tmp;
}

/* Add item to list, list can consist of all three types of data simultaneously*/
int list_add(list *l, void *d, void_type type) {
    item *tmp;
    tmp = malloc(sizeof(item));

    /* Malloc failed, out of memory */
    if (!tmp) {
        printf("Out of memory\n");
        exit(EXIT_FAILURE);
    }

    tmp->type = type;
    tmp->data = d;
    tmp->next = l->first;
    tmp->prev = NULL;

    if (list_is_empty(l)) {
        l->first = tmp;
        l->last = tmp;
    } else {
        l->first->prev = tmp;
        l->first = tmp;
    }

    l->size += 1;

    return 1;
}

/* Returns node at index */
item* list_at_index(list *l, int index) {
    item *tmp = l->first;

    for (int i = 0; i < l->size; i++) {
        if (i == index)
            return tmp;

        tmp = tmp->next;
    }

    return NULL;
}

/* Prints data values of all items in list with their index */
void list_print(list *l) {
    item *tmp = l->first;

    if (list_is_empty(l))
        printf("List is NULL!\n");
    else {

        /* Loop through all items in list */
        for(int i = 0; i < l->size; i++) {

            /* Check type to print data correctly */
            if(tmp->type == CHAR)
                printf("%d: %s\n", i, (char *)tmp->data);
            else if(tmp->type == INT)
                printf("%d: %d\n", i, *((int *)tmp->data));
            else
                printf("%d: %f\n", i, *((float *)tmp->data));

            tmp = tmp->next;
        }
    }
}

/* Returns if list is empty */
int list_is_empty(list *l) {
    if(l->size == 0)
        return 1;
    return 0;
}

/* Free memory of item data and list header */
int list_cleanup(list *l) {
    item *tmp = l->first;
    item *next = tmp;

    /* Loop through all items in list*/
    while(next != NULL) {
        next = next->next;
        free(tmp->data);
        free(tmp);

        tmp = next;
    }

    /* Free list header */
    free(l);

    return 1;
}

/* Remove item in list with same data as d */
int list_remove(list *l, void *d) {
    item *tmp = l->first;

    /* Loop through all items in list */
    while(tmp != NULL){

        if (list_item_compare(tmp, d)){
            /* First Item */
            if(tmp->prev == NULL ) {
                l->first = tmp->next;
                tmp->next->prev = NULL;
            }

            /* Last item */
            else if(tmp->next == NULL) {
                l->last = tmp->prev;
                tmp->prev->next = NULL;
            }

            /* Middle of list */
            else {
                tmp->prev->next = tmp->next;
                tmp->next->prev = tmp->prev;
            }

            l->size -= 1;

            free(tmp->data);
            free(tmp);

            return 1;
        }
        tmp = tmp->next;
    }

    return 0;
}

/* Returns index of datavalue if it exists in the list */
int list_get_index(list *l, void *d) {
    item *tmp = l->first;

    for (int i = 0; i < l->size; i++){
        if (list_item_compare(tmp, d))
            return i;

        tmp = tmp->next;
    }

    return -1;
}

/* Returns if items contains same datavalue.
* Checks only for data of the same type as item i */
int list_item_compare(item *i, void *a) {

    /* Check if values match depending on type */
    if (i->type == CHAR)
        return !strcmp(a, (char *)i->data);
    else if (i->type == INT)
        return (*((int *)a) == *((int*)i->data));
    else
        return (*((float *)a) == *((float *)i->data));
}

/* Swap two items in list by index */
void list_swap(list *l, int indexa, int indexb) {
    item *a = list_at_index(l, indexa);
    item *b = list_at_index(l, indexb);

    void *data = a->data;
    void_type type = a->type;

    a->data = b->data;
    a->type = b->type;

    b->data = data;
    b->type = type;
}

/* Returns int pointer of item */
int* list_int_at_index(list *l, int index) {
    return (int *)list_at_index(l,index)->data;
}
