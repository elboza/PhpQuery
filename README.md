# phpquery

## jquery for php

This is a simple wrapper over the xpath library that lets you make queries on an html page with the more friendly syntax of _jquery_.

you can use it also to make queries with the _xpath_ syntax

### public functions

```
load_str($html_string);
query($query_string,$relative_path); // returns DOMNodeList or DOMElement
xpath($query_string,$relative_path); // returns DOMNodeList or DOMElement
j_to_x($query_string);
innerHTML(DOMElement); // returns string
outerHTML(DOMElement); //return string
```

where `$relative_path` is optional and represent a saved query performed earlier.

### usage 
```
<?php 

require_once __DIR__ . '/../vendor/autoload.php';
use PhpQuery\PhpQuery

$page=file_get_contents('sample.html');
$pq=new PhpQuery;
$pq->load_str($page);

$pq->query(...);


```
### example

`sample.html` file

```
<!DOCTYPE html>
<html>
<head>
<title>sample html</title>
</head>
<body>
<p id="myid">Hello</p>
<div class="c1"> hello again</div>
<div class="c2"> hi</div>
<div class="c1 c2 c3">hi hi</div>
<div class="dav-k">foo</div>
<div class="Opin"><p>bar</p></div>
<ul>
<li> one</li>
<li> two</li>
<li> three</li>
</ul>
</body>
</html>
```
phpquery test:
```
<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PhpQuery\PhpQuery;

echo "hi<br>";
$page=file_get_contents('sample.html');
$pq=new PhpQuery;
$pq->load_str($page);

echo "<br><br>";
//return a list of 2 components
var_dump($pq->query('.c1'));

echo "<br><br>";
//return the first element
var_dump($pq->query('.c1')[0]);

echo "<br><br>";
//return a list of 1 element
var_dump($pq->query('.c1.c3'));

echo "<br><br>";
//return the first element
var_dump($pq->query('.c1.c3')[0]);

echo "<br><br>";
//return a ist of 3 elements element
var_dump($pq->query('ul li'));

echo "<br><br>";
//return a ist of 1 elements element
var_dump($pq->query('ul'));

echo "<br><br>";
//return a ist of 3 elements element
//relative call
//first lookup for ul
//and the from that ul seeks li
$x=$pq->query('ul');
var_dump($x=$pq->query('li',$x[0]));

echo "<br><br>";
//return a ist of 1 elements element
var_dump($pq->query('#myid'));

echo "<br><br>";
//return the first element
var_dump($pq->query('#myid')[0]);
echo "<br>~~textContent ~~> ";
var_dump($pq->query('#myid')[0]->textContent);

echo "<br><br>";
//print the transormation fron jquery syntax
//to xpath syntax
echo $pq->j_to_x('.c1.c3');
echo $pq->j_to_x('#myid');

echo "<br><br>";
//return a list of 1 element
//from xpath syntax
var_dump($pq->xpath('//*[@id="myid"]'));

echo "<br><br>";
//return the first element
//from xpath syntax
var_dump($pq->xpath('//*[@id="myid"]')[0]);

echo '<br><br>';
var_dump($pq->innerHTML($pq->query('.Opin')[0]));

echo '<br><br>';
var_dump($pq->outerHTML($pq->query('.dav-k')[0]));

?>
```

the output:

```
hi


object(DOMNodeList)#6 (1) { ["length"]=> int(2) } 

object(DOMElement)#6 (18) { ["tagName"]=> string(3) "div" ["schemaTypeInfo"]=> NULL ["nodeName"]=> string(3) "div" ["nodeValue"]=> string(12) " hello again" ["nodeType"]=> int(1) ["parentNode"]=> string(22) "(object value omitted)" ["childNodes"]=> string(22) "(object value omitted)" ["firstChild"]=> string(22) "(object value omitted)" ["lastChild"]=> string(22) "(object value omitted)" ["previousSibling"]=> string(22) "(object value omitted)" ["nextSibling"]=> string(22) "(object value omitted)" ["attributes"]=> string(22) "(object value omitted)" ["ownerDocument"]=> string(22) "(object value omitted)" ["namespaceURI"]=> NULL ["prefix"]=> string(0) "" ["localName"]=> string(3) "div" ["baseURI"]=> NULL ["textContent"]=> string(12) " hello again" } 

object(DOMNodeList)#4 (1) { ["length"]=> int(1) } 

object(DOMElement)#4 (18) { ["tagName"]=> string(3) "div" ["schemaTypeInfo"]=> NULL ["nodeName"]=> string(3) "div" ["nodeValue"]=> string(4) "hi" ["nodeType"]=> int(1) ["parentNode"]=> string(22) "(object value omitted)" ["childNodes"]=> string(22) "(object value omitted)" ["firstChild"]=> string(22) "(object value omitted)" ["lastChild"]=> string(22) "(object value omitted)" ["previousSibling"]=> string(22) "(object value omitted)" ["nextSibling"]=> string(22) "(object value omitted)" ["attributes"]=> string(22) "(object value omitted)" ["ownerDocument"]=> string(22) "(object value omitted)" ["namespaceURI"]=> NULL ["prefix"]=> string(0) "" ["localName"]=> string(3) "div" ["baseURI"]=> NULL ["textContent"]=> string(4) "hi" } 

object(DOMNodeList)#7 (1) { ["length"]=> int(3) } 

object(DOMNodeList)#5 (1) { ["length"]=> int(1) } 

object(DOMNodeList)#9 (1) { ["length"]=> int(3) } 

object(DOMNodeList)#5 (1) { ["length"]=> int(1) } 

object(DOMElement)#5 (18) { ["tagName"]=> string(1) "p" ["schemaTypeInfo"]=> NULL ["nodeName"]=> string(1) "p" ["nodeValue"]=> string(5) "Hello" ["nodeType"]=> int(1) ["parentNode"]=> string(22) "(object value omitted)" ["childNodes"]=> string(22) "(object value omitted)" ["firstChild"]=> string(22) "(object value omitted)" ["lastChild"]=> string(22) "(object value omitted)" ["previousSibling"]=> string(22) "(object value omitted)" ["nextSibling"]=> string(22) "(object value omitted)" ["attributes"]=> string(22) "(object value omitted)" ["ownerDocument"]=> string(22) "(object value omitted)" ["namespaceURI"]=> NULL ["prefix"]=> string(0) "" ["localName"]=> string(1) "p" ["baseURI"]=> NULL ["textContent"]=> string(5) "Hello" } 
~~textContent ~~> string(5) "Hello" 

//*[contains(@class,"c1") and contains(@class,"c3")]//*[@id="myid"]

object(DOMNodeList)#7 (1) { ["length"]=> int(1) } 

object(DOMElement)#7 (18) { ["tagName"]=> string(1) "p" ["schemaTypeInfo"]=> NULL ["nodeName"]=> string(1) "p" ["nodeValue"]=> string(5) "Hello" ["nodeType"]=> int(1) ["parentNode"]=> string(22) "(object value omitted)" ["childNodes"]=> string(22) "(object value omitted)" ["firstChild"]=> string(22) "(object value omitted)" ["lastChild"]=> string(22) "(object value omitted)" ["previousSibling"]=> string(22) "(object value omitted)" ["nextSibling"]=> string(22) "(object value omitted)" ["attributes"]=> string(22) "(object value omitted)" ["ownerDocument"]=> string(22) "(object value omitted)" ["namespaceURI"]=> NULL ["prefix"]=> string(0) "" ["localName"]=> string(1) "p" ["baseURI"]=> NULL ["textContent"]=> string(5) "Hello" }

string(10) "<p>bar</p>"

string(28) "<div class="dav-k">foo</div>"
```

