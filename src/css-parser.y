%name CSSParser

%declare_class {class CSSParser}
%include_class {
    static public $transTable = array();
    const YYTEXT = 1024;
    const COMMENT = 1025;
    public $successful = true;
    public $retvalue = 0;
    private $lex;
    private $internalError = false;

    function __construct() {
        #if (!count(self::$transTable)) {
        #    self::$transTable = array(
        #        ord(';') => self::SEMICOLON,
        #    );
        #}
    }
}

%parse_accept
{
    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
}

%syntax_error
{
    $this->internalError = true;
    $this->yymajor = $yymajor;
}

%stack_overflow
{
    $this->internalError = true;
}

start ::= stylesheet.

stylesheet ::= charset s cdo_cdc import cdo_cdc stylerules.

charset ::= CHARSET_SYM STRING SEMICOLON.
charset ::= .
cdo_cdc ::= CDO cdo_cdc.
cdo_cdc ::= CDC cdo_cdc.
cdo_cdc ::= .
stylerules ::= ruleset cdo_cdc stylerules.
stylerules ::= media cdo_cdc stylerules.
stylerules ::= page cdo_cdc stylerules.
stylerules ::= .

s ::= S.
s ::= .

import ::= IMPORT_SYM s string_or_uri s possible_media_list SEMICOLON s.
import ::= .

string_or_uri ::= STRING.
string_or_uri ::= URI.
possible_media_list ::= media_list.
possible_media_list ::= .

media ::= MEDIA_SYM s media_list LCURLY s ruleset RCURLY s.
media ::= MEDIA_SYM s media_list LCURLY s RCURLY s.

media_list ::= medium media_rep.
media_rep ::= COMMA s medium media_rep.
media_rep ::= .

medium ::= IDENT s.

page ::= PAGE_SYM s pseudo_page LCURLY s declaration declsel RCURLY s.

pseudo_page ::= COLON IDENT s.
pseudo_page ::= .

operator ::= SLASH s.
operator ::= COMMA s.

combinator ::= PLUS s.
combinator ::= GT s.

unary_operator ::= MINUS.
unary_operator ::= PLUS.

property ::= IDENT s.

ruleset ::= selector rulesel LCURLY s declaration declsel RCURLY s.
rulesel ::= COMMA s selector rulesel.
rulesel ::= .
declsel ::= SEMICOLON s declaration declsel.
declsel ::= .

selector ::= simple_selector combinator selector.
selector ::= simple_selector S combinator selector.
selector ::= simple_selector S selector.
selector ::= simple_selector s.

simple_selector ::= element_name sel_rep.
simple_selector ::= sel_rep2.
sel_rep ::= HASH sel_rep.
sel_rep ::= class sel_rep.
sel_rep ::= attrib sel_rep.
sel_rep ::= pseudo sel_rep.
sel_rep ::= .
sel_rep2 ::= HASH sel_rep.
sel_rep2 ::= class sel_rep.
sel_rep2 ::= attrib sel_rep.
sel_rep2 ::= pseudo sel_rep.

class ::= DOT IDENT.

element_name ::= IDENT.
element_name ::= STAR.

attrib ::= LBRAKET s IDENT s EQUALS s IDENT s RBRAKET.
attrib ::= LBRAKET s IDENT s EQUALS s STRING s RBRAKET.
attrib ::= LBRAKET s IDENT s EQUALS s RBRAKET.
attrib ::= LBRAKET s IDENT s DASHMATCH s IDENT s RBRAKET.
attrib ::= LBRAKET s IDENT s DASHMATCH s STRING s RBRAKET.
attrib ::= LBRAKET s IDENT s DASHMATCH s RBRAKET.
attrib ::= LBRAKET s IDENT s INCLUDES s IDENT s RBRAKET.
attrib ::= LBRAKET s IDENT s INCLUDES s STRING s RBRAKET.
attrib ::= LBRAKET s IDENT s INCLUDES s RBRAKET.
attrib ::= LBRAKET s IDENT s RBRAKET.

pseudo ::= COLON IDENT.
pseudo ::= COLON FUNCT s IDENT s RPAREN.
pseudo ::= COLON FUNCT s RPAREN.

declaration ::= property COLON s expr prio.
declaration ::= property COLON s expr.
declaration ::= .

prio ::= IMPORTANT_SYM s.

expr ::= term.
expr ::= term expr_rep.
expr_rep ::= operator term expr_rep.
expr_rep ::= term.
expr_rep ::= .

term ::= unary_operator NUMBER s.
term ::= unary_operator PERCENTAGE s.
term ::= unary_operator LENGTH s.
term ::= unary_operator EMS s.
term ::= unary_operator EXS s.
term ::= unary_operator ANGLE s.
term ::= unary_operator TIME s.
term ::= unary_operator FREQ s.
term ::= NUMBER s.
term ::= PERCENTAGE s.
term ::= LENGTH s.
term ::= EMS s.
term ::= EXS s.
term ::= ANGLE s.
term ::= TIME s.
term ::= FREQ s.
term ::= STRING s.
term ::= IDENT s.
term ::= URI s.
term ::= funct.
term ::= hexcolor.

funct ::= FUNCT s expr RPAREN s.

hexcolor ::= HASH s.


