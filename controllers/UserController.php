<?hh

class UserController{
  private array $_params;

  public function __construct(array $params):void{
    $this->_params = $params;
  }

  public function createAction():array{
    if(!isset($this->_params['_id']) ||
    !isset($this->_params['pass']))
    {throw new Exception("Cannot Create User: Parameter incomplete.");}

    $usr = new User((int)$this->_params['_id'],$this->_params['pass']);
    return $usr->__save();
  }

  public function authenticateAction():bool{
    $collection = EPSI\MongoConnector::getMongoCollection('eps-inv-users');
    if(!(isset($this->_params['_id']) && isset($this->_params['pass'])))
      {throw new Exception("Cannot authenticate User: Criteria not found.");}

    $cursor = $collection->find(['_id'=>(int)$this->_params['_id'],
                                  'pass'=>$this->_params['pass']]);
    if($cursor->count() > 0){return true;}
    else{return false;}
  }

  public function readAction():?array{
    $collection = EPSI\MongoConnector::getMongoCollection('eps-inv-users');
    if(isset($this->_params['_id']))
    {
      $cursor = $collection->find($this->_params['_id']);
    }else{
      $cursor = $collection->find();
    }

    if($cursor->count() == 0){return null;}

    $users = array();
    foreach($cursor as $user){
      $users[] = $user;
    }
    return $users;
  }

  public function removeAction():bool{
    $collection = EPSI\MongoConnector::getMongoCollection('eps-inv-users');

    if(!isset($this->_params['_id'])) throw new Exception("Cannot remove User: _id not found.");

    return (bool)$collection->remove($this->_params['_id']);
  }

  public function changepassAction():array{
    if(!isset($this->_params['_id']) ||
    !isset($this->_params['pass']))
    {throw new Exception("Cannot Changepass: Parameter incomplete.");}

    try{
      if($this->removeAction()){
        return $this->createAction();
      }
    }catch(Exception $e){
      if($e->getMessage == 'Cannot remove User: _id not found.'){
        throw new Exception("Cannot ChangePass: _id not found.");
      }
    }
    throw new Exception("Cannot Changepass: and Unknown error had occured");
  }
}
