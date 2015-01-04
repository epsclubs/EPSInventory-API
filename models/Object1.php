<?hh

class Object1{
  public string $_id; // eg. "54a36e477cc2bfaa030041a8"
  public string $parent; // eg. "54a36e477cc2bfaa030041a7"
  public string $type; // eg. "Subject"
  public array<string> $properties; // Array of strings

  public function __save() : array{

    return $this->__toArray();
  }

  public function __toArray():array{
    return array();
  }
}
