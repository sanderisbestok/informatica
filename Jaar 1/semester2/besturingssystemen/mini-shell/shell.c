#include "ast.h"
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <signal.h>

pid_t running_proc = 0;

void node_types(node_t* node);

void catch_interrupt(int catch) {
  if(catch == 2) {
    printf("\nTo exit this program please enter 'exit' as a command.\n Please press enter. \n");
    if (running_proc) waitpid(running_proc, NULL, 0);
  }
}

void initialize(void) {
    struct sigaction signal_s = {.sa_handler = &catch_interrupt};
    sigemptyset(&signal_s.sa_mask);
    sigaction(SIGINT, &signal_s, NULL);
}

//TODO check if arg is int
void exit_command(char **argv, int size) {
    if (size == 1) {
        exit(0);
    } else if (size == 2){
        int argument = atoi(argv[1]);
        exit(argument);
    } else {
        printf("Too many arguments given");
    }
}

int cd_command(char **argv) {
    char current[1024];
    char next[1024];
    getcwd(current, sizeof(current));
    chdir(argv[1]);
    getcwd(next, sizeof(next));
    if(!strcmp(current, next)) {
        printf("Requested folder doesn't exist.\n");
        return 0;
    }
    return 1;
}

void switch_command(char *program, char **argv, int size) {
    pid_t pid;
    if (!strcmp(program,"cd")) {
        cd_command(argv);
    } else if (!strcmp(program,"exit")) {
        exit_command(argv, size);
    } else if (!strcmp(program,"set")) {
        char *arg1, *arg2;

        arg1 = strtok(argv[1], "=");
        arg2 = strtok(NULL, "=");
        setenv(arg1, arg2, 1);
    } else if (!strcmp(program,"unset")) {
        unsetenv(argv[1]);
    } else {
        pid = fork();
        if (pid < 0) {
            perror("");
            exit(0);
        } else if (pid == 0) {
            if (execvp(program, argv) == -1) {
                perror("");
                exit(0);
            }
        } else {
            running_proc = pid;
            waitpid(pid, NULL, 0);
            running_proc = 0;
        }
    }
}

void pipe_command(node_t* node) {
    int std[2], old;

    for (size_t i = 0; i < node->pipe.n_parts; ++i) {
        pipe(std);
        if (!fork()) {
            if (!i) {
                dup2(std[1], 1);
            } else if (!(i == (node->pipe.n_parts - 1))) {
                dup2(std[1], 1);
                dup2(old, 0);
            } else {
                dup2(old, 0);
            }
            close(std[0]);
            close(std[1]);

            node_types(node->pipe.parts[i]);
            exit(0);
        } else {
            if (i) {
                close(old);
            }
            old = std[0];
            close(std[1]);
        }
    }

    close(old);
    for (size_t i = 0; i < node->pipe.n_parts ; ++i) {
        wait(NULL);
    }
}

void node_types(node_t* node) {
    if (node->type == NODE_COMMAND) {
        char *program = node->command.program;
        char **argv = node->command.argv;
        int size = node->command.argc;
        switch_command(program, argv, size);
    } else if (node->type == NODE_SEQUENCE) {
        node_t* first = node->sequence.first;
        node_t* second = node->sequence.second;

        node_types(first);
        node_types(second);
    } else if (node->type == NODE_PIPE) {
        pipe_command(node);
    }
}

void run_command(node_t* node) {
    node_types(node);

    // (for testing:)
    //print_tree(node);

    // don't forget:
    free_tree(node);
}
