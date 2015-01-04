<?hh

class Object{
  // public string $type; // int or string
  // public string $name; // string
  public array<string> $properties = array(); // Array of strings
  public array<Object> $Lists = array(); // Array of Objects

  public function save() : array{
    return array();
  }
}
