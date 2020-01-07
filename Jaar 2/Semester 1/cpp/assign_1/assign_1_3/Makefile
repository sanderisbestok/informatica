all: 
	gcc -std=c99 -D_POSIX_C_SOURCE=200112 -ggdb -o sieve sieve.c queue.c timer.c -lpthread

run: 
	prun -v -np 1 sieve

runlocal: 
	./sieve
    
clean: 
	rm -rf sieve
