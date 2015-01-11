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

    $usr = new User(null,$this->_params['_id'],$this->_params['pass']);
    return $usr->__save();
  }

  public function authenticateAction():bool{
    $collection = EPSI\MongoConnector::getMongoCollection('eps-inv-users');
    if(!(isset($this->_params['_id']) && isset($this->_params['pass'])))
      {throw new Exception("Cannot authenticate User: Criteria not found.");}

    $cursor = $collection->find(['_id'=>$this->_params['_id'],
                                  'pass'=>$this->_params['pass']]);
    if($cursor->count() >= 0){return true;}
    else{return false;}
  }

  public function changepassAction():array{
    return [];
  }
}
