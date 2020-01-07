#include "myalloc.h"
#include <stdio.h>

/* contains poiners to next piece of memory which is allocted or free */
struct mm_state {
    size_t startBank;
    size_t endBank;
    struct nodeInfo* next;
    size_t totalBanks;
    char activeBanks[];
};

struct nodeInfo {
    size_t startBank;
    size_t endBank;
    struct nodeInfo* next;
    size_t empty;
};

/* Initialize function to setup memory management, this returns the header node */
mm_state_t* mm_initialize(void) {
    const struct ram_info *info = hw_raminfo();
    char *base = (char*)info->module_addrs[0];
    int totalBanks = info->nbanks_per_module * info->nmodules;

    int neededBanks = ((sizeof(mm_state_t) + info->bank_size - 1) +
                        (sizeof(char) * totalBanks)) / info->bank_size;
    /* Activate banks needed for the struct */
    for (int i = 0; i < neededBanks; i++) {
        hw_activate(0, i);
    }
    mm_state_t* state = (mm_state_t*)base;
    state->startBank = 0;
    state->next = NULL;
    state->endBank = neededBanks - 1;
    state->totalBanks = totalBanks;
    /* all banks are disabled at start */
    for (int i = 0; i < totalBanks; i++) {
        if (i < neededBanks) {
            state->activeBanks[i] = 1;
        }
        state->activeBanks[i] = 0;
    }
    return state;
}

/* activate banks from startbank to endBank */
void activateBanks(mm_state_t* st, int startBank, int endBank) {
    /* activate necessary banks */
    for (int i = startBank; i <= endBank; i++) {
        if (st->activeBanks[i] == 0) {
            hw_activate(0, i);
            st->activeBanks[i] = 1;
        }
    }
    return;
}

/* help function for alloc */
void *helpAlloc(mm_state_t* st, size_t nbytes, struct nodeInfo* current) {
    const struct ram_info *info = hw_raminfo();
    char *base = (char*)info->module_addrs[0];
    struct nodeInfo* node;
    /* calculate how many banks are needed */
    size_t nbanks = (sizeof(node) + nbytes + info->bank_size - 1) /
                    info->bank_size;
    if ((st->totalBanks - current->endBank) > nbanks) {
        size_t memadress = ((size_t)base + (info->bank_size *
                           (current->endBank + 1)));
        node = (struct nodeInfo*)memadress;
        node->startBank = current->endBank + 1;
        node->endBank = node->startBank + nbanks - 1;
        node->next = NULL;
        node->empty = 0;
        activateBanks(st, node->startBank, node->endBank);
        current->next = (struct nodeInfo*)memadress;
        void *p = (char*)info->module_addrs[0] +
                node->startBank * info->bank_size + sizeof(struct nodeInfo);
        return p;
    } else {
        return 0;
    }
}

void *helpAllocTwo(mm_state_t* st, size_t nbytes, struct nodeInfo* current) {
    const struct ram_info *info = hw_raminfo();
    char *base = (char*)info->module_addrs[0];
    struct nodeInfo* node;
    /* calculate how many banks are needed */
    size_t nbanks = (sizeof(node) + nbytes + info->bank_size - 1) /
                    info->bank_size;
    /* check if enough banks are available */
    if ((current->endBank - current->startBank) >= (nbanks - 1)) {
        struct nodeInfo* temp = (struct nodeInfo*)base;
        current->endBank = current->startBank + nbanks - 1;
        current->empty = 0;
        void *p = (char*)info->module_addrs[0] +
                current->startBank * info->bank_size + sizeof(struct nodeInfo);;
        /* still empty banks left after allocation */
        if ((current->endBank - current->startBank + 1) - nbanks > 0) {
            size_t memadress = ((size_t)base + ((current->endBank + 1) * info->bank_size));
            node = (struct nodeInfo*)memadress;
            node->startBank = current->endBank + 1;
            node->endBank = temp->endBank;
            node->next = temp->next;
            node->empty = 1;
            current->next = node;
        }
        return p;
    } else {
        if (current->endBank == st->totalBanks) {
            return 0;
        } else {
            current = current->next;
        }
    }
    return 0;
}

void *firstAlloc(mm_state_t* st, size_t nbytes) {
    const struct ram_info *info = hw_raminfo();
    char *base = (char*)info->module_addrs[0];
    struct nodeInfo* node;
    /* calculate how many banks are needed */
    size_t nbanks = (sizeof(node) + nbytes + info->bank_size - 1) /
                    info->bank_size;
    /* first allocation */
    size_t memadress = ((size_t)base + ((st->endBank + 1) * info->bank_size));
    node = (struct nodeInfo*)memadress;
    node->startBank = st->endBank + 1;
    node->endBank = node->startBank + nbanks - 1;
    node->next = NULL;
    node->empty = 0;
    activateBanks(st, node->startBank, node->endBank);
    st->next = node;
    void *p = (char*)info->module_addrs[0] + node->startBank *
                info->bank_size + sizeof(struct nodeInfo);
    return p;
}

/* allocate nbytes of memory and return pointer to the right location */
void *mm_alloc(mm_state_t* st, size_t nbytes) {
    /* first allocation */
    if (st->next == NULL) {
        return firstAlloc(st, nbytes);
    }
    struct nodeInfo* current = st->next;
    while(1) {
        /* current block is allocated */
        if (current->empty == 0) {
            /* next block was exists */
            if (current->next != NULL) {
                current = current->next;
                continue;
                /* create next block and return pointer */
            } else {
                return helpAlloc(st, nbytes, current);
            }
        } else {
            return helpAllocTwo(st, nbytes, current);
        }
    }
}

void mm_free(mm_state_t* st, void *ptr) {
    const struct ram_info *info = hw_raminfo();
    size_t adress = ((size_t)ptr - (size_t)info->module_addrs[0] -
                    sizeof(struct nodeInfo)) / (size_t)info->bank_size;
    struct nodeInfo* node = st->next;
    while(1) {
        if (node->startBank != adress ) {
            node = node->next;
        } else {
            node->empty = 1;
            (void)ptr;
            return;
        }
    }
}
