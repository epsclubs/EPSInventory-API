<?hh
phpinfo();
echo "a";

require('vendor/autoload.php');
echo '<pre>';
$m = new MongoClient('mongodb://test:test@dogen.mongohq.com:10080/epsclubs');
$db = $m->epsclubs;
$collection = $db->cartoons;
// var_dump($collection);
var_dump(EPSI\MongoConnector::getMongoCollection());
