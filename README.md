# ISP Monitor 

Simple API to test your internet connection.
You will need to setup a MongoDB in order to store results.
Feel free to implement your own data storage if you feel like it.
Pull Requests welcome.

## Responses
GET /speedtest
Optional (GET) params are:
 - testUrl: string, default in bootstrap/settings.php
 - timeout: integer, default in bootstrap/settings.php
 - save: integer, default is 0
```
{
    "data": {
        "downloadSpeed": {
            "value": 6.07,
            "unit": "MB/s"
        },
        "timeElapsed": {
            "value": 2.7976,
            "unit": "s"
        },
        "fileSize": {
            "value": 16.99,
            "unit": "MB"
        },
        "url": "http://speedtest2.verticalbroadband.com/speedtest/random3000x3000.jpg",
        "timeout": 20,
        "timestamp": 1483069941
    },
    "meta": {
        "saved": 1
    }
}
 ```
 
 GET /speedtest/logs
 Optional (GET) params are:
  - limit: integer, default is 1000
```
 {
     "data": [
         {
             "downloadSpeed": {
                 "value": 6.02,
                 "unit": "MB/s"
             },
             "timeElapsed": {
                 "value": 2.8209,
                 "unit": "s"
             },
             "fileSize": {
                 "value": 16.99,
                 "unit": "MB"
             },
             "url": "http://speedtest2.verticalbroadband.com/speedtest/random3000x3000.jpg",
             "timeout": 20,
             "timestamp": 1483070242,
             "_id": {
                 "$oid": "5865db2274fece3c1c521ad4"
             }
         },
         {
             "downloadSpeed": {
                 "value": 6.07,
                 "unit": "MB/s"
             },
             "timeElapsed": {
                 "value": 2.7976,
                 "unit": "s"
             },
             "fileSize": {
                 "value": 16.99,
                 "unit": "MB"
             },
             "url": "http://speedtest2.verticalbroadband.com/speedtest/random3000x3000.jpg",
             "timeout": 20,
             "timestamp": 1483069941,
             "_id": {
                 "$oid": "5865d9f574fece3eab6175c2"
             }
         },
         {
             "downloadSpeed": {
                 "value": 5.84,
                 "unit": "MB/s"
             },
             "timeElapsed": {
                 "value": 2.9117,
                 "unit": "s"
             },
             "fileSize": {
                 "value": 16.99,
                 "unit": "MB"
             },
             "url": "http://speedtest2.verticalbroadband.com/speedtest/random3000x3000.jpg",
             "timeout": 20,
             "timestamp": 1483069920,
             "_id": {
                 "$oid": "5865d9e074fece3c191d7504"
             }
         }
     ],
     "meta": {
         "options": {
             "sort": {
                 "timestamp": -1
             },
             "limit": 3
         }
     }
 }
```
 
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

## Development
Start the local PHP server by running
```
php -S localhost:8888 -t public public/index.php
```
