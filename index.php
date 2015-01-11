<?php
// Error Handling
// require 'utilities/ErrorHandler.php';
// set_error_handler(error_handler);

require('vendor/autoload.php');

$applications = array(
  'APP001' => '28e336ac6c9423d946ba02d19c6a2632' //randomly generated app key
);

include_once 'models/Object.php';

try {

  $params = json_decode($_REQUEST['req'],true);
  // Create Sample
  // $params = [
  //   'controller'=>'object',
  //   'action'=>'create',
  //   'type'=>'Subject',
  //   'parent'=>'none',
  //   'properties'=>array('name'=>'Chemistry')
  // ];
  // $params = [
  //   'controller'=>'object',
  //   'action'=>'create',
  //   'type'=>'List',
  //   'parent'=>'54a9b949a528fae772d94d05',
  //   'properties'=>array('name'=>'Chemicals')
  // ];
  // $params = [
  //   'controller'=>'object',
  //   'action'=>'create',
  //   'type'=>'Chemical',
  //   'parent'=>'54a9c4eca528fae772d94d06',
  //   'properties'=>array('name'=>'Benzene')
  // ];
  // Read Sample
  // $params = ['controller'=>'object','action'=>'read','criteria'=>['_id'=>'54aac226a528fae772d94d0a'],'options'=>['tree'=>true]];
  // Remove Sample
  // $params = ['controller'=>'object','action'=>'remove','criteria'=>['_id'=>'54a9c615a528fae772d94d07'],'options'=>['tree'=>true]];
  // Update Sample
  // $params = [
  //   'controller'=>'object',
  //   'action'=>'update',
  //   'criteria'=>['_id'=>'54a9ccf8a528fae772d94d08'],
  //   'properties'=>['properties.name'=>'Benzene','properties.quantity'=>'90000'],
  //   'options'=>['multiple'=>true,'upsert'=>true]
  // ];
  // Unset Sample
  // $params = [
  //   'controller'=>'object',
  //   'action'=>'unset',
  //   'criteria'=>['_id'=>'54a9ccf8a528fae772d94d08'],
  //   'properties'=>['properties.quantity'=>'9000'],
  //   'options'=>['multiple'=>true]
  // ];
  $params = (array) $params;

  $controller = ucfirst(strtolower($params['controller'])).'Controller';
  $action = strtolower($params['action']).'Action';

  if( file_exists("controllers/{$controller}.php") ) {
    // $_mongoCollection = EPSI\MongoConnector::getMongoCollection('eps-inv');
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
// echo '<pre>';
echo json_encode($result);
// var_dump($result);
exit();
