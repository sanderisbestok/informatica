typedef struct item item;
typedef struct list list;

/* Used for usage with void pointers
* so they can be casted properly. */
typedef enum {
    INT,
    CHAR,
    FLOAT
} void_type;

/* Node in a doubly linked list */
struct item {
    item *next;
    item *prev;
    void *data;
    void_type type;
};

/* Header of doubly linked list */
struct list {
    item *first;
    item *last;
    int size;
    int limit;
};

/* Initialise list.
 * Return an empty list. */
list* list_init();

/* Print list. */
void list_print(list *l);

/* Add item to list */
int list_add(list *l, void *d, void_type type);

/* Remove item form list. */
int list_remove(list *l, void *d);

/* Get item at index. */
item* list_at_index(list *l, int index);

/* Get int at index. */
int* list_int_at_index(list *l, int index);

/* Free memory of list. */
int list_cleanup(list *l);

/* Returns true when list is size zero. */
int list_is_empty(list *l);

/* Returns index of data */
int list_get_index(list *l, void *d);

/* Compares item data to data */
int list_item_compare(item *i, void *a);

/* Swap two items in list */
void list_swap(list *l, int indexa, int indexb);
