<?php
require('vendor/autoload.php');

new EPSI\MongoConnector();

$applications = array(
  'APP001' => '28e336ac6c9423d946ba02d19c6a2632', //randomly generated app key
);

include_once 'models/Object.php';

try {

  $params = $_REQUEST;
  $params = (array) $params;

  $controller = ucfirst(strtolower($params['controller']));
  $action = strtolower($params['action']).'Action';

  if( file_exists("controllers/{$controller}.php") ) {
    include_once "controllers/{$controller}.php";
  } else {
    throw new Exception('Controller is invalid.');
  }

  $controller = new $controller($params);

  if( method_exists($controller, $action) === false ) {
    throw new Exception('Action is invalid.');
  }

  $result['data'] = $controller->$action();
  $result['success'] = true;

}catch(Exception $e){
  $result = array();
  $result['success'] = false;
  $result['errormsg'] = $e->getMessage();
}

echo json_encode($result);
exit();





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
