CC=gcc

# no-unused-parameter used here to supress warnings in the incomplete
# template code. Remove this flag when you have added your own code.
#CFLAGS= -std=c99 -Wall -Wextra -pedantic -Wno-unused-parameter

# debug flags.
CFLAGS= -ggdb3 -DDEBUG -std=c11 -Wall -Wextra -pedantic -Wno-unused-parameter -O2

all: autocomplete

autocomplete: ll.o autocomplete.o ac.o

autocomplete.o: ll.h ac.h

clean:
	rm -f *.o autocomplete
