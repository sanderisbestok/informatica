# Enter you UVAID here
UVAID=10995080
PROGNAME=checksum

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

all: checksum

checksum: checksum.o

checksum.o: debug.h

check: checksum
	@echo "First five serial numbers are valid."
	@echo "The last two are invalid and should fail the tests."
	./checksum < serials.txt

clean:
	rm -f *.o checksum

tarball: all
	$(MAKE) clean
	$(MKDIR) $(PROGNAME)-$(UVAID)
	$(CP) * $(PROGNAME)-$(UVAID) || true
	$(PACK) $(PROGNAME)-$(UVAID).tbz $(PROGNAME)-$(UVAID)/*
	$(RM) $(PROGNAME)-$(UVAID)
