<?hh

class Object{
  public ?string $_id; // eg. "54a36e477cc2bfaa030041a8"
  public string $parent; // eg. "54a36e477cc2bfaa030041a7"
  public string $type; // eg. "Subject"
  public array $properties; // Array of strings

  public function __construct(
    ?string $_id,
    string $parent,
    string $type,
    ?array $properties
  ){
    if(!$properties) $properties = array();
    $this->_id = $_id;
    $this->parent = $parent;
    $this->type = $type;
    $this->properties = $properties;
  }

  public function __save():array{
    $document = [
      'parent' => $this->parent,
      'type' => $this->type,
      'properties' => $this->properties
    ];
    $key = [
      'type'=>$this->type,
      'parent'=>$this->parent,
      'properties'=>['name'=>$this->properties['name']]
    ];
    $_mongoCollection = EPSI\MongoConnector::getMongoCollection('eps-inv');
    return $_mongoCollection->update($key,$document,['upsert'=>true]);
    // return $_mongoCollection->insert($document);
  }

  public function __toArray():array{
    return array(
      '_id' => $this->_id,
      'parent' => $this->parent,
      'type' => $this->type,
      'properties' => $this->properties
    );
  }
}
