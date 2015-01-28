
.PHONY: all clean check

MYSQL_INCLUDE=/usr/include/mysql

##don't need to link against this library, the part we're using is completely contained in the header
#LIBS=-lboost_date_time
LIBS=

CC=g++
CFLAGS=-Wall -O2
COMPILE=$(CC) $(CFLAGS) -I $(MYSQL_INCLUDE) -c
OBJFILES=helpers.o isDate.o isNumeric.o ymdToDate.o

all: udf_itech.so

udf_itech.so: $(OBJFILES)
	$(CC) -shared $(LIBS) -o $@ $(OBJFILES)
	strip $@

test: $(OBJFILES) test.o
	$(CC) $(LIBS) -o $@ test.o $(OBJFILES)

%.o: %.cpp
	$(COMPILE) -o $@ $<

clean:
	rm -f *.o udf_itech.so test

check: test
	./test
