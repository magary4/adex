# ADEX API

### Install

```
docker-compose -f docker-compose-darwin.yml -d docker-compose.yml up -d
docker exec -it api_php composer install
docker exec -i api_mysql mysql -uadex_api -padex_api adex_api < data/db.sql 
```

### Endpoints

##### Add:

```
POST /incoming-request HTTP/1.1
Content-Type: application/json

{"customerID":1,"tagID":"1","remoteIP":"123.234.56.78","timestamp":1500000000}
```

##### Get statistics:

```
GET /statistics?customerID=1&date=2018-08-28
```

### TODO

1. Remove Doctrine for better performance. Implement simple DB-layer instead
2. If we talking about billions of requests, I suggest to not block table hourly_stats with infinite writing into in. instead of this write incoming data to View and via cron-job ones per hour write data to hourly_stats
3. Write tests