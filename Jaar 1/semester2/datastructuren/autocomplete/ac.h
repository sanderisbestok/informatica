/*  Author:         Sander Hansen
    Name:           ac.h
    Description:    Header of a trie (ac.c) */
#ifndef AC_H
#define AC_H
typedef struct tnode tnode_t;
typedef struct ac ac_t;

// Forward declaration of the autocomplete data structure.
struct ac;
struct tnode;

/* Initialise a ac data structure.
   Input: empty
   Return: Datastructure with initialised root node. */
ac_t* ac_init();

/* Helping function for ac_add, to create a new_node underneath or next
   to current node.
   Input: Node, identifier char, int (1 if sibling, 0 if child)
   Return: The newly created node */
tnode_t* create_new_node(tnode_t *cur_node, char w, int sibling);

/* Helping function for ac_add, it will determine the return value
   Input: Trie and current node
   Return: 0 if word already existed, 1 if a new word is added*/
int check_word(ac_t *a, tnode_t *cur_node);

/* Add word w to the trie.
   Input: trie and word to be added to the tree
   Return: 1 if word is added, 0 if word already excisted.  */
int ac_add(ac_t* a, char* w);

/* Lookup word w in the trie.
   Input: trie and word to be looked for in the trie, int prefix (0 if looking
   for prefix, 0 if looking for word)
   Return: 1 if word is present, 0 if word is not present in the trie. */
tnode_t* ac_lookup(ac_t* a, char* w, int prefix);

/* Helping function of ac_remove remove the word starting from the last node
   Input: last node of the word that has to be removed
   Output: If structure has been made empty, autocomplete structure is empty */
void remove_word(tnode_t *cur_node);

/* Remove word w from the trie.
   Input: trie and word to be removed in the trie.
   Return: 1 if word has been removed, 0 if word was not in the trie. */
int ac_remove(ac_t* a, char* w);

/* Helping function of ac_prefix, move down prefix trie until last char of
   prefix is reached
   Input: trie and lenght of prefix_
   Return: the last tnode of the prefix */
tnode_t* move_down(ac_t* prefix_trie, int prefix_length);

/* Helping function of ac_prefix, will set parent of trie_node and trie_nodes
   next to them to the cur_node
   Input: tnode whos parent has to be set and the cur_node to who the parent
   pointer has to point */
void set_parent(tnode_t* prefix_trie_node, tnode_t* cur_node);

/* Print all the words in ac a starting with prefix.
   Input: trie and the prefix that you are looking for.
   Output: All the words that start with the given prefix */
void ac_prefix(ac_t* a, char* prefix);

/* Print all the words in the trie.
   Input: trie
   Output: The whole trie printed, word for word underneath each other. */
void ac_print(ac_t* a);

/* Count words in the trie.
   Input: Trie
   Return: Amount of words in the Trie */
int ac_count(ac_t* a);

/* Free nodes by moving right from the giving nodes
   Input: a node
   Return: amount of words which are removed */
int free_nodes(tnode_t* cur_node);

/* Cleanup ac.
   Input: Trie
   Return: number of words free'd. */
int ac_cleanup(ac_t* a);

#endif /* AC_H */
