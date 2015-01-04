<?hh
phpinfo();
echo "a";

require('vendor/autoload.php');
echo '<pre>';
// $m = new MongoClient('mongodb://test:test@dogen.mongohq.com:10080/epsclubs');
// $m = EPSI\MongoConnector::getMongoClient();
// $db = $m->epsclubs;
// $db = EPSI\MongoConnector::getMongoDB();
// $collection = $db->cartoons;
// $collection = EPSI\MongoConnector::getMongoCollection();
// var_dump($collection);
// // var_dump(EPSI\MongoConnector::getMongoCursor());
// $cursor = $collection->find();
$cursor = EPSI\MongoConnector::getMongoCursor();
//
foreach ($cursor as $document) {
  var_dump($document);
}
