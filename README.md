

## Local Setup

1. Build container 

```bash
docker-compose -f .docker/docker-compose.yml up -d --build
```

2. Install dependencies

```bash
composer install
```

3. Add a database user
```bash
docker-compose -f .docker/docker-compose.yml exec db mysql -uroot -proot
```
```mysql
CREATE USER 'wluser'@'%' IDENTIFIED BY 'wlpassword';
GRANT ALL PRIVILEGES ON wordliner.* TO 'wluser'@'%';
FLUSH PRIVILEGES;
exit
```

4. Create the database
```bash
bash scripts/console doctrine:database:create
```

5. Create the tables and fixtures
```bash 
bash scripts/console doctrine:migrations:migrate
```

6. Get the Oauth token: 
```bash
curl --location 'http://localhost:8080/token' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'grant_type=password' \
--data-urlencode 'client_id=8054c571f3304dfcbf922dfa8d8ba935' \
--data-urlencode 'client_secret=8ff7b377e6df0e8362f891dfddf3c114809404fcb2a655279d41e920e1d11cc87a6a07314eeaa6b0e58ed8f7a6e814d37af1836d11c313aac315ae0046c3380e' \
--data-urlencode 'scope=read write' \
--data-urlencode 'username=admin@wordliner.com' \
--data-urlencode 'password=password'
```

7. Properties Endpoint using the access token 
```bash
curl --location 'http://localhost:8080/api/properties' \
--header 'Authorization: [ACCESS_TOKEN]'
```
