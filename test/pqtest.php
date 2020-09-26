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