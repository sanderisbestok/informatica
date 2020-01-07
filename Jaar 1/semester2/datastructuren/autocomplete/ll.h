/*  Author:         Sander Hansen
    Name:           ll.h
    Description:    Header of linked list (ll.c)
    Usage:          ./ll filename.txt  */
struct list;

/* Initialise list.
   Return: an empty list. */
struct list* list_init();

/* Print list.
   Input: List which has to be printed
   Output: The list printed (Char's right after each other) */
void list_print(struct list *l);

/* Add char array to list
   Input: List and charracter that has to be added */
void list_add(struct list *l, char d);

/* Remove char array from list
   Input: List and character that has to be removed
   Return: 0 if char array not found, char array if succes */
char  list_remove(struct list *l, char d);

/* Find item at given index
   Input: List, index of the item
   Return: 0 if index is invalid, the data of index if succes */
char  list_at_index(struct list *l, int index);

/* Free the memory allocated
   Input: List */
void list_cleanup(struct list *l);
