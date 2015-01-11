<?hh

namespace EPSI;

class MongoConnector{
  private static string $url = 'mongodb://test:test@dogen.mongohq.com:10080/epsclubs';
  private static string $db = 'epsclubs';
  private static string $default_collection = 'eps-inv';

  public static function getMongoClient():\MongoClient{
    return new \MongoClient(self::$url);
  }
  public static function getMongoDB():\MongoDB{
    $client = self::getMongoClient();
    $dbName = self::$db;
    return $client->$dbName;
  }
  public static function getMongoCollection(?string $collection):\MongoCollection{
    if(!$collection){
      $collection == self::$default_collection;
    }
    $db = self::getMongoDB();
    $collectionName = $collection;
    return $db->$collectionName;
  }

  // note: deprecated
  public static function getMongoCursor():\MongoCursor{
    $collection = self::getMongoCollection(null);
    return $collection->find();
  }
}
