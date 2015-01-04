<?hh

class Object{
  public string $_id; // eg. "54a36e477cc2bfaa030041a8"
  public string $parent; // eg. "54a36e477cc2bfaa030041a7"
  public string $type; // eg. "Subject"
  public array $properties; // Array of strings

  public function __construct(
    string $_id;
    string $parent;
    string $type;
    array $properties;
  ){
    $this->_id = $_id;
    $this->parent = $parent;
    $this->type = $type;
    $this->properties = $properties;
  }

  public function __save():array{
    global $_mongoCollection;
    return $_mongoCollection->insert($this->__toArray());
  }

  public function __toArray():array{
    return array();
  }
}
