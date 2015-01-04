<?php
require('vendor/autoload.php');
$m = new MongoClient('mongodb://test:test@dogen.mongohq.com:10080/epsclubs');
// echo '<pre>';
// phpinfo();

// echo 'test 3';

$db = $m->epsclubs;

// select a collection (analogous to a relational database's table)
$collection = $db->cartoons;

// add a record
$document = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
$collection->insert($document);

// add another record, with a different "shape"
$document = array( "title" => "XKCD", "online" => true );
$collection->insert($document);

// find everything in the collection
$cursor = $collection->find();

// iterate through the results
foreach ($cursor as $document) {
  echo $document["title"] . "\n";
}
