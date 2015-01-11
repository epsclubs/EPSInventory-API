EPSInventory-API
================
Application Programming Interface for the EPS Inventory Project.

##Overview
Two data models are used for this API, `User` and `Object`.

####Object
Properties: `$_id`, `$parent`, `$type`, `$properties`
* $_id: a 24-character string generated by MongoDB. (ex. `54a36e477cc2bfaa030041a8`)
* $parent: ID of parent Object.
* $type: Object Type (`Subject`, `List`, `Chemical`, etc.)
* $properties: properties of the Object. (see example below)
```json
properties: {
  "name": "Benzene",
  "quantity": 9000,
  "unit": "gram"
}
```
##Preparing an API call

An API call consists of the following parameters:

1. controller - ex. `object`
2. action - ex. `read`
3. parameters passed to the action

Above parameters are `json_encode`d into single string parameter named '`req`'.

Example:
```php
// An example request json_encoded in PHP
$params = ['controller'=>'object','action'=>'read','criteria'=>['_id'=>'54aac226a528fae772d94d0a'],'options'=>['tree'=>true]];
$req = json_encode($params);
echo $req;
```

Output (It's a string!):
```json
{"controller":"object","action":"read","criteria":{"_id":"54aac226a528fae772d94d0a"},"options":{"tree":true}}
```

*Note: In C#, use [JavaScriptSerializer Class](http://msdn.microsoft.com/en-us/library/system.web.script.serialization.javascriptserializer.aspx).*


####List of actions available for `Object` model`(controller:object)`

* `create`: Creates an Object
* `read`: Returns an Object
* `remove`: Removes an Object
* `update`: Updates or inserts Object properties
* `unset`: Removes Object properties

Action | Parameters | Response
---- | ---------- | --------
create | `string parent`, `string type`, `array<string> properties` | `array` of `Object`
read | `array criteria` ex.`{name:benzene, _id:54a36e477cc2bfaa030041a8}`,<br>Optional: `bool tree`(gets all sub-Objects) ex.`{options:{tree:true}}` | `array` of `Object`
remove | `array criteria` ex.`{name:benzene, _id:54a36e477cc2bfaa030041a8}` | `boolean`
update | `array criteria` ex.`{name:benzene, _id:54a36e477cc2bfaa030041a8}`,<br>`array<string> properties`,<br>`bool multiple`(updates all available records) ex.`{options:{multiple:true}}`| `boolean`
unset | `array criteria` ex.`{name:benzene, _id:54a36e477cc2bfaa030041a8}`,<br>`array<string> properties`,<br>`bool multiple`(updates all available records) ex.`{options:{multiple:true}}`| `boolean`


##Calling the API
API calls can be made with either POST or GET request.

**Sample API Calls in jQuery**
```javascript
// POST
$.post( "http://example.com/api/", { req: '{"controller":"object","action":"read","criteria":{"_id":"54aac226a528fae772d94d0a"},"options":{"tree":true}}' })
  .done(function( data ) {
    alert( "Data Received: " + data );
});

// GET
var req = '{"controller":"object","action":"read","criteria":{"_id":"54aac226a528fae772d94d0a"},"options":{"tree":true}}';
$.get( "http://example.com/api/?req="+req })
  .done(function( data ) {
    alert( "Data Received: " + data );
});
```

##TO-DO
- [ ] `User` Object Model (authentication and stuff)

## Example Server Response

Request:
```
POST /EPSInventory-API/?req={"controller":"object","action":"read","criteria":{"_id":"54aac226a528fae772d94d0a"},"options":{"tree":true}} HTTP/1.1
Host: koding.benzhang.xyz
Cache-Control: no-cache
```

Response:
```json
{"data":[{"_id":"54aac226a528fae772d94d0a","parent":"none","type":"Subject","properties":{"name":"Chemistry"},"children":[{"_id":"54aac27fa528fae772d94d0b","parent":"54aac226a528fae772d94d0a","type":"List","properties":{"name":"Chemicals"},"children":[{"_id":"54a9ccf8a528fae772d94d08","parent":"54aac27fa528fae772d94d0b","type":"Chemical","properties":{"name":"Benzene","quantity":900000,"unit":"gram"},"children":null}]}]}],"success":true}
```