<?hh

class ObjectController{
  private array<string> $_params = array();

  public function __construct(array<string> $params):void{
    $this->_params = $params;
  }

  public function createAction():array{
    return array();
  }

  public function exists(string $name, string $type):bool{
    global $_mongoCollection;
    return true;
  }
}
