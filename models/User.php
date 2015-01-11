<?hh

// A (very) simple User Class
class User{
  public int $_id; // 0 = Admin, 1 = Guest
  public string $pass;

  public function __construct(
  int $_id,
  string $pass
  ){
    $this->_id = $_id;
    $this->pass = $pass;
  }

  public function __save():array{
    $document = [
      '_id' => $this->_id,
      'pass' => $this->pass
    ];
    $_mongoCollection = EPSI\MongoConnector::getMongoCollection('eps-inv-users');
    return $_mongoCollection->insert($document);
    // return $_mongoCollection->insert($document);
  }
}
