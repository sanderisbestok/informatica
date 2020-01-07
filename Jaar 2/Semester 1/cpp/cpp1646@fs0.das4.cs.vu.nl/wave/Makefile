PROGNAME = assign1_2
SRCFILES = assign1_2.c file.c
TARNAME = assign1_2.tgz

RUNARGS = 1000 1000 1 # i_max t_max num_threads, increase this when testing on the DAS4!

IMAGEVIEW = display
CC = gcc

WARNFLAGS = -Wall -Werror-implicit-function-declaration -Wshadow \
		  -Wstrict-prototypes -pedantic-errors
CFLAGS = -std=c99 -ggdb -O2 $(WARNFLAGS) -D_POSIX_C_SOURCE=200112 -fopenmp
LFLAGS = -lm -lrt

# Do some substitution to get a list of .o files from the given .c files.
OBJFILES = $(patsubst %.c,%.o,$(SRCFILES))

NVCC		= nvcc
#CU_FLAGS	= -O3 -g -deviceemu
CU_FLAGS	= -O3 -g --ptxas-options=-v -arch compute_20 -code sm_20
CC_FLAGS	= -O3 -m64 -Wall

CU_SOURCES	= simulate.cu

CU_OBJECTS	= $(CU_SOURCES:%.cu=%.o)
CU_PTX		= $(CU_SOURCES:%.cu=%.ptx)

.PHONY: all run runlocal plot clean dist todo

all: vector-add $(PROGNAME)

$(PROGNAME): $(OBJFILES)
	$(NVCC) $(CU_FLAGS) -o $@ $^ simulate.o $(LFLAGS)

simulate.o:		simulate.cu
	$(NVCC) $(CU_FLAGS) -c $< -o $@

assign1_2.o: assign1_2.c
	$(CC) -c $(CFLAGS) -o $@ $<

file.o: file.c
	$(CC) -c $(CFLAGS) -o $@ $<

plot: result.txt
	gnuplot plot.gnp
	$(IMAGEVIEW) plot.png

dist:
	tar cvzf $(TARNAME) Makefile *.c *.h data/

clean:
	rm -fv $(PROGNAME) $(OBJFILES) $(TARNAME) result.txt plot.png
	rm -f *.o vector-add *~

%.ptx:		%.cu
		$(NVCC) $(CU_FLAGS) --ptx $< -o $@

vector-add:	$(CU_OBJECTS) $(CC_OBJECTS)
# 		$(NVCC) $^ -o $@

ptx:		$(CU_PTX) 
