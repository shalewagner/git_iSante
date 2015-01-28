
.PHONY: all lib cgi cli clean

PROG=sqlProcess
OPTIONS=-O2 -fPIC

HASKELL_INCLUDE=-I/usr/lib/ghc-$(shell ghc --version |grep -o "version .*" |cut -f 2 -d " ")/include
PHP_BASE_INCLUDE=$(shell php-config --include-dir)
PHP_ALL_INCLUDE=\
	-I$(PHP_BASE_INCLUDE) \
	-I$(PHP_BASE_INCLUDE)/main \
	-I$(PHP_BASE_INCLUDE)/Zend \
	-I$(PHP_BASE_INCLUDE)/TSRM
PHP_LIB=itech_sql.so

GHC_VERSION=$(shell ghc --numeric-version)
ifeq ($(GHC_VERSION),6.8.2)
#This is for 32 bit GHC 6.8 on Debian 5.0
#No way to build this with 64 bit GHC 6.8
PHP_LIB_OPTIONS=-ffi -no-hs-main -optl -shared -rdynamic
else
PHP_LIB_OPTIONS=-XForeignFunctionInterface -no-hs-main -dynamic -shared -rdynamic -lHSrts-ghc6.12.1 -L/usr/lib/ghc-6.12.1
endif

all: lib

lib: ~/.cabal/lib/parsec-2.1.0.1
	rm -f $(PHP_LIB)
	cc -fpic -DCOMPILE_DL=1 $(PHP_ALL_INCLUDE) $(HASKELL_INCLUDE) -c phpExtension.c
	ghc $(OPTIONS) $(PHP_LIB_OPTIONS) --make CLibrary -o $(PHP_LIB) phpExtension.o
	strip $(PHP_LIB)

cgi:
	ghc $(OPTIONS) --make Cgi -o $(PROG).cgi
	strip $(PROG).cgi

cli:
	ghc $(OPTIONS) --make Cli -o $(PROG).cli
	strip $(PROG).cli

clean:
	rm -rf *.hi *.o CLibrary_stub.c *~ $(PROG).cli $(PROG).cgi $(PHP_LIB)

~/.cabal/lib/parsec-2.1.0.1:
ifeq ($(GHC_VERSION),6.8.2)
	mkdir -p ~/.cabal/lib/parsec-2.1.0.1
else
	cabal update
	cabal install parsec-2.1.0.1 --enable-shared --reinstall
endif
