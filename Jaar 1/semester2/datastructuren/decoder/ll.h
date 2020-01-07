/*  Author:         Sander Hansen
    Name:           ll.h
    Description:    Header of linked list (ll.c)
    Usage:          ./ll filename.txt  */
struct list;

/* Initialise list.
   Return an empty list. */
struct list* list_init();

/* Print list. */
void list_print(struct list *l);

/* Add char array to list */
void list_add(struct list *l, char *d);

/* Remove char array from list
   Return 0 if char array not found, return the char array if succes */
char* list_remove(struct list *l, char *d);

/* Find item at given index
   Return 0 if index is invalid, return the data of index if succes */
char* list_at_index(struct list *l, int index);

/* Free the memory allocated */
void list_cleanup(struct list *l);
