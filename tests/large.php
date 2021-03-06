<?php
error_reporting(E_ALL);

require_once "../build/css-parser.php";
require_once "../build/css-lexer.php";







$lexer = new CSSLexer(<<<STYLEDOC

@charset "UTF-8";

@namespace "http://www.w3.org/1999/xhtml";

@\\0070age {}

@\\pa\ge {}


/**
 * R E S E T =============================================================== *
 *
 * This part resets many of the browsers' default rendering properties that
 * are mostly incompatible to one another.
 *
 * We also establish a basic line height of 15px and take care, that headings
 * and other elements are drawn with baseline heights that are a multiple of
 * 5px.
 *
 * @see Bases loosely on Eric Meyer's reset stylesheet,
 *      <http://meyerweb.com/eric/tools/css/reset/>
 */

html, body, div, span, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote,
ul, ol, dl, li, dt, dd,
form, fieldset, pre, label, legend,
a, abbr, address, cite, code,
del, dfn, em, img, ins, kbd, q, samp,
strong, sub, sup, tt, var, hr,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, dialog, figcaption, figure, footer, header,
hgroup, menu, nav, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  outline: 0;
  font-weight: inherit;
  font-style: inherit;
  font-size: 100%;
  font-family: inherit;
  vertical-align: baseline;
}

\\0034, article, aside, dialog, figcaption, figure, footer, header,
hgroup, menu, nav, section {
  display: block;
}

html {
  overflow-y: scroll;
}

body {
  font: 100%/1.5em "Droid Serif", 'DejaVu Serif', Georgia, serif;
  color: #333;
  background: #FAF9F2 url(body.png) repeat;
  margin: 0 auto;
  overflow-x: hidden;
}

table {
  border-spacing: 0;
  border-collapse: collapse;
}

caption, td, th {
  text-align: left;
}

h1 {
  font-size:  2.0em;
  line-height: 1.25;
  margin:  0 auto .625em auto;
}

h2 {
  font-size:  1.75em;
  line-height: 1.4285;
  margin: .714285em auto;
}

h3 {
  font-size:  1.5em;
  line-height: 1.6667;
  font-style: italic;
  margin: .83333em auto;
}

h4 {
  font-size:  1.125em;
  letter-spacing: .15em;
  line-height: 1.111111;
  margin: 1.11111em auto;
}

h5 {
  font-size:  1.0em;
  line-height: 1.25;
  margin: 1.25em auto;
  letter-spacing: .1em;
  text-transform: lowercase;
  font-variant: small-caps;
}

h6 {
  font-size: 1.0em;
  line-height: 1.25;
  margin: .625em auto;
}

h1:first-child,
h2:first-child,
h3:first-child,
h4:first-child,
h5:first-child {
  margin-top: 0;
}

label, button, input[type=submit], input[type=reset],
input[type=image], .ui-clickable {
  cursor: pointer;
  vertical-align: middle;
}

/**
 * these are 'magic' statements to remove the also 'magic'
 * padding in some browsers.
 *
 * @see <http://jehiah.cz/archive/button-width-in-ie>
 * @bugfix
 */
.button,
button, input[type=submit], input[type=reset] {
  padding: 0.084em;
  width: auto;
  overflow: visible;
  text-align: center;
  outline: none;
}

/**
 * Button styling without harming an image
 * @see <http://www.webdesignerwall.com/tutorials/css3-gradient-buttons/>
 */
.button, button, input[type=submit], input[type=reset] {
  padding: .5em 2em .55em;
  text-shadow: 0 .0625em .0625em rgba(0,0,0,.3);
     -moz-border-radius: .5em;
  -webkit-border-radius: .5em;
          border-radius: .5em;
     -moz-box-shadow: 0 .0625em .125em rgba(0,0,0,.2);
  -webkit-box-shadow: 0 .0625em .125em rgba(0,0,0,.2);
          box-shadow: 0 .0625em .125em rgba(0,0,0,.2);
  font: normal 1em/1.25em "Droid Sans",sans-serif;
  color: #606060;
  border: solid .0625em #b7b7b7;
  background: #fff;
  background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ededed));
  background: -moz-linear-gradient(top,  #fff,  #ededed);
  filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed');
}

.button:hover,
button:hover,
input[type=submit]:hover,
input[type=reset]:hover {
  background: #ededed;
  background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#dcdcdc));
  background: -moz-linear-gradient(top,  #fff,  #dcdcdc);
  filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#dcdcdc');
}

.button:active,
button:active,
input[type=submit]:active,
input[type=reset]:active {
  color: #999;
  background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#fff));
  background: -moz-linear-gradient(top,  #ededed,  #fff);
  filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#ffffff');
}

input[type=text], input[type=password],
input[type=search], input[type=url],
select, textarea {
  padding: 0.084em;
  font: normal 1em/1.25em "Droid Sans",sans-serif;
  border: 0.084em solid #333;
     -moz-border-radius: .125em;
  -webkit-border-radius: .125em;
          border-radius: .125em;
  background-color: white;
  color: #333;
  vertical-align: middle;
}

input[type=image]:hover,
input[type=image]:focus,
input[type=text]:focus,
input[type=password]:focus,
input[type=search]:focus,
input[type=url]:focus,
select:focus,
textarea:focus {
     -moz-box-shadow: 0 0 2px 2px #EFFA8D;
  -webkit-box-shadow: 0 0 2px 2px #EFFA8D;
          box-shadow: 0 0 2px 2px #EFFA8D;
}

mark {
  background: #EFFA8D;
}

abbr[title], dfn[title] {
  cursor: help;
  border-bottom: 1px dotted #b7b7b7;
}

blockquote:before, blockquote:after {
  content: "";
}

dd {
  margin: 0 0 1.25em 1.25em;
}

q:lang(en) {
  quotes: "\201C" "\201D" "\2018" "\2019";
}

q:lang(bar), q:lang(de) {
  quotes: "\201E" "\201C" "\201A" "\2018";
}

q:before {
  content: open-quote;
}

q:after {
  content: close-quote;
}

em, i, var {
  font-style: italic;
}

strong, b {
  font-weight: bold;
}

sub, sup {
  font-size: 0.84em;
  /** This is needed, so that these two don't destroy the carefully
   * arranged line height of surrounding elements. See
   * <http://www.velvetblues.com/web-development-blog/superscripts-subscripts-uneven-line-height/>
   */
  line-height: 0;
}

sub {
  vertical-align: sub;
}

sup {
  vertical-align: super;
}

ins {
  text-decoration: underline;
}

del {
  text-decoration: line-through;
}


/**
 * L A Y O U T ============================================================= *
 */

#body {
  max-width: 60em;
  margin: 0 auto;
}

#content {
  width: 41.5em;
  padding: 1.25em 1.25em 1.25em 0;
  float: left;
  margin: 0 0 1.25em;
}

aside {
  float: right;
  width: 16em;
  margin: 4.65em 0 1.25em;
  padding-left: 1.1875em;
  border-color: #ddd;
  border-style: solid;
  border-width: 0 0 0 .0625em;
}

@media (max-width:61em) {
  #content, aside { float: none; }
  #content {
    width: auto;
    margin: 0;
    padding: 1.25em;
  }
  aside {
    width: auto;
    margin: 0 0 1.25em 0;
    border-width: .0625em 0 0 0;
    padding: 1.1875em 1em 0;
  }
}

@media (max-width:41em) {
  #content {
    width: auto;
  }
}

p {
  text-align: justify;
}

em em {
  font-style: normal;
}

pre, code, kbd, samp {
  font: 100%/1.25em "Droid Sans Mono","DejaVu SansMono",Inconsolata,Courier,monospace;
}

pre {
  color: #ddd;
  background: #49483e;
  background: #49483e -moz-linear-gradient(top, #2F2E26, #49483e 5em);
  background: #49483e -webkit-gradient(linear, left top, left bottom, from(#2F2E26), to(#49483e)) repeat-x;
  -webkit-background-size: 5em;
  font-size: .75em;
  line-height: 1.25em;
  padding: 1.25em 0 1.25em 2.5em;
  overflow: auto;
     -moz-border-radius: .1875em;
  -webkit-border-radius: .1875em;
          border-radius: .1875em;
}

code, var {
  background: #eee;
}

code {
  white-space: pre;
  white-space: pre-wrap;
}

.highlight code {
  background: none;
}

ul + ul, ol + ul, dl + ul, p + ul,
ul + ol, ol + ol, dl + ol, p + ol,
ul + dl, ol + dl, dl + dl, p + dl,
ul + p , ol + p , dl + p {
  margin-top: 1.25em;
}

ol ul, ol ol, ol dl, ul ul, ul ol, ul dl, dl ul, dl ol, dl dl {
  margin-left: 1.25em;
}

pre,
table,
blockquote {
  margin: 1.25em 0;
}

a {
  color: #a10;
  text-decoration: none;
  xborder-bottom: .0625em solid #FF604F;
}

a:visited {
  border-bottom-color: #9B9B9B;
}

a:hover, a:focus {
  color: #F00;
  border-color: #F00;
}

a:active {
  background: #A10;
  color: white;
}

hr {
  border-color: #ddd;
  border-style: solid;
  border-width: .0625em 0 0;
  margin: .625em 0;
  height: 0;
}

cite.ref:before {
  content: "[";
  color: #666;
}

cite.ref:after {
  content: "]";
  color: #666;
}

abbr.cap {
  text-transform: lowercase;
  font-variant: small-caps;
  letter-spacing: .1em;
  font-size: 1.1em;
  line-height: 1.1363;
}

header, footer {
  font-size: .75em;
  font-family: "Droid Sans","DejaVu Sans",sans-serif;
  line-height: 1.6667em;
}

::selection {
  color: #fff;
  background: #F07746;
  text-shadow: none;
}

::-moz-selection {
  color: #fff;
  background: #F07746;
  text-shadow: none;
}


/**
 * H E A D E R ============================================================= *
 */

header {
  border-bottom: .08333em solid #ddd;
  margin: 0 auto 3.25em;
     -moz-box-shadow: 0 .41667em 1.25em rgba(0,0,0,.05);
  -webkit-box-shadow: 0 .41667em 1.25em rgba(0,0,0,.05);
          box-shadow: 0 .41667em 1.25em rgba(0,0,0,.05);
}

nav ul {
  overflow: auto;
}

nav li {
  list-style: none;
  float: left;
  padding: .41667em;
}

nav li:after {
  content: ",";
  color: #ddd;
}

nav li:last-child:after {
  content: none;
}

nav a {
  padding: .41667em;
}

nav a:hover {
  border: .08333em solid #ddd;
     -moz-border-radius: .5em;
  -webkit-border-radius: .5em;
          border-radius: .5em;
  padding: .33333em;
}

nav li ul {
  display: none;
  position: absolute;
  background: white;
  border: .08333em solid #ddd;
  margin: .16667em 0 0;
}

nav li:hover ul {
  display: block;
}

#lang_chooser {
  float: right;
  margin: -2.5em 0 0;
}


/**
 * F O O T E R ============================================================= *
 */

footer {
  clear: both;
  color: #ddd;
  background: #49483e url(footer.png) repeat;
  border-top: .08333em solid black;
     -moz-box-shadow: inset 0 .9375em 1.875em -.9375em #000;
  -webkit-box-shadow: inset 0 .9375em 1.875em -.9375em #000;
          box-shadow: inset 0 .9375em 1.875em -.9375em #000;
  padding: 1.3333em 0;
}

.footer-common {
  margin: 0 auto .8333em;
  width: 61.8%;
}

.footer-common p {
  text-align: center;
}

.footer-details {
  display: table;
  table-layout: fixed;
  width: 100%;
}

footer section {
  padding: 1.3333em;
  display: table-cell;
  border-color: #737262;
  border-style: solid;
  border-width: 0 0 0 .08333em;
}

footer section:first-child {
  border-width: 0;
}

#about_web {
  text-align: right;
}

footer ul,
footer ol {
  padding-left: 0;
}

footer li {
  padding: .8333em;
  border-color: #5B5A4D;
  border-style: solid;
  border-width: 0 0 .08333em;
  list-style: none;
}

footer li:last-child {
  border-bottom-width: 0;
}

footer a {
  color: #ff6050;
}

footer a:hover, footer a:focus {
  color: #ff1000;
}

footer hr {
  border-color: #737262;
}

@media (max-width: 769px) {
  footer,
  footer section {
    display: block;
  }
  footer section {
    border-width: .08333em 0 0;
  }
}


/**
 * S I D E B A R =========================================================== *
 */

aside form + div,
aside div + div {
  margin: 1.6667em 0 0;
}

aside ul li {
  list-style: none;
  margin-bottom: .3125em;
}

aside ul li:before {
  content: "— ";
  color: #ddd;
  margin-left:-1.1875em;
}


/**
 * F I G U R E S =========================================================== *
 */

figure {
  float: left;
  max-width: 40em;
  margin: 0 .75em .75em 0;
}

figure.alt {
  float: right;
  margin: 0 0 .75em .75em;
}

figure.full {
  float: none;
  margin: 1.25em auto;
  width: auto;
}

caption,
figcaption {
  font-size: .75em;
  line-height: 1.6667;
  font-style: italic;
  caption-side: bottom;
}

caption em,
figcaption em {
  font-style: normal;
}

figure img {
  display: block;
}

figure.full img {
  margin: 0 auto;
}


/**
* K E Y S . c s s ========================================================== *
*
* A simple stylesheet for rendering beautiful keyboard-style elements.
*
* Author: Michael Hüneburg
* Website: http://michaelhue.com/keyscss
* License: MIT License (see LICENSE.txt)
*/

/* Base style, essential for every key. */
kbd, .key {
  display: inline;
  display: inline-block;
  min-width: 1em;
  padding: .2em .3em;
  font: normal .85em/1 "Lucida Grande", Lucida, Arial, sans-serif;
  text-align: center;
  text-decoration: none;
     -moz-border-radius: .3em;
  -webkit-border-radius: .3em;
          border-radius: .3em;
  border: none;
  cursor: default;
     -moz-user-select: none;
  -webkit-user-select: none;
          user-select: none;
  background: rgb(250, 250, 250);
  background: -moz-linear-gradient(top, rgb(210, 210, 210), rgb(255, 255, 255));
  background: -webkit-gradient(linear, left top, left bottom, from(rgb(210, 210, 210)), to(rgb(255, 255, 255)));
  color: rgb(50, 50, 50);
  text-shadow: 0 0 2px rgb(255, 255, 255);
     -moz-box-shadow: inset 0 0 1px rgb(255, 255, 255), inset 0 0 .4em rgb(200, 200, 200), 0 .1em 0 rgb(130, 130, 130), 0 .11em 0 rgba(0, 0, 0, .4), 0 .1em .11em rgba(0, 0, 0, .9);
  -webkit-box-shadow: inset 0 0 1px rgb(255, 255, 255), inset 0 0 .4em rgb(200, 200, 200), 0 .1em 0 rgb(130, 130, 130), 0 .11em 0 rgba(0, 0, 0, .4), 0 .1em .11em rgba(0, 0, 0, .9);
          box-shadow: inset 0 0 1px rgb(255, 255, 255), inset 0 0 .4em rgb(200, 200, 200), 0 .1em 0 rgb(130, 130, 130), 0 .11em 0 rgba(0, 0, 0, .4), 0 .1em .11em rgba(0, 0, 0, .9);
}
kbd[title], .key[title] {
  cursor: help;
}


/**
 * T A G   C L O U D ======================================================= *
 */

.tagcloud a {
  border: none;
}
.tc_1 {
  font-family: "Droid Sans","DejaVu Sans",sans-serif;
  font-size: .75em;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)";
  filter: alpha(opacity=60);
  opacity: .6;
}
.tc_2 {
  font-size: .90em;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
  filter: alpha(opacity=80);
  opacity: .8;
}
.tc_3 { font-size: 1.0em; }
.tc_4 { font-size: 1.2em; }
.tc_5 { font-size: 1.5em; }


/**
 * A R T I C L E   C O N T E N T =========================================== *
 */

article img {
  max-width: 100%;
}

article section {
  margin: 0 0 1.25em;
}

article caption {
  border-top: .08333em solid #777;
  padding: .8333em 0 0 .8333em;
}

article th,
article td {
  padding: .625em;
}

article th {
  font-weight: bold;
  letter-spacing: .02em;
}

article thead {
  border-bottom: .0625em solid #777;
}

blockquote {
  font-size: .75em;
  line-height: 1.6667;
  padding: 0 1.6667em;
}

blockquote .src {
  font-style: italic;
  text-align: right;
}

blockquote .src em {
  font-style: normal;
}

article p + p {
  text-indent: 1.25em;
}

.info {
  color: #737262;
  font-family: "Droid Sans", "DejaVu Sans", sans-serif;
  font-size: .75em;
  line-height: 1.6667em;
  margin: 0 0 1.6667em;
}

.info address,
.info p {
  text-indent: 0;
  display: inline;
  padding: 0 1em 0 0;
}

.info * + address:before,
.info * + p:before {
  content: "\002022";
  padding-right: 1em;
}

address.default-author {
  display: none;
}

.related-links {
  margin: 1.25em 0 0;
  overflow: auto;
}

.related-links p {
  float: left;
  max-width: 49%;
}

.related-links p.is-required-by {
  float: right;
}

.abstract {
  font-style: italic;
}

.article_nav {
  width: 10em;
}

.article_nav a {
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
  filter: alpha(opacity=50);
  opacity: .5;
}

.article_nav a:hover,
.article_nav a:focus,
.article_nav a:active {
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(enabled=false)";
  filter: alpha(enabled=false);
  opacity: 1;
}

.article_prev {
  float: left;
  margin-left: -11em;
  text-align: right;
}

.article_next {
  float: right;
  margin-right: -11em;
}

@media (max-width:61em) {
  .article_nav {
    float: none;
    margin: 0;
    width: auto;
  }
  .article_prev {
    text-align: left;
  }
  .article_next {
    text-align: right;
    margin-top: -1.5em;
  }
}


/**
 * F O O T N O T E S ======================================================= *
 */

body {
  counter-reset: footnote;
}

.fn {
  counter-increment: footnote;
}

.fn-body {
  float: right;
  width: 10em;
  margin-right: -11em;
  color: #737262;
  font-family: "Droid Sans", "DejaVu Sans", sans-serif;
  font-size: .75em;
  line-height: 1.6667em;
  text-indent: 0;
  text-align: left;
}

@media (max-width:53em) {
  .fn-body {
    margin-right: 0;
    margin-left: 1em;
  }
}

.fn-body:before {
  content: counter(footnote) "\00A0";
  font-size: .75em;
  line-height: 0;
  vertical-align: super;
}

.fn:before {
  content: counter(footnote);
  color: #737262;
  line-height: 0;
  vertical-align: super;
  font-family: "Droid Sans", "DejaVu Sans", sans-serif;
  font-size: .75em;
}


/**
 * A R T I C L E   L I S T S =============================================== *
 */

.hfeed {
  list-style: none;
  border-color: #ddd;
  border-style: solid;
  border-width: .0625em 0 0;
  margin-top: .625em;
}

.hfeed li {
  border-color: #ddd;
  border-style: solid;
  border-width: 0 0 .0625em;
  padding: .625em 0;
  background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(rgba(255,255,255,0)));
  background: -moz-linear-gradient(top,  #fff,  rgba(255,255,255,0));
  overflow: auto;
}

.hfeed .author {
  display: none;
}

.hfeed .entry-title {
  display: block;
  text-transform:lowercase;
  font-variant: small-caps;
  letter-spacing: .1em;
}

.hfeed .entry-summary {
  font-size: .75em;
  line-height: 1.6667em;
  overflow: auto;
}

.hfeed time {
  float: left;
  width: 3.8em;
  margin: 0 .5em 0 0;
  padding: 0 .5em 0 0;
  text-align: center;
  color: #BBB;
  border-right: .0625em solid #DDD;
}

.hfeed .date-day {
  display: block;
  font-size: 2.7em;
  line-height: .9em;
}

.hfeed .date-month {
  font-size: .75em;
}


/**
 * F O R M S =============================================================== *
 */

.form p + p,
form p + p {
  text-indent: 0;
  margin-top: 1.25em;
}

.error {
  color: #DD0000;
}

.success {
  color: #00DD00;
}

section.error,
section.success {
  color: #333;
  margin: 0 0 1.25em;
  padding: 1.25em;
     -moz-border-radius: .1875em;
  -webkit-border-radius: .1875em;
          border-radius: .1875em;
}

section.error {
  background: #FFDDDD;
}

section.success {
  background: #DDFFDD;
}

.contact label {
  display: block;
  width: 8em;
  margin: 0 1em 0 0;
  float: left;
}

.contact input[type=text],
.contact textarea {
  max-width: 30em;
}

.contact textarea {
  clear: left;
  max-width: 40em;
  width: 95%;
  height: 5.25em;
}

.honezpot {
  display: none !important;
}

.searchform #q {
  margin-right: 1.5em;
}

@media (min-width:41.6em) {
  .searchform #q {
    width: 30em;
  }
}


/**
 * P A G I N A T I O N ===================================================== *
 */

.paginate {
  text-align: center;
}

.paginate li {
  display: inline;
}

.paginate a,
.paginate span {
  font-size: .75em;
  list-style: none;
  display: inline-block;
  min-width: 1em;
  padding: 0 .3333em;
  line-height: 1.6667em;
  margin: 0 .8333em 0 0;
  text-align: center;
}

.paginate .current span {
  background: #9BFA8D;
}

.paginate .start.current span,
.paginate .end.current span {
  background: transparent;
}

.paginate a:focus,
.paginate a:hover {
  background: #EFFA8D;
}


/**
 * S Y N T A X   H I G H L I G H T I N G =================================== *
 */

.highlight .hll { background-color: #000000; }
.s_c { color: #75715e } /* Comment */
.s_err { color: #960050; background-color: #1e0010 } /* Error */
.s_k { color: #66d9ef } /* Keyword */
.s_l { color: #ae81ff } /* Literal */
.s_n { color: #f8f8f2 } /* Name */
.s_o { color: #f92672 } /* Operator */
.s_p { color: #f8f8f2 } /* Punctuation */
.s_ { color: #f8f8f2 } /* Text */
.s_cm { color: #75715e } /* Comment.Multiline */
.s_cp { color: #75715e } /* Comment.Preproc */
.s_c1 { color: #75715e } /* Comment.Single */
.s_cs { color: #75715e } /* Comment.Special */
.s_ge { font-style: italic } /* Generic.Emph */
.s_gs { font-weight: bold } /* Generic.Strong */
.s_kc { color: #66d9ef } /* Keyword.Constant */
.s_kd { color: #66d9ef } /* Keyword.Declaration */
.s_kn { color: #f92672 } /* Keyword.Namespace */
.s_kp { color: #66d9ef } /* Keyword.Pseudo */
.s_kr { color: #66d9ef } /* Keyword.Reserved */
.s_kt { color: #66d9ef } /* Keyword.Type */
.s_ld { color: #e6db74 } /* Literal.Date */
.s_m { color: #ae81ff } /* Literal.Number */
.s_s { color: #e6db74 } /* Literal.String */
.s_na { color: #a6e22e } /* Name.Attribute */
.s_nb { color: #f8f8f2 } /* Name.Builtin */
.s_nc { color: #a6e22e } /* Name.Class */
.s_no { color: #66d9ef } /* Name.Constant */
.s_nd { color: #a6e22e } /* Name.Decorator */
.s_ni { color: #f8f8f2 } /* Name.Entity */
.s_ne { color: #a6e22e } /* Name.Exception */
.s_nf { color: #a6e22e } /* Name.Function */
.s_nl { color: #f8f8f2 } /* Name.Label */
.s_nn { color: #f8f8f2 } /* Name.Namespace */
.s_nx { color: #a6e22e } /* Name.Other */
.s_py { color: #f8f8f2 } /* Name.Property */
.s_nt { color: #f92672 } /* Name.Tag */
.s_nv { color: #f8f8f2 } /* Name.Variable */
.s_ow { color: #f92672 } /* Operator.Word */
.s_w { color: #f8f8f2 } /* Text.Whitespace */
.s_mf { color: #ae81ff } /* Literal.Number.Float */
.s_mh { color: #ae81ff } /* Literal.Number.Hex */
.s_mi { color: #ae81ff } /* Literal.Number.Integer */
.s_mo { color: #ae81ff } /* Literal.Number.Oct */
.s_sb { color: #e6db74 } /* Literal.String.Backtick */
.s_sc { color: #e6db74 } /* Literal.String.Char */
.s_sd { color: #e6db74 } /* Literal.String.Doc */
.s_s2 { color: #e6db74 } /* Literal.String.Double */
.s_se { color: #ae81ff } /* Literal.String.Escape */
.s_sh { color: #e6db74 } /* Literal.String.Heredoc */
.s_si { color: #e6db74 } /* Literal.String.Interpol */
.s_sx { color: #e6db74 } /* Literal.String.Other */
.s_sr { color: #e6db74 } /* Literal.String.Regex */
.s_s1 { color: #e6db74 } /* Literal.String.Single */
.s_ss { color: #e6db74 } /* Literal.String.Symbol */
.s_bp { color: #f8f8f2 } /* Name.Builtin.Pseudo */
.s_vc { color: #f8f8f2 } /* Name.Variable.Class */
.s_vg { color: #f8f8f2 } /* Name.Variable.Global */
.s_vi { color: #f8f8f2 } /* Name.Variable.Instance */
.s_il { color: #ae81ff } /* Literal.Number.Integer.Long */
.highlight {
  counter-reset: code;
  padding-left:2.5em
}
.highlight .line {
  display: block;
  counter-increment: code;
}
.highlight .line:before {
  content: counter(code);
  float: left;
  margin-left: -2.5em;
  width: 2em;
  text-align: right;
  color: #75715E;
}


/**
 * G e n e r a t e d   C o n t e n t ======================================= *
 */

.__toc {
  float: left;
  width: 10em;
  margin-left: -11em;
  margin-top: 3.4em;
}
.__toc h2 {
  margin-bottom: 0;
}
.__toc ol {
  font-size: .75em;
}

@media (max-width: 82em) {
  .__toc {
    float: none;
    margin: 0 0 .625em;
    width: 100%;
  }
  .__toc li {
    display: inline;
  }
  .__toc li:after {
    content: " \00A0/\00A0 ";
    color: #737262;
  }
  .__toc li:last-child:after {
    content: none;
  }
}



.__archives_tables table {
  width: 100%;
  table-layout: fixed;
  margin: 0;
  display: none;
}

.__archives_tables table.current {
  display: table;
}

.__archives_tables th,
.__archives_tables td {
  padding: .41666em;
  text-align: center;
}

.__archives_tables th {
  font-weight: bold;
  letter-spacing: .333em;
  border-bottom: .08333em solid #777;
}

.__archives_tables a {
  display: block;
}

.__archives_tables span {
  color: #737262;
}


/**
 * P R I N T =============================================================== *
 */

@media print {
  html, body {
    background: transparent;
    overflow: visible;
  }

  header, aside, footer,
  .article_nav,
  #dsq-new-post {
    display: none;
  }

  address.default-author {
    display: inline;
  }

  article, section, #content {
    float: none;
  }
}


/**
 * R E A D A B L E   O P T I M I Z E D ===================================== *
 */

.__reading #global {
  display: none;
}

.__readable {
  background: #3C3B37;
}

.__rcontent {
  min-height: 96%;
  width: 57.8%;
  padding: 2%;
  min-width: 35em;
  margin: 0 auto;
  background: white;
}

.__rclose {
  position: fixed;
  top: 1em;
  right: 1em;
  background: white;
  color: #49483e;
  display: block;
  width: 2em;
  height: 2em;
  border-radius: 2em;
  text-align: center;
  font: bold 1em/2em sans-serif;
}

@media (max-width: 40em) {
  .__rcontent {
    min-width: 0;
    width: auto;
    padding: 1em .5em;
  }
  .__rclose {
    top: 0;
    right: 0;
    font-size: .75em;
    border-radius: 0 0 0 2em;
  }
}

@media print {
  .__reading #global {
    display: block;
  }
  .__readable {
    display: none;
  }
}

STYLEDOC
);
echo '<pre>';
$now = microtime(true);
$parser = new CSSParser($lexer);
while($lexer->yylex()) {
    //if ($lexer->token !== "S") {
    //    echo "[" . $lexer->token . "]\t\t" . $lexer->value. "\n";
    //}
    $parser->doParse($lexer->token, $lexer->value);
}
$parser->doParse(0, 0);
echo microtime(true) - $now;
echo "\n";
//var_dump($parser->retvalue);
