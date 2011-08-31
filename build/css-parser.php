<?php
/* Driver template for the PHP_CSSParserrGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class CSSParseryyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof CSSParseryyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof CSSParseryyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof CSSParseryyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof CSSParseryyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class CSSParseryyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here

// declare_class is output here
#line 3 "css-parser.y"
class CSSParser#line 102 "css-parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 4 "css-parser.y"

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
#line 124 "css-parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const CHARSET_SYM                    =  1;
    const STRING                         =  2;
    const SEMICOLON                      =  3;
    const CDO                            =  4;
    const CDC                            =  5;
    const S                              =  6;
    const IMPORT_SYM                     =  7;
    const URI                            =  8;
    const MEDIA_SYM                      =  9;
    const LCURLY                         = 10;
    const RCURLY                         = 11;
    const COMMA                          = 12;
    const IDENT                          = 13;
    const PAGE_SYM                       = 14;
    const COLON                          = 15;
    const SLASH                          = 16;
    const PLUS                           = 17;
    const GT                             = 18;
    const MINUS                          = 19;
    const HASH                           = 20;
    const DOT                            = 21;
    const STAR                           = 22;
    const LBRAKET                        = 23;
    const EQUALS                         = 24;
    const RBRAKET                        = 25;
    const DASHMATCH                      = 26;
    const INCLUDES                       = 27;
    const FUNCT                          = 28;
    const RPAREN                         = 29;
    const IMPORTANT_SYM                  = 30;
    const NUMBER                         = 31;
    const PERCENTAGE                     = 32;
    const LENGTH                         = 33;
    const EMS                            = 34;
    const EXS                            = 35;
    const ANGLE                          = 36;
    const TIME                           = 37;
    const FREQ                           = 38;
    const YY_NO_ACTION = 330;
    const YY_ACCEPT_ACTION = 329;
    const YY_ERROR_ACTION = 328;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 391;
static public $yy_action = array(
 /*     0 */    49,  329,  220,   90,   35,   14,   68,  109,   30,   32,
 /*    10 */   104,   69,  109,  159,   96,  179,  186,  189,   72,  162,
 /*    20 */   165,  166,  222,  221,  116,   10,   67,  222,  221,   46,
 /*    30 */    50,   54,   47,   45,   38,   41,   43,   49,    5,   93,
 /*    40 */   160,   25,   22,   68,  152,   23,   18,   19,   69,   58,
 /*    50 */    57,    6,  179,   82,  189,   72,    8,   77,  180,   34,
 /*    60 */    31,   37,  133,   67,   36,  169,   46,   50,   54,   47,
 /*    70 */    45,   38,   41,   43,   93,   66,   25,   22,  129,  152,
 /*    80 */    23,   18,   19,  184,   34,   31,   37,   99,  100,  103,
 /*    90 */   105,  108,   59,   44,   42,  182,   34,   31,   37,   93,
 /*   100 */   149,   25,   22,  191,  152,   23,   18,   19,   63,  117,
 /*   110 */    53,   93,  151,   25,   22,   71,  152,   23,   18,   19,
 /*   120 */   181,   34,   31,   37,  153,  142,   39,  115,   27,   58,
 /*   130 */    57,  192,   21,  118,  143,   62,   93,   60,   25,   22,
 /*   140 */    86,  152,   23,   18,   19,  133,   88,  187,  115,  139,
 /*   150 */   142,  106,  115,   16,  118,  178,   62,   21,  118,  143,
 /*   160 */    62,    9,  190,  101,  154,   78,   25,   22,  133,  152,
 /*   170 */    23,   18,   19,  132,  161,   53,  200,   12,   25,   22,
 /*   180 */    83,  152,   23,   18,   19,   65,  109,   25,   22,   24,
 /*   190 */   152,   23,   18,   19,   94,   26,  142,  130,  115,   11,
 /*   200 */    73,  222,  221,   21,  118,  143,   62,  140,   33,   25,
 /*   210 */    22,   56,  152,   23,   18,   19,   14,  142,  109,  115,
 /*   220 */   131,   28,  148,  206,   21,  118,  143,   62,  109,  145,
 /*   230 */   168,  165,  164,  222,  221,   61,  147,   70,   74,   85,
 /*   240 */   138,   11,  141,  222,  221,  201,  176,   15,   17,   20,
 /*   250 */   146,  224,   15,   17,   20,  150,  205,   15,   17,   20,
 /*   260 */   157,  203,   15,   17,   20,  198,  207,   15,   17,   20,
 /*   270 */    92,  195,   91,   15,   17,   20,  137,  202,   15,   17,
 /*   280 */    20,  197,   40,   15,   17,   20,  196,  124,   15,   17,
 /*   290 */    20,   64,   81,   75,   98,   84,  102,   95,   80,  158,
 /*   300 */    87,   55,  126,   29,   48,  204,  188,  134,  170,  171,
 /*   310 */   167,  135,  175,  136,  107,   52,  177,  208,  193,  216,
 /*   320 */    97,   76,  214,  182,  212,  182,  210,  172,  156,  182,
 /*   330 */   182,  155,   51,  182,  182,  182,  217,  182,  194,  182,
 /*   340 */   182,    1,  182,    4,   89,  211,   79,  182,  183,    2,
 /*   350 */   185,  182,    3,  173,  120,  213,  121,  223,  218,  112,
 /*   360 */   215,    7,  114,  123,  182,  113,  163,  182,  125,  182,
 /*   370 */    13,  111,  127,  182,  182,  144,  209,  182,  182,  182,
 /*   380 */   174,  182,  122,  182,  182,  199,  182,  128,  119,  219,
 /*   390 */   110,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,   40,   41,   42,   45,   58,    8,   60,    4,    5,
 /*    10 */    12,   13,   60,    2,   16,   17,    6,   19,   20,    8,
 /*    20 */    73,   74,   75,   76,   47,   73,   28,   75,   76,   31,
 /*    30 */    32,   33,   34,   35,   36,   37,   38,    2,    6,   62,
 /*    40 */    43,   64,   65,    8,   67,   68,   69,   70,   13,   17,
 /*    50 */    18,   43,   17,    7,   19,   20,   59,   56,   46,   47,
 /*    60 */    48,   49,   61,   28,   43,   43,   31,   32,   33,   34,
 /*    70 */    35,   36,   37,   38,   62,   12,   64,   65,   63,   67,
 /*    80 */    68,   69,   70,   46,   47,   48,   49,   31,   32,   33,
 /*    90 */    34,   35,   36,   37,   38,   46,   47,   48,   49,   62,
 /*   100 */    13,   64,   65,   43,   67,   68,   69,   70,   13,   52,
 /*   110 */    53,   62,   43,   64,   65,   28,   67,   68,   69,   70,
 /*   120 */    46,   47,   48,   49,   29,   13,    2,   15,   43,   17,
 /*   130 */    18,   43,   20,   21,   22,   23,   62,   13,   64,   65,
 /*   140 */    56,   67,   68,   69,   70,   61,    9,   43,   15,   25,
 /*   150 */    13,   14,   15,   20,   21,   72,   23,   20,   21,   22,
 /*   160 */    23,   59,   43,   56,   62,    3,   64,   65,   61,   67,
 /*   170 */    68,   69,   70,   51,   52,   53,   62,   43,   64,   65,
 /*   180 */    30,   67,   68,   69,   70,   62,   60,   64,   65,   43,
 /*   190 */    67,   68,   69,   70,   11,   43,   13,   71,   15,   73,
 /*   200 */     2,   75,   76,   20,   21,   22,   23,   62,   43,   64,
 /*   210 */    65,   13,   67,   68,   69,   70,   58,   13,   60,   15,
 /*   220 */    57,   43,    3,   25,   20,   21,   22,   23,   60,   43,
 /*   230 */    43,   73,   74,   75,   76,   24,   25,   26,   27,   71,
 /*   240 */    43,   73,   25,   75,   76,   66,   43,   68,   69,   70,
 /*   250 */    66,   25,   68,   69,   70,   66,   25,   68,   69,   70,
 /*   260 */    66,   25,   68,   69,   70,   66,   25,   68,   69,   70,
 /*   270 */    11,   66,   10,   68,   69,   70,   66,   13,   68,   69,
 /*   280 */    70,   66,    2,   68,   69,   70,   66,    2,   68,   69,
 /*   290 */    70,   13,   15,   13,   11,   13,   10,    3,   11,   29,
 /*   300 */    10,   29,    1,   43,   13,   25,   57,   57,   43,   43,
 /*   310 */    43,   55,   43,   15,   43,   12,   43,   25,   43,   43,
 /*   320 */    13,   53,   43,   77,   43,   77,   63,   43,   54,   77,
 /*   330 */    77,   43,   43,   77,   77,   77,   43,   77,   43,   77,
 /*   340 */    77,   44,   77,   44,   44,   43,   50,   77,   44,   44,
 /*   350 */    44,   77,   44,   43,   43,   43,   43,   43,   43,   43,
 /*   360 */    43,   43,   43,   43,   77,   43,   43,   77,   43,   77,
 /*   370 */    43,   43,   43,   77,   77,   54,   43,   77,   77,   77,
 /*   380 */    43,   77,   43,   77,   77,   43,   77,   43,   43,   43,
 /*   390 */    43,
);
    const YY_SHIFT_USE_DFLT = -3;
    const YY_SHIFT_MAX = 136;
    static public $yy_shift_ofst = array(
 /*     0 */   301,  137,  137,  137,  137,  112,  183,  204,  204,  204,
 /*    10 */    -2,   -2,   35,   35,   35,  133,  133,  133,  133,  133,
 /*    20 */   133,  133,  133,  133,  291,   32,  307,  291,  307,  307,
 /*    30 */     4,    4,    4,   11,    4,    4,    4,    4,   10,   10,
 /*    40 */    10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
 /*    50 */    10,  291,   10,  303,   10,   10,   10,   10,   10,   10,
 /*    60 */    10,   10,   10,   10,   10,   63,   10,   10,   10,   10,
 /*    70 */    10,   10,   10,   10,   10,   10,  303,  162,   10,   10,
 /*    80 */    10,   10,   10,   10,   10,  150,  162,   10,   10,   46,
 /*    90 */    10,   10,   10,   63,   10,   10,   10,   10,   10,   10,
 /*   100 */    10,  162,   10,   10,   10,   10,   10,  298,   10,   56,
 /*   110 */   211,  198,  280,  124,   95,   87,  259,  262,  264,  241,
 /*   120 */   236,  217,  226,  231,  219,  292,  285,  278,  270,  290,
 /*   130 */   272,  287,  294,  277,  283,  286,  282,
);
    const YY_REDUCE_USE_DFLT = -54;
    const YY_REDUCE_MAX = 108;
    static public $yy_reduce_ofst = array(
 /*     0 */   -39,   49,   12,   74,   37,  102,  -23,  123,  145,  114,
 /*    10 */   158,  -53,  168,  126,  -48,  205,  215,  220,  210,  184,
 /*    20 */   179,  189,  199,  194,  122,   -3,    1,   57,   84,  107,
 /*    30 */   306,  305,  304,  296,  297,  299,  300,  308,  312,  313,
 /*    40 */   311,  302,  310,  281,  284,  279,  275,  276,  288,  293,
 /*    50 */   295,  268,  289,  274,  317,  346,  345,  342,  333,  337,
 /*    60 */   339,  328,  329,  344,  347,  263,  318,  327,  314,  315,
 /*    70 */   316,  319,  323,  325,  322,  320,  321,  249,  152,  146,
 /*    80 */   119,  134,  165,  187,  197,   83,  163,  178,   85,  -41,
 /*    90 */    21,    8,  104,   15,   88,   69,   22,   60,  186,  265,
 /*   100 */   266,  250,  260,  203,  267,  273,  271,  256,  269,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(1, ),
        /* 1 */ array(9, 13, 14, 15, 20, 21, 22, 23, ),
        /* 2 */ array(9, 13, 14, 15, 20, 21, 22, 23, ),
        /* 3 */ array(9, 13, 14, 15, 20, 21, 22, 23, ),
        /* 4 */ array(9, 13, 14, 15, 20, 21, 22, 23, ),
        /* 5 */ array(13, 15, 17, 18, 20, 21, 22, 23, ),
        /* 6 */ array(11, 13, 15, 20, 21, 22, 23, ),
        /* 7 */ array(13, 15, 20, 21, 22, 23, ),
        /* 8 */ array(13, 15, 20, 21, 22, 23, ),
        /* 9 */ array(13, 15, 20, 21, 22, 23, ),
        /* 10 */ array(2, 8, 12, 13, 16, 17, 19, 20, 28, 31, 32, 33, 34, 35, 36, 37, 38, ),
        /* 11 */ array(2, 8, 12, 13, 16, 17, 19, 20, 28, 31, 32, 33, 34, 35, 36, 37, 38, ),
        /* 12 */ array(2, 8, 13, 17, 19, 20, 28, 31, 32, 33, 34, 35, 36, 37, 38, ),
        /* 13 */ array(2, 8, 13, 17, 19, 20, 28, 31, 32, 33, 34, 35, 36, 37, 38, ),
        /* 14 */ array(2, 8, 13, 17, 19, 20, 28, 31, 32, 33, 34, 35, 36, 37, 38, ),
        /* 15 */ array(15, 20, 21, 23, ),
        /* 16 */ array(15, 20, 21, 23, ),
        /* 17 */ array(15, 20, 21, 23, ),
        /* 18 */ array(15, 20, 21, 23, ),
        /* 19 */ array(15, 20, 21, 23, ),
        /* 20 */ array(15, 20, 21, 23, ),
        /* 21 */ array(15, 20, 21, 23, ),
        /* 22 */ array(15, 20, 21, 23, ),
        /* 23 */ array(15, 20, 21, 23, ),
        /* 24 */ array(13, ),
        /* 25 */ array(6, 17, 18, ),
        /* 26 */ array(13, ),
        /* 27 */ array(13, ),
        /* 28 */ array(13, ),
        /* 29 */ array(13, ),
        /* 30 */ array(4, 5, ),
        /* 31 */ array(4, 5, ),
        /* 32 */ array(4, 5, ),
        /* 33 */ array(2, 8, ),
        /* 34 */ array(4, 5, ),
        /* 35 */ array(4, 5, ),
        /* 36 */ array(4, 5, ),
        /* 37 */ array(4, 5, ),
        /* 38 */ array(6, ),
        /* 39 */ array(6, ),
        /* 40 */ array(6, ),
        /* 41 */ array(6, ),
        /* 42 */ array(6, ),
        /* 43 */ array(6, ),
        /* 44 */ array(6, ),
        /* 45 */ array(6, ),
        /* 46 */ array(6, ),
        /* 47 */ array(6, ),
        /* 48 */ array(6, ),
        /* 49 */ array(6, ),
        /* 50 */ array(6, ),
        /* 51 */ array(13, ),
        /* 52 */ array(6, ),
        /* 53 */ array(12, ),
        /* 54 */ array(6, ),
        /* 55 */ array(6, ),
        /* 56 */ array(6, ),
        /* 57 */ array(6, ),
        /* 58 */ array(6, ),
        /* 59 */ array(6, ),
        /* 60 */ array(6, ),
        /* 61 */ array(6, ),
        /* 62 */ array(6, ),
        /* 63 */ array(6, ),
        /* 64 */ array(6, ),
        /* 65 */ array(12, ),
        /* 66 */ array(6, ),
        /* 67 */ array(6, ),
        /* 68 */ array(6, ),
        /* 69 */ array(6, ),
        /* 70 */ array(6, ),
        /* 71 */ array(6, ),
        /* 72 */ array(6, ),
        /* 73 */ array(6, ),
        /* 74 */ array(6, ),
        /* 75 */ array(6, ),
        /* 76 */ array(12, ),
        /* 77 */ array(3, ),
        /* 78 */ array(6, ),
        /* 79 */ array(6, ),
        /* 80 */ array(6, ),
        /* 81 */ array(6, ),
        /* 82 */ array(6, ),
        /* 83 */ array(6, ),
        /* 84 */ array(6, ),
        /* 85 */ array(30, ),
        /* 86 */ array(3, ),
        /* 87 */ array(6, ),
        /* 88 */ array(6, ),
        /* 89 */ array(7, ),
        /* 90 */ array(6, ),
        /* 91 */ array(6, ),
        /* 92 */ array(6, ),
        /* 93 */ array(12, ),
        /* 94 */ array(6, ),
        /* 95 */ array(6, ),
        /* 96 */ array(6, ),
        /* 97 */ array(6, ),
        /* 98 */ array(6, ),
        /* 99 */ array(6, ),
        /* 100 */ array(6, ),
        /* 101 */ array(3, ),
        /* 102 */ array(6, ),
        /* 103 */ array(6, ),
        /* 104 */ array(6, ),
        /* 105 */ array(6, ),
        /* 106 */ array(6, ),
        /* 107 */ array(15, ),
        /* 108 */ array(6, ),
        /* 109 */ array(31, 32, 33, 34, 35, 36, 37, 38, ),
        /* 110 */ array(24, 25, 26, 27, ),
        /* 111 */ array(2, 13, 25, ),
        /* 112 */ array(2, 13, 25, ),
        /* 113 */ array(2, 13, 25, ),
        /* 114 */ array(13, 29, ),
        /* 115 */ array(13, 28, ),
        /* 116 */ array(11, ),
        /* 117 */ array(10, ),
        /* 118 */ array(13, ),
        /* 119 */ array(25, ),
        /* 120 */ array(25, ),
        /* 121 */ array(25, ),
        /* 122 */ array(25, ),
        /* 123 */ array(25, ),
        /* 124 */ array(3, ),
        /* 125 */ array(25, ),
        /* 126 */ array(2, ),
        /* 127 */ array(13, ),
        /* 128 */ array(29, ),
        /* 129 */ array(10, ),
        /* 130 */ array(29, ),
        /* 131 */ array(11, ),
        /* 132 */ array(3, ),
        /* 133 */ array(15, ),
        /* 134 */ array(11, ),
        /* 135 */ array(10, ),
        /* 136 */ array(13, ),
        /* 137 */ array(),
        /* 138 */ array(),
        /* 139 */ array(),
        /* 140 */ array(),
        /* 141 */ array(),
        /* 142 */ array(),
        /* 143 */ array(),
        /* 144 */ array(),
        /* 145 */ array(),
        /* 146 */ array(),
        /* 147 */ array(),
        /* 148 */ array(),
        /* 149 */ array(),
        /* 150 */ array(),
        /* 151 */ array(),
        /* 152 */ array(),
        /* 153 */ array(),
        /* 154 */ array(),
        /* 155 */ array(),
        /* 156 */ array(),
        /* 157 */ array(),
        /* 158 */ array(),
        /* 159 */ array(),
        /* 160 */ array(),
        /* 161 */ array(),
        /* 162 */ array(),
        /* 163 */ array(),
        /* 164 */ array(),
        /* 165 */ array(),
        /* 166 */ array(),
        /* 167 */ array(),
        /* 168 */ array(),
        /* 169 */ array(),
        /* 170 */ array(),
        /* 171 */ array(),
        /* 172 */ array(),
        /* 173 */ array(),
        /* 174 */ array(),
        /* 175 */ array(),
        /* 176 */ array(),
        /* 177 */ array(),
        /* 178 */ array(),
        /* 179 */ array(),
        /* 180 */ array(),
        /* 181 */ array(),
        /* 182 */ array(),
        /* 183 */ array(),
        /* 184 */ array(),
        /* 185 */ array(),
        /* 186 */ array(),
        /* 187 */ array(),
        /* 188 */ array(),
        /* 189 */ array(),
        /* 190 */ array(),
        /* 191 */ array(),
        /* 192 */ array(),
        /* 193 */ array(),
        /* 194 */ array(),
        /* 195 */ array(),
        /* 196 */ array(),
        /* 197 */ array(),
        /* 198 */ array(),
        /* 199 */ array(),
        /* 200 */ array(),
        /* 201 */ array(),
        /* 202 */ array(),
        /* 203 */ array(),
        /* 204 */ array(),
        /* 205 */ array(),
        /* 206 */ array(),
        /* 207 */ array(),
        /* 208 */ array(),
        /* 209 */ array(),
        /* 210 */ array(),
        /* 211 */ array(),
        /* 212 */ array(),
        /* 213 */ array(),
        /* 214 */ array(),
        /* 215 */ array(),
        /* 216 */ array(),
        /* 217 */ array(),
        /* 218 */ array(),
        /* 219 */ array(),
        /* 220 */ array(),
        /* 221 */ array(),
        /* 222 */ array(),
        /* 223 */ array(),
        /* 224 */ array(),
);
    static public $yy_default = array(
 /*     0 */   228,  235,  235,  235,  235,  236,  328,  328,  328,  328,
 /*    10 */   304,  300,  328,  328,  328,  275,  275,  275,  275,  275,
 /*    20 */   275,  275,  275,  275,  243,  237,  298,  328,  298,  298,
 /*    30 */   231,  231,  231,  328,  231,  231,  231,  231,  237,  237,
 /*    40 */   237,  237,  237,  237,  237,  237,  237,  237,  237,  237,
 /*    50 */   237,  328,  237,  248,  237,  237,  237,  237,  237,  237,
 /*    60 */   237,  237,  237,  237,  237,  262,  237,  237,  237,  237,
 /*    70 */   237,  237,  237,  237,  237,  237,  248,  264,  237,  237,
 /*    80 */   237,  237,  237,  237,  237,  297,  264,  237,  237,  239,
 /*    90 */   237,  237,  237,  262,  237,  237,  237,  237,  237,  237,
 /*   100 */   237,  264,  237,  237,  237,  237,  237,  252,  237,  328,
 /*   110 */   328,  328,  328,  328,  328,  328,  328,  328,  328,  328,
 /*   120 */   328,  328,  328,  328,  328,  328,  328,  328,  328,  328,
 /*   130 */   328,  328,  328,  328,  328,  328,  328,  278,  251,  291,
 /*   140 */   265,  290,  281,  282,  247,  250,  279,  292,  227,  293,
 /*   150 */   276,  238,  270,  295,  267,  249,  246,  277,  294,  240,
 /*   160 */   268,  242,  241,  327,  302,  303,  301,  254,  299,  253,
 /*   170 */   305,  306,  311,  312,  310,  309,  307,  308,  296,  258,
 /*   180 */   233,  234,  232,  230,  226,  229,  236,  244,  263,  257,
 /*   190 */   260,  259,  245,  313,  314,  272,  273,  271,  269,  256,
 /*   200 */   266,  274,  280,  287,  288,  286,  285,  283,  284,  255,
 /*   210 */   261,  319,  320,  318,  317,  315,  316,  321,  322,  326,
 /*   220 */   225,  325,  324,  323,  289,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 78;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 225;
    const YYNRULE = 103;
    const YYERRORSYMBOL = 39;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx = -1;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'CHARSET_SYM',   'STRING',        'SEMICOLON',   
  'CDO',           'CDC',           'S',             'IMPORT_SYM',  
  'URI',           'MEDIA_SYM',     'LCURLY',        'RCURLY',      
  'COMMA',         'IDENT',         'PAGE_SYM',      'COLON',       
  'SLASH',         'PLUS',          'GT',            'MINUS',       
  'HASH',          'DOT',           'STAR',          'LBRAKET',     
  'EQUALS',        'RBRAKET',       'DASHMATCH',     'INCLUDES',    
  'FUNCT',         'RPAREN',        'IMPORTANT_SYM',  'NUMBER',      
  'PERCENTAGE',    'LENGTH',        'EMS',           'EXS',         
  'ANGLE',         'TIME',          'FREQ',          'error',       
  'start',         'stylesheet',    'charset',       's',           
  'cdo_cdc',       'import',        'stylerules',    'ruleset',     
  'media',         'page',          'string_or_uri',  'possible_media_list',
  'media_list',    'medium',        'media_rep',     'pseudo_page', 
  'declaration',   'declsel',       'operator',      'combinator',  
  'unary_operator',  'property',      'selector',      'rulesel',     
  'simple_selector',  'element_name',  'sel_rep',       'sel_rep2',    
  'class',         'attrib',        'pseudo',        'expr',        
  'prio',          'term',          'expr_rep',      'funct',       
  'hexcolor',    
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= stylesheet",
 /*   1 */ "stylesheet ::= charset s cdo_cdc import cdo_cdc stylerules",
 /*   2 */ "charset ::= CHARSET_SYM STRING SEMICOLON",
 /*   3 */ "charset ::=",
 /*   4 */ "cdo_cdc ::= CDO cdo_cdc",
 /*   5 */ "cdo_cdc ::= CDC cdo_cdc",
 /*   6 */ "cdo_cdc ::=",
 /*   7 */ "stylerules ::= ruleset cdo_cdc stylerules",
 /*   8 */ "stylerules ::= media cdo_cdc stylerules",
 /*   9 */ "stylerules ::= page cdo_cdc stylerules",
 /*  10 */ "stylerules ::=",
 /*  11 */ "s ::= S",
 /*  12 */ "s ::=",
 /*  13 */ "import ::= IMPORT_SYM s string_or_uri s possible_media_list SEMICOLON s",
 /*  14 */ "import ::=",
 /*  15 */ "string_or_uri ::= STRING",
 /*  16 */ "string_or_uri ::= URI",
 /*  17 */ "possible_media_list ::= media_list",
 /*  18 */ "possible_media_list ::=",
 /*  19 */ "media ::= MEDIA_SYM s media_list LCURLY s ruleset RCURLY s",
 /*  20 */ "media ::= MEDIA_SYM s media_list LCURLY s RCURLY s",
 /*  21 */ "media_list ::= medium media_rep",
 /*  22 */ "media_rep ::= COMMA s medium media_rep",
 /*  23 */ "media_rep ::=",
 /*  24 */ "medium ::= IDENT s",
 /*  25 */ "page ::= PAGE_SYM s pseudo_page LCURLY s declaration declsel RCURLY s",
 /*  26 */ "pseudo_page ::= COLON IDENT s",
 /*  27 */ "pseudo_page ::=",
 /*  28 */ "operator ::= SLASH s",
 /*  29 */ "operator ::= COMMA s",
 /*  30 */ "combinator ::= PLUS s",
 /*  31 */ "combinator ::= GT s",
 /*  32 */ "unary_operator ::= MINUS",
 /*  33 */ "unary_operator ::= PLUS",
 /*  34 */ "property ::= IDENT s",
 /*  35 */ "ruleset ::= selector rulesel LCURLY s declaration declsel RCURLY s",
 /*  36 */ "rulesel ::= COMMA s selector rulesel",
 /*  37 */ "rulesel ::=",
 /*  38 */ "declsel ::= SEMICOLON s declaration declsel",
 /*  39 */ "declsel ::=",
 /*  40 */ "selector ::= simple_selector combinator selector",
 /*  41 */ "selector ::= simple_selector S combinator selector",
 /*  42 */ "selector ::= simple_selector S selector",
 /*  43 */ "selector ::= simple_selector s",
 /*  44 */ "simple_selector ::= element_name sel_rep",
 /*  45 */ "simple_selector ::= sel_rep2",
 /*  46 */ "sel_rep ::= HASH sel_rep",
 /*  47 */ "sel_rep ::= class sel_rep",
 /*  48 */ "sel_rep ::= attrib sel_rep",
 /*  49 */ "sel_rep ::= pseudo sel_rep",
 /*  50 */ "sel_rep ::=",
 /*  51 */ "sel_rep2 ::= HASH sel_rep",
 /*  52 */ "sel_rep2 ::= class sel_rep",
 /*  53 */ "sel_rep2 ::= attrib sel_rep",
 /*  54 */ "sel_rep2 ::= pseudo sel_rep",
 /*  55 */ "class ::= DOT IDENT",
 /*  56 */ "element_name ::= IDENT",
 /*  57 */ "element_name ::= STAR",
 /*  58 */ "attrib ::= LBRAKET s IDENT s EQUALS s IDENT s RBRAKET",
 /*  59 */ "attrib ::= LBRAKET s IDENT s EQUALS s STRING s RBRAKET",
 /*  60 */ "attrib ::= LBRAKET s IDENT s EQUALS s RBRAKET",
 /*  61 */ "attrib ::= LBRAKET s IDENT s DASHMATCH s IDENT s RBRAKET",
 /*  62 */ "attrib ::= LBRAKET s IDENT s DASHMATCH s STRING s RBRAKET",
 /*  63 */ "attrib ::= LBRAKET s IDENT s DASHMATCH s RBRAKET",
 /*  64 */ "attrib ::= LBRAKET s IDENT s INCLUDES s IDENT s RBRAKET",
 /*  65 */ "attrib ::= LBRAKET s IDENT s INCLUDES s STRING s RBRAKET",
 /*  66 */ "attrib ::= LBRAKET s IDENT s INCLUDES s RBRAKET",
 /*  67 */ "attrib ::= LBRAKET s IDENT s RBRAKET",
 /*  68 */ "pseudo ::= COLON IDENT",
 /*  69 */ "pseudo ::= COLON FUNCT s IDENT s RPAREN",
 /*  70 */ "pseudo ::= COLON FUNCT s RPAREN",
 /*  71 */ "declaration ::= property COLON s expr prio",
 /*  72 */ "declaration ::= property COLON s expr",
 /*  73 */ "declaration ::=",
 /*  74 */ "prio ::= IMPORTANT_SYM s",
 /*  75 */ "expr ::= term",
 /*  76 */ "expr ::= term expr_rep",
 /*  77 */ "expr_rep ::= operator term expr_rep",
 /*  78 */ "expr_rep ::= term",
 /*  79 */ "expr_rep ::=",
 /*  80 */ "term ::= unary_operator NUMBER s",
 /*  81 */ "term ::= unary_operator PERCENTAGE s",
 /*  82 */ "term ::= unary_operator LENGTH s",
 /*  83 */ "term ::= unary_operator EMS s",
 /*  84 */ "term ::= unary_operator EXS s",
 /*  85 */ "term ::= unary_operator ANGLE s",
 /*  86 */ "term ::= unary_operator TIME s",
 /*  87 */ "term ::= unary_operator FREQ s",
 /*  88 */ "term ::= NUMBER s",
 /*  89 */ "term ::= PERCENTAGE s",
 /*  90 */ "term ::= LENGTH s",
 /*  91 */ "term ::= EMS s",
 /*  92 */ "term ::= EXS s",
 /*  93 */ "term ::= ANGLE s",
 /*  94 */ "term ::= TIME s",
 /*  95 */ "term ::= FREQ s",
 /*  96 */ "term ::= STRING s",
 /*  97 */ "term ::= IDENT s",
 /*  98 */ "term ::= URI s",
 /*  99 */ "term ::= funct",
 /* 100 */ "term ::= hexcolor",
 /* 101 */ "funct ::= FUNCT s expr RPAREN s",
 /* 102 */ "hexcolor ::= HASH s",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param CSSParseryyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new CSSParseryyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new CSSParseryyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
#line 37 "css-parser.y"

    $this->internalError = true;
#line 1165 "css-parser.php"
            return;
        }
        $yytos = new CSSParseryyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for ($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 40, 'rhs' => 1 ),
  array( 'lhs' => 41, 'rhs' => 6 ),
  array( 'lhs' => 42, 'rhs' => 3 ),
  array( 'lhs' => 42, 'rhs' => 0 ),
  array( 'lhs' => 44, 'rhs' => 2 ),
  array( 'lhs' => 44, 'rhs' => 2 ),
  array( 'lhs' => 44, 'rhs' => 0 ),
  array( 'lhs' => 46, 'rhs' => 3 ),
  array( 'lhs' => 46, 'rhs' => 3 ),
  array( 'lhs' => 46, 'rhs' => 3 ),
  array( 'lhs' => 46, 'rhs' => 0 ),
  array( 'lhs' => 43, 'rhs' => 1 ),
  array( 'lhs' => 43, 'rhs' => 0 ),
  array( 'lhs' => 45, 'rhs' => 7 ),
  array( 'lhs' => 45, 'rhs' => 0 ),
  array( 'lhs' => 50, 'rhs' => 1 ),
  array( 'lhs' => 50, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 0 ),
  array( 'lhs' => 48, 'rhs' => 8 ),
  array( 'lhs' => 48, 'rhs' => 7 ),
  array( 'lhs' => 52, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 4 ),
  array( 'lhs' => 54, 'rhs' => 0 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 49, 'rhs' => 9 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 0 ),
  array( 'lhs' => 58, 'rhs' => 2 ),
  array( 'lhs' => 58, 'rhs' => 2 ),
  array( 'lhs' => 59, 'rhs' => 2 ),
  array( 'lhs' => 59, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 2 ),
  array( 'lhs' => 47, 'rhs' => 8 ),
  array( 'lhs' => 63, 'rhs' => 4 ),
  array( 'lhs' => 63, 'rhs' => 0 ),
  array( 'lhs' => 57, 'rhs' => 4 ),
  array( 'lhs' => 57, 'rhs' => 0 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 4 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 0 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 68, 'rhs' => 2 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 9 ),
  array( 'lhs' => 69, 'rhs' => 9 ),
  array( 'lhs' => 69, 'rhs' => 7 ),
  array( 'lhs' => 69, 'rhs' => 9 ),
  array( 'lhs' => 69, 'rhs' => 9 ),
  array( 'lhs' => 69, 'rhs' => 7 ),
  array( 'lhs' => 69, 'rhs' => 9 ),
  array( 'lhs' => 69, 'rhs' => 9 ),
  array( 'lhs' => 69, 'rhs' => 7 ),
  array( 'lhs' => 69, 'rhs' => 5 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 6 ),
  array( 'lhs' => 70, 'rhs' => 4 ),
  array( 'lhs' => 56, 'rhs' => 5 ),
  array( 'lhs' => 56, 'rhs' => 4 ),
  array( 'lhs' => 56, 'rhs' => 0 ),
  array( 'lhs' => 72, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 74, 'rhs' => 3 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 0 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 5 ),
  array( 'lhs' => 76, 'rhs' => 2 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //CSSParseryyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for ($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new CSSParseryyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 31 "css-parser.y"

    $this->internalError = true;
    $this->yymajor = $yymajor;
#line 1434 "css-parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
#line 23 "css-parser.y"

    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
#line 1459 "css-parser.php"
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int   $yymajor      the token number
     * @param mixed $yytokenvalue the token value
     * @param mixed ...           any extra arguments that should be passed to handlers
     *
     * @return void
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new CSSParseryyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(
                self::$yyTraceFILE,
                "%sInput %s\n",
                self::$yyTracePrompt,
                self::$yyTokenName[$yymajor]
            );
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL
                && !$this->yy_is_expected_token($yymajor)
            ) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(
                        self::$yyTraceFILE,
                        "%sSyntax Error!\n",
                        self::$yyTracePrompt
                    );
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ) {
                        if (self::$yyTraceFILE) {
                            fprintf(
                                self::$yyTraceFILE,
                                "%sDiscard input token %s\n",
                                self::$yyTracePrompt,
                                self::$yyTokenName[$yymajor]
                            );
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0
                            && $yymx != self::YYERRORSYMBOL
                            && ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                        ) {
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}
