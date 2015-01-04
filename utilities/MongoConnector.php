<?hh

namespace EPSI;

class MongoConnector{
  private static string $url = 'mongodb://test:test@dogen.mongohq.com:10080/epsclubs';
  private static string $db = 'epsclubs';
  private static string $collection = 'cartoons';

  public static function getMongoClient():\MongoClient{
    return new \MongoClient(self::$url);
  }
  public static function getMongoDB():\MongoDB{
    $client = self::getMongoClient();
    $dbName = self::$db;
    return $client->$dbName;
  }
  public static function getMongoCollection():\MongoCollection{
    $db = self::getMongoDB();
    $collectionName = self::$collection;
    return $db->$collection;
  }
}
