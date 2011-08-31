
.PHONY: build all test clean

all: build

build: build/css-parser.php build/css-lexer.php

build/css-parser.php: src/css-parser.php
	cp src/css-parser.php build/

src/css-parser.php: src/css-parser.y
	cd src && php ParserGenerator/cli.php css-parser.y

build/css-lexer.php: src/css-lexer.php
	cp src/css-lexer.php build/

src/css-lexer.php: src/css-lexer.plex
	cd src && php create_lexer.php

test:

clean:

