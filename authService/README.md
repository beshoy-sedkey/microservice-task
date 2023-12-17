# Authentication Microservice
This repository contains the code for an authentication microservice built with Laravel. This service handles user registration, login.
## Features
- User registration and push message via rabbitmq to fanout exchange this message contain an user object to the note-management microservice
- User Login 
- user authentication will be with jwt 

## Requirements

- PHP >= 8.1
- Composer
- MySQL or any other database supported by Laravel
- Laravel >= 8.x

## Installation
Clone the repository and install dependencies:
```bash
git clone https://github.com/beshoy-sedkey/dayra-task.git
cd authService
cp .env.example .env
```
## Generate Secret Key (JWT)
```bash
php artisan jwt:secret
```
## Update your .env file 
- For RabbitMQ I am using https://www.cloudamqp.com/  
```
RABBITMQ_HOST=
RABBITMQ_PORT=
RABBITMQ_VHOST=
RABBITMQ_USER=
RABBITMQ_PASSWORD=
RABBITMQ_QUEUE=auth-queue
RABBITMQ_EXCHANGE_NAME=Dayra
RABBITMQ_EXCHANGE_TYPE=fanout
RABBITMQ_EXCHANGE_DECLARE=true
``` 
- For JWT Secret 
```
JWT_SECRET= your_generated_secret_key
```
- Database Configuration
```
DB_CONNECTION=mysql
DB_HOST=auth_db
DB_PORT=3306
DB_DATABASE=authService
DB_USERNAME=root
DB_PASSWORD=123456789
```
## RUN Docker
```bash
docker-compose build --up -d 
```
## Migrate Tables In Database
```bash
RUN docker ps (select the CONTAINER ID for auth service)
RUN docker exec -ti --user root (container_id) /bin/bash
RUN php artisan migrate
```
## Runing Test
```bash
RUN docker ps (select the CONTAINER ID for auth service)
RUN docker exec -ti --user root (container_id) /bin/bash
RUN php artisan test
```


## API Reference

#### Register

```http
  POST /api/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required** |
| `email` | `string` | **Required**|**Unique**| 
| `password` | `string` | **Required**|

#### Login

```http
  Post /api/Login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**| 
| `password` | `string` | **Required**|


