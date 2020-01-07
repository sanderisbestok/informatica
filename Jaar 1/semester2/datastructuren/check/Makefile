# Enter you UVAID here
UVAID=10995080
PROGNAME=checker

# Commands for creating the submit archive
MKDIR=mkdir
PACK=tar -jcvf
CP=cp
RM=rm -rf

CC=gcc
# You can use gcc instead if you want
#CC=gcc

CFLAGS=  -std=c11 -Wall -Wextra -pedantic
# debug flags.
#CFLAGS= -g3 -DDEBUG -std=c11 -Wall -Wextra -pedantic

all: checker

checker: checker.o

check: checker
	./checker

clean:
	rm -f *.o checker

tarball: all
	$(MAKE) clean
	$(MKDIR) $(PROGNAME)-$(UVAID)
	$(CP) * $(PROGNAME)-$(UVAID) || true
	$(PACK) $(PROGNAME)-$(UVAID).tbz $(PROGNAME)-$(UVAID)/*
	$(RM) $(PROGNAME)-$(UVAID)
