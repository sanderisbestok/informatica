/*  Author:         Sander Hansen
    Name:           ac.c
    Description:    Will add a text file to an autocomplete datastructure,
                    from which can be searched for prefixes, words can be
                    removed, and it can be printed.
    Usage:          ./autocomplete [-p or -r or -P] File
    Comments:       If usage is not clear, just use it with ./autocomplete and
                    instructions will be printed*/
#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <unistd.h>
#include <getopt.h>
#include <assert.h>
#include <string.h>
#include <time.h>

#include "ac.h"

#define BUF_SIZE 10000
#define DELIM "-!?\",. \n"

void usage(char* prog) {
    fprintf(stderr, "Usage %s [OPTION]... FILE\n"
                    "Autocomplete prefixes using words in FILE.\n"
                    "  -p prefix  print words with prefix\n"
                    "  -r rmfile  remove words in rmfile\n"
                    "  -P         print trie\n"
                    , prog);
    exit(EXIT_SUCCESS);
}

/* Command line option struct type */
typedef struct {
    char *prefix;
    char *infile_name;
    char *rm_file;
    bool print;
    bool verbose;
} args_t;


/* Handle command line arguments.
   Return struct with options set. */
args_t parse_args(int argc, char *argv[]) {
    int opt;
    args_t args = { .prefix=NULL, .infile_name=NULL, .rm_file=NULL,
                   .print=false, .verbose=false };

    while ((opt = getopt(argc, argv, "Pp:r:")) != -1) {
        switch(opt) {
            case 'p':
                args.prefix = optarg;
                break;
            case 'P':
                args.print = true;
                break;
            case 'r':
                args.rm_file = optarg;
                break;
            default: /* '?' */
                usage(argv[0]);
        }
    }
    if (optind >= argc) {
        usage(argv[0]); // expect at least input filename.
    } else {
        args.infile_name = argv[optind];
    }
    return args;
}

/* Open input file and return file pointer. If remove is 1 open remove file
   if remove is 0 open read file, and the ac struct, (If remove file doesn't
   excist the tree has to bee freed)*/
FILE *open_file(args_t args, int remove, struct ac *t) {
    FILE *f;

    if (remove) {
        f = fopen(args.rm_file, "r");
    } else {
        f = fopen(args.infile_name, "r");
    }
    if (!f) {
        if (remove) {
            ac_cleanup(t);
        }
        perror(args.infile_name);
        exit(EXIT_FAILURE);
    }
    return f;
}

/* Read lines from infile, tokenize every line and add
   each word to the trie.
   Return the number of words added. */
int trie_actions(FILE *infile, struct ac *t, int remove) {
    char *w, *linebuf;
    int difference = 0;

    linebuf = malloc(BUF_SIZE);

    while (fgets(linebuf, BUF_SIZE, infile) != NULL) {
        w = strtok(linebuf, DELIM); // strtok receives the new line of text.
        while (w) {
            if (remove) {
                if(ac_remove(t, w))
                difference += 1;
                w = strtok(NULL, DELIM); // get next token from current line.
            } else {
                if (ac_add(t, w))
                difference += 1;
                w = strtok(NULL, DELIM); // get next token from current line.
            }
        }
    }
    free(linebuf);
    return difference;
}

int main(int argc, char* argv[]) {
    FILE *infile;
    FILE *rmwords;
    int added = 0;
    struct ac* t;
    args_t args;

    /* Parse command line arguments. */
    args = parse_args(argc, argv);

    /* Open input text file. */
    infile = open_file(args, 0, NULL);

    /* Initialize the trie autocomplete data structure. */
    t = ac_init();

    /* Fill trie. */
    added = trie_actions(infile, t, 0);

    printf("Words added to trie: %d\n", added);
    printf("Number of words in trie: %d\n", ac_count(t));

    double cpu_time_used;
    clock_t start, end;
    start = clock();
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    ac_prefix(t, "e");
    end = clock();
    cpu_time_used = ((double)(end - start)) / CLOCKS_PER_SEC;

    printf("Total time taken by CPU: %f\n", cpu_time_used);
    if (args.prefix) {
        printf("Prefixes of: %s\n", args.prefix);
        ac_prefix(t, args.prefix);
    }

    if (args.rm_file) {
        rmwords = open_file(args, 1, t);
        /* Remove words by calling function */
        int removed = trie_actions(rmwords, t, 1);
        fclose(rmwords);

        printf("Words removed from trie: %d\n", removed);
    }

    if (args.print) {
        printf("All words stored:\n");
        ac_print(t);
    }

    /* Cleanup */
    fclose(infile);
    printf("Number of words freed: %d\n", ac_cleanup(t));
    return EXIT_SUCCESS;
}
