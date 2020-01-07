PROGNAME = assign2_3
SRCFILES = test.c mybcast.c
TARNAME = assign2_3.tgz

CC = mpicc

WARNFLAGS = -Wall -Werror-implicit-function-declaration -Wshadow \
		  -Wstrict-prototypes -pedantic-errors
CFLAGS = -std=c99 -ggdb -O2 $(WARNFLAGS) -D_POSIX_C_SOURCE=200112
LFLAGS = 

# Do some substitution to get a list of .o files from the given .c files.
OBJFILES = $(patsubst %.c,%.o,$(SRCFILES))

.PHONY: all run runlocal plot clean dist todo

all: $(PROGNAME)

$(PROGNAME): $(OBJFILES)
	$(CC) $(CFLAGS) -o $@ $^ $(LFLAGS)

%.o: %.c
	$(CC) -c $(CFLAGS) -o $@ $<

dist:
	tar cvzf $(TARNAME) Makefile *.c *.h data/

clean:
	rm -fv $(PROGNAME) $(OBJFILES) $(TARNAME) 
