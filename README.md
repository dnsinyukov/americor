## Setup

### Setup Backend
```
make build
``` 

OR

```
cd app && docker compose --env-file=./app/.env up -d --build

docker exec -ti app bash && php bin/console doctrine:fixtures:load
```

### Setup frontend

```
cd app-front && npm i && npm run dev
```
