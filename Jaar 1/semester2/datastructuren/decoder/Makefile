#CC=clang
CC=gcc
CFLAGS= -std=c11 -Wall -Wextra -fsanitize=address
LDFLAGS= -fsanitize=address
# Enable debug_print and debug_do
#CFLAGS= -DDEBUG -g3 -std=c11 -Wall -Wextra

input_dir=input

all: decoder

decoder: decoder.o ll.o

decoder.o: debug.h ll.h

ll.o: ll.h

check: encoder decoder
	make -C $(input_dir) clean
	make -C $(input_dir) check

clean:
	make -C $(input_dir) clean
	rm -f *.o decoder
