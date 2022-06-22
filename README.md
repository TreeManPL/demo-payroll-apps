# About

Example of payroll application with basic user/department

## Tech stack

- PHP 8.1
- Postgres
- RabbitMq

## API documentation

For OpenApi documentation go to ```doc/api.yaml```

## How run application

Requirements:
- Docker
- Free ports (8000 - http, 15672 - rabbitmq management, 5432 - postgres)

To run application just type in console
```./bin/docker.sh up```

### Setup database

```
./bin/docker.sh sh php
./bin/console doctrine:database:create
./bin/console doctrine:schema:create
```

### Consume Messages from queue to refresh projection
```
./bin/console messenger:consume
```

### To refresh all contracts payroll projection run
```
./bin/console app:refresh-all_contracts-payroll-projections
```

### Credentials

RabbitMq

```
Host: http://localhost:15672
User: user
Password: password    
```

Postgres

```
Host: localhost:15672
User: postgres
Password: example    
```

Login to php container
```
./bin/docker.sh sh php
```
