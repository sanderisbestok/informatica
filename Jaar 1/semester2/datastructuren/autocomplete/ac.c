/*  Author:         Sander Hansen
    Name:           ac.c
    Description:    Datastructure of the autocomplete Trie
    Usage:          Use the functions to buildup/search/remove a Trie
    Comments:       The usage of (*a).pointer etc is on purpose, I presonally
                    think it is more clear to see what's happening instead of
                    the -> notation
                    This datastructure uses a slightly modified version of ll.c
                    from the last assignment for the printing of the list.
                    Some functions are split up in multiple functions,
                    in my opinion, unnecessary, but we where told to keep
                    functions around 30 lines. (Excluding comments)
                    Unfortunatly I did not succeed in keeping all the functions
                    short, remove_word for example is a function which I think
                    cannot be seperated in parts logically. */
#include <stdlib.h>
#include <stdio.h>
#include <string.h>

#include "ac.h"
#include "ll.h"

struct tnode {
    char ident;
    int word;
    tnode_t *parent_pointer;
    tnode_t *child_pointer;
    tnode_t *next_pointer;
    tnode_t *previous_pointer;
};

/* Root of the ac trie*/
struct ac {
    tnode_t *pointer;
    int word_count;
};

/* This function will initialise a new Trie. It will create a head, set the
   pointers of the head to NULL and in the end it will return the Trie */
ac_t* ac_init() {
    ac_t *ac = malloc(sizeof(ac_t));
    tnode_t *head = malloc(sizeof(tnode_t));
    (*head).word = 0;
    (*head).child_pointer = NULL;
    (*head).parent_pointer = NULL;
    (*head).previous_pointer = NULL;
    (*head).next_pointer = NULL;
    (*ac).pointer = head;
    (*ac).word_count = 0;
    return ac;
}

/* This function will take a node a char and a int and will add a new node
   underneath or next to the current node depending on the int */
tnode_t* create_new_node(tnode_t *cur_node, char w, int sibling) {
    tnode_t *new_node = malloc(sizeof(tnode_t));

    (*new_node).ident = w;
    (*new_node).word = 0;
    (*new_node).child_pointer = NULL;
    (*new_node).next_pointer = NULL;

    if (sibling) {
        (*new_node).parent_pointer = (*cur_node).parent_pointer;
        (*new_node).previous_pointer = cur_node;
    } else {
        (*new_node).parent_pointer = cur_node;
        (*new_node).previous_pointer = NULL;
    }

    return new_node;
}

/* This function will take a node and check if it is marked as the end of a
   word. If so it will return 0 (Nothing new added) if not it will return
   1 and add 1 to the total word count. */
int check_word(ac_t *a, tnode_t *cur_node) {
    if ((*cur_node).word == 1) {
        return 0;
    } else {
        (*cur_node).word = 1;
        (*a).word_count++;
        return 1;
    }
}

/* This function will take a Trie and a char array as input. It will add this
   char array to the Trie */
int ac_add(ac_t* a, char* w) {
    int word_length = strlen(w);
    int i = 0;
    tnode_t *cur_node;

    /* Set cur_node to the root of the Trie */
    cur_node = (*a).pointer;

    /* As long as the last letter is not reached, keep trying to add the word
       to the Trie.*/
    while (i < word_length) {
        int next = 1;
        /* If the current node has no child pointer, add it with the i'th
           letter as identifier */
        if (!(*cur_node).child_pointer) {
            tnode_t *new_node = create_new_node(cur_node, w[i], 0);

            (*cur_node).child_pointer = new_node;
            cur_node = new_node;
        } else {
            cur_node = (*cur_node).child_pointer;

            while (next) {
                /* If the current node is the same node that has to be added
                   stop searching for a next node */
                if ((*cur_node).ident == w[i]) {
                    next = 0;
                /* If the node is not the same but it has an next_pointer move
                   to next and repeat search */
                } else if ((*cur_node).next_pointer) {
                    cur_node = (*cur_node).next_pointer;
                /* If no next pointer has been found, create one */
                } else {
                    tnode_t *new_node = create_new_node(cur_node, w[i], 1);

                    (*cur_node).next_pointer = new_node;
                    cur_node = new_node;
                    next = 0;
                }
            }
        }
        i++;
    }
    return check_word(a, cur_node);
}

/* This function will check if a word or prefix excists in the Trie, it will
   return the last node of the word or prefix if it does excist and NULL if
   it is not present. */
tnode_t* ac_lookup(ac_t* a, char* w, int prefix) {
    int word_length = strlen(w);
    tnode_t *cur_node;

    /* Set cur_node to the root of the Trie*/
    cur_node = (*a).pointer;

    /* As long as the word_length is not reached, keep searching*/
    for (int i = 0; i < word_length; i++) {
        /* If the current node has no children, the word cannot be present
           so it will return NULL. */
        if (!(*cur_node).child_pointer) {
            return NULL;
        } else {
            cur_node = (*cur_node).child_pointer;

            int next = 1;
            /* Check for siblings, if one similair is found and it is the last
               letter and it is marked as a word return 1.*/
            while (next) {
                if ((*cur_node).ident == w[i]) {
                    next = 0;
                    /* If looking for prefix the cur_node does not have to be
                       a word if not looking for prefix word has to be 1 */
                    if ((i == (word_length - 1) && (*cur_node).word) ||
                    ((i == (word_length -1) && prefix))) {
                        return cur_node;
                    }
                } else if ((*cur_node).next_pointer) {
                    cur_node = (*cur_node).next_pointer;
                /* If it has no next pointer, the word cannot be present
                   so it will return NULL. */
                } else {
                    return NULL;
                }
            }
        }
    }
    return NULL;
}

/* This function will remove the word starting at the given node by working
   it's way up the trie.*/
void remove_word(tnode_t *cur_node) {
    int remove_word = 1, first_round = 1;
    tnode_t *prev_node, *next_node, *parent_node;

    /* As long as cur_node has no next/prev or it has an parent_pointer
       node's can be removed. If it has a next/prev certain actions have
       to be commited. */
    while (remove_word) {
        /* If the (after the first node has been removed) the (*cur_node).word
           is not equel to 0, another word ends here so removing proces can be
           stopped. */
        if ((*cur_node).word == 0 || first_round) {
            /* If the current node has an next and a previous pointer these
               have to be linked to each other, after that cur_node can be
               freeed and the removing process can be terminated. */
            if ((*cur_node).next_pointer && (*cur_node).previous_pointer) {
                prev_node = (*cur_node).previous_pointer;
                next_node = (*cur_node).next_pointer;

                (*prev_node).next_pointer = next_node;
                (*next_node).previous_pointer = prev_node;

                free(cur_node);
                remove_word = 0;
            /* If the cur_node has only a next pointer, the parent has to point
               to the cur_node, and the next node previous pointer has to point
               to NULL, after that the cur_node can be freed and the removing
               process can be terminated */
            } else if ((*cur_node).next_pointer) {
                parent_node = (*cur_node).parent_pointer;
                next_node = (*cur_node).next_pointer;

                (*parent_node).child_pointer = (*cur_node).next_pointer;
                (*next_node).previous_pointer = NULL;

                free(cur_node);
                remove_word = 0;
            /* If the cur_node has only a previous pointer, the previous node
               has to point to NULL. Then the cur_node can be freed and the
               removing proces can be terminated */
            } else if ((*cur_node).previous_pointer) {
                prev_node = (*cur_node).previous_pointer;
                (*prev_node).next_pointer = NULL;

                free(cur_node);
                remove_word = 0;
            /* If the cur_node has no parent_pointer the autocomplete structure
               is empty, this will be outputted and the removing process will
               be terminated*/
            } else if (!(*cur_node).parent_pointer) {
                printf("Autocomplete structure is empty\n");
                remove_word = 0;
            /* Else the current_node can just be freed and the new cur_node
               will be the parent of the previous one.*/
            } else {
                parent_node = (*cur_node).parent_pointer;
                (*parent_node).child_pointer = NULL;

                free(cur_node);
                cur_node = parent_node;
                first_round = 0;
            }
        } else {
            remove_word = 0;
        }
    }
    return;
}

/* This function will remove a word if present. It will take a trie and word
   (char array) as input and return 0 if the word was not in the trie and 1
   if the word has been removed */
int ac_remove(ac_t* a, char* w) {
    tnode_t *cur_node;

    /* Check if the word is present in the trie, If not return 0, the cur_node
       is set tot the last char of the word */
    if (!(cur_node = ac_lookup(a, w, 0))) {
        return 0;
    }
    /* If the current_node has a child pointer, no pointers need to be removed
       so only the (*cur_node).word variable has to be set to 0. (Return 1 cause
       of succesfull remove of word)*/
    if ((*cur_node).child_pointer) {
        (*cur_node).word = 0;
        (*a).word_count--;
        return 1;
    } else {
        /* Remove the nodes of the words in seperate function */
        remove_word(cur_node);
    }
    /* Lower the word count and return 1 cause of succesfull remove of word */
    (*a).word_count--;
    return 1;
}

/* Move down a trie, until the length of the given int is reached */
tnode_t* move_down(ac_t* prefix_trie, int prefix_length) {
    tnode_t *prefix_trie_node;
    /* Move to the last char of the prefix in the trie */
    prefix_trie_node = (*prefix_trie).pointer;
    for (int i = 0; i < prefix_length; i++) {
        prefix_trie_node = (*prefix_trie_node).child_pointer;
    }
    return prefix_trie_node;
}

/* Set the parent of all the tnode's next to the given one */
void set_parent(tnode_t* prefix_trie_node, tnode_t* cur_node) {
    int next = 1;
    while (next) {
        (*prefix_trie_node).parent_pointer = cur_node;
        if ((*prefix_trie_node).next_pointer) {
            prefix_trie_node = (*prefix_trie_node).next_pointer;
        } else {
            next = 0;
        }
    }
    return;
}

/* This function will search for all the words in the given trie with the
   prefix that is provided, it will print all these words*/
void ac_prefix(ac_t* a, char* prefix) {
    int prefix_length = strlen(prefix);
    tnode_t *cur_node, *prefix_trie_node;
    ac_t *prefix_trie;

    /* Set current node to pointer of the root */
    cur_node = (*a).pointer;

    /* If ac_lookup returns NULL no words could be found with this prefix, if
       it does return a node it will be the last node of the prefix */
    if (!(cur_node = ac_lookup(a, prefix, 1))) {
        printf("No words found with this prefix\n");
        return;
    }
    /* Initialise trie that will contain the words that have the prefix */
    prefix_trie = ac_init();
    /* Add the prefix to this Trie*/
    ac_add(prefix_trie, prefix);
    /* Set prefix_trie_node to the root of the trie*/
    prefix_trie_node = move_down(prefix_trie, prefix_length);

    /* If the prefix of his own was not a word, set in the trie the current
       node word to 0. */
    if (!(*cur_node).word) {
        (*prefix_trie_node).word = 0;
    }
    /* Set the last node of the prefix child pointer to the same child pointer
       as the cur_node of the original trie, and move to this node */
    (*prefix_trie_node).child_pointer = (*cur_node).child_pointer;
    prefix_trie_node = (*prefix_trie_node).child_pointer;

    /* Set the parent of all the nodes directly underneath the last char of
       the prefix to NULL so it will not print the original Trie. (Note: it
       could also be set as the last char of the prefix, but that would take
       another few steps and cause of the way ac_print is implemented, this
       will work as fine) */
    set_parent(prefix_trie_node, NULL);

    /* Print the prefix_trie */
    /*ac_print(prefix_trie);*/

    prefix_trie_node = (*cur_node).child_pointer;

    /* Set the parent node back to it's original value so it will restore the
       original Trie */
    set_parent(prefix_trie_node, cur_node);

    /* Set prefix_trie_node to the root of the trie*/
    prefix_trie_node = move_down(prefix_trie, prefix_length);
    /* Set it's child pointer to NULL so cleanup will only cleanup the prefix
       trie */
    (*prefix_trie_node).child_pointer = NULL;
    ac_cleanup(prefix_trie);
}

/* This function will print the given trie */
void ac_print(ac_t* a) {
    tnode_t *cur_node = (*a).pointer;

    if ((*cur_node).child_pointer) {
        cur_node = (*cur_node).child_pointer;
    } else {
        printf("The trie is empty\n");
        return;
    }

    /* Declaration here cause they wont be needed if already returned */
    int up = 1;
    int printing = 1;
    struct list* list;
    /* Initialise list to print (ll.c) add the first char to the list. */
    list = list_init();
    list_add(list, (*cur_node).ident);

    /* As long as the last pointer has not been reached, keep printing */
    while (printing) {
        /* If the current node is a word, and were not moving up, print they
           word. (If up = 0 we have already been here)*/
        if ((*cur_node).word && up) {
            list_print(list);
            printf("\n");
        }

        /* If cur_node has a child pointer, and were not moving up, move down
           and add char to the list .*/
        if ((*cur_node).child_pointer && up) {
            cur_node = (*cur_node).child_pointer;
            list_add(list, (*cur_node).ident);
        /* If cur_node has a next pointer, remove cur char, move to next and
           and add char to list */
        } else if ((*cur_node).next_pointer) {
            list_remove(list, (*cur_node).ident);
            cur_node = (*cur_node).next_pointer;
            list_add(list, (*cur_node).ident);
            up = 1;
        /* If not we have to move up and remove the cur char. */
        } else {
            if ((*cur_node).parent_pointer) {
                list_remove(list, (*cur_node).ident);
                cur_node = (*cur_node).parent_pointer;
                up = 0;
            /* If there is no parent above the cur node (this will be the most
               "upperright" located node) all the nodes are already added and
               the words printed so printing can stop */
            } else {
                printing = 0;
            }
        }
    }
    /* Free list */
    list_cleanup(list);
}

/* Count amount of words by looking up the word_count variable */
int ac_count(ac_t* a) {
    return (*a).word_count;
}

/* Will free nodes starting from the right corner working it's way left */
int free_nodes(tnode_t* cur_node) {
    int check = 1, freed_words = 0;
    tnode_t *prev_node, *parent_node;

    cur_node = (*cur_node).child_pointer;
    /* Move to the right corner */
    while ((*cur_node).next_pointer) {
        cur_node = (*cur_node).next_pointer;
    }

    /* While not reached the last char keep freeing */
    while (check) {
        /* If cur_node has child pointer move down */
        if ((*cur_node).child_pointer) {
            cur_node = (*cur_node).child_pointer;
        /* If cur_node has next pointer move to right */
        } else  if ((*cur_node).next_pointer) {
            cur_node = (*cur_node).next_pointer;
        } else {
            /* If no child and no next set prev_node, check if it was a word
               if so higher freed words, then free node and set cur node to
               previous. Set next to NULL */
            if ((*cur_node).previous_pointer) {
                prev_node = (*cur_node).previous_pointer;

                if ((*cur_node).word) {
                    freed_words++;
                }

                free (cur_node);
                cur_node = prev_node;
                (*cur_node).next_pointer = NULL;
            /* If it only has a parent pointer save parent node, check if word
               free cur node and set new cur to parent set child to NULL*/
            } else if ((*cur_node).parent_pointer) {
                parent_node = (*cur_node).parent_pointer;

                if ((*cur_node).word) {
                    freed_words++;
                }

                free(cur_node);
                cur_node = parent_node;
                (*cur_node).child_pointer = NULL;
            /* If this point is reached everything is removed so stop removing*/
            } else {
                check = 0;
            }
        }
    }
    return freed_words;
}

/* This function will cleanup an ac structure by freeing all the nodes from
   the node that is the farrest away (right down corner) to it's parents and
   left siblings */
int ac_cleanup(ac_t* a) {
    tnode_t *cur_node;
    int freed_words = 0;
    /* Move to the root of the trie */
    cur_node = (*a).pointer;
    /* If the trie has no children only the root and the ac have to be freed */
    if ((*cur_node).child_pointer) {
        freed_words = free_nodes(cur_node);
    }

    /* Free the root and the */
    free(cur_node);
    free(a);
    return freed_words;
}
