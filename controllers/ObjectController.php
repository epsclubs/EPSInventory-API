<?hh

class ObjectController{
  private array $_params = array();

  public function __construct(array $params):void{
    $this->_params = $params;
  }

  public function createAction():array{
    if(!isset($this->_params['parent']) ||
      !isset($this->_params['type']) ||
      !isset($this->_params['properties']))
      {throw new Exception("Cannot Create Object: Parameter incomplete.");}

    $obj = new Object(null,$this->_params['parent'],$this->_params['type'],$this->_params['properties']);
    return $obj->__save();
  }

  public function readAction():?array{
    $collection = EPSI\MongoConnector::getMongoCollection();
    if(isset($this->_params['criteria']))
    {
      $cursor = $collection->find($this->_params['criteria']);
    }else{
      $cursor = $collection->find();
    }

    if($cursor->count() == 0){return null;}

    $objects = array();
    foreach($cursor as $document)
    {
      $children = array();
      if(isset($this->_params['options']['tree']) && $this->_params['options']['tree'] == true)
      {
        $controller = new ObjectController([
          'options' => ['tree'=>true],
          'criteria'=>['parent'=>$document['_id']->__toString()]
        ]);

        $children = $controller->readAction();
      }

      $object = new Object($document['_id']->__toString(),$document['parent'],$document['type'],$document['properties']);
      $objectAsArray = $object->__toArray();
      $objectAsArray['children'] = $children;
      $objects[] = $objectAsArray;
    }

    return $objects;
  }

  public function exists(string $name, string $type):bool{
    // global $_mongoCollection;
    return true;
  }
}
