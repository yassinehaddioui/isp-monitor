# PHP App

Get the servers running by typing `./run.sh` in the root directory.
It will spin up your docker containers and the web server will be reachable at
`http://localhost:8080`.



## Authorization
 You need to pass your apiKey as an `Authorization` header or `apiKey` GET parameter.
 Otherwise, you'll get:
```
{
 "statusCode": 401,
 "message": "Unauthorized",
 "error": true
}
```

## Example Request

You can set a cached value via the Cache API making a request like this:
```
curl --request POST \
--url http://localhost:8080/cache/x \
--header 'authorization: yassineX' \
--header 'cache-control: no-cache' \
--header 'content-type: application/json' \
--data '{"ttl":500000000, "data": {"coco":"momo"}}'
```
  
You can get the cached data by making this request:
```
curl --request GET \
--url http://localhost:8080/cache/x \
--header 'authorization: yassineX' \
--header 'cache-control: no-cache' \
--header 'content-type: application/json'
```
The response will look like this:
``` 
{
  "data": {
    "coco": "momo"
  }
}
```