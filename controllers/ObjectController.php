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

      foreach($this->_params['criteria'] as $key => $val){
        if($key == '_id'){
          $this->_params['criteria'][$key] = $this->idToMongoId($val);
        }
      }

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

  public function removeAction():bool{
    $collection = EPSI\MongoConnector::getMongoCollection();

    if(!isset($this->_params['criteria'])) throw new Exception("Cannot remove Object: Criteria not found.");

    foreach($this->_params['criteria'] as $key => $val){
      if($key == '_id'){
        $this->_params['criteria'][$key] = $this->idToMongoId($val);
      }
    }

    return (bool)$collection->remove($this->_params['criteria']);
  }

  public function updateAction():bool{
    $collection = EPSI\MongoConnector::getMongoCollection();

    if(!isset($this->_params['criteria'])) throw new Exception("Cannot update Object: Criteria not found.");
    if(!isset($this->_params['properties'])) throw new Exception("Cannot update Object: Properties not found.");
    if(!isset($this->_params['options']['multiple'])) throw new Exception("Cannot update Object: Update multiple objects?{['options']['multiple']}");

    foreach($this->_params['criteria'] as $key => $val){
      if($key == '_id'){
        $this->_params['criteria'][$key] = $this->idToMongoId($val);
      }
    }

    return (bool)$collection->update($this->_params['criteria'],['$set'=>$this->_params['properties']],$this->_params['options']);
  }

  private function idToMongoId(string $_id):MongoId{
    return new MongoId($_id);
  }

  public function exists(string $name, string $type):bool{
    // global $_mongoCollection;
    return true;
  }
}
