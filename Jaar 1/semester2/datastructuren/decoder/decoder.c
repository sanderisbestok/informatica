/*  Author:         Sander Hansen
    Name:           decoder.c
    Description:    Will decode text encoded by the encoder for this assignment
    Usage:          ./decoder filename.txt */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>
#include <assert.h>
#include <errno.h>

#include "ll.h"
#include "debug.h"

#define BUF_SIZE 512

#define DELIM "!?\",. \n"

int main(int argc, char *argv[]) {
    FILE *infile;
    char *linebuf, *s, *e;
    char sep;
    struct list* list;

    if (argc < 2) {
        // No filename, read from stdin.
        infile = stdin;
    } else {
        infile = fopen(argv[1], "r");
        if (!infile) {
            perror(argv[1]);
            exit(EXIT_FAILURE);
        }
    }

    linebuf = malloc(BUF_SIZE);

    /* List init*/
    list = list_init();

    while (fgets(linebuf, BUF_SIZE, infile) != NULL) {
        s = linebuf; // First word starts at line beginning.
        while ((e = strpbrk(s, DELIM)) != NULL) {
            char *str = malloc(strlen(s) + 1);
            sep = *e; // Store separator
            *e = '\0'; // End word.
            int length = strlen(s);
            /* If last char of char array is * add char array minus last char
               to the list */
            if ((s[length - 1]) == '*') {
                s[length - 1] = '\0';
                strcpy(str, s);
                list_add(list, str);
            /* If last char of char array is ~ remove it from the list */
            } else if ((s[length - 1]) == '~') {
                s[length - 1] = '\0';
                strcpy(str, s);

                /* If remove function returns 0 EXIT with failure (Something
                   went wrong with encoding) */
                if (!list_remove(list, str)) {
                    return EXIT_FAILURE;
                }

                free(str);
            /* Check if char array is digit, if so replace digit
               with char array */
            } else if (isdigit(s[0])) {
                free(str);
                int str = atoi(s);
                s = list_at_index(list, str);

                /* If index not found EXIT with failure (Something went wrong
                   with encoding.) */
                if (!s) {
                    return EXIT_FAILURE;
                }

            } else {
                free(str);
            }

            /* With this printf the output should be identical to the input. */
            printf("%s%c", s, sep);

            /* Go to next word */
            s = e + 1;
        }
    }

    // Cleanup.
    free(linebuf);
    fclose(infile);
    list_cleanup(list);
    return EXIT_SUCCESS;
}
