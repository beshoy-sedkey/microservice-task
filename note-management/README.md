# Note-management Microservice
This repository contains the code for an note management microservice built with Laravel. This service handles user login , creating note , retrieving a list of all notes for a user , Retrieving a single note by its ID , updating a note , deleting a note. 
## Features
- User Login 
- creating note 
- list notes
- show a specific note by id 
- update note
- delete note

## Requirements
- PHP >= 8.1
- Composer
- MySQL or any other database supported by Laravel
- Laravel >= 8.x

## Installation
Clone the repository and install dependencies:
```bash
git clone https://github.com/beshoy-sedkey/dayra-task.git
cd note-management
cp .env.example .env
```
## Update your .env file 
- For RabbitMQ I am using https://www.cloudamqp.com/  
```
RABBITMQ_HOST=
RABBITMQ_PORT=
RABBITMQ_VHOST=
RABBITMQ_USER=
RABBITMQ_PASSWORD=
RABBITMQ_QUEUE=note-management-queue
RABBITMQ_EXCHANGE_NAME=Dayra
RABBITMQ_EXCHANGE_TYPE=fanout
RABBITMQ_EXCHANGE_DECLARE=true
``` 
- For JWT Secret 
```
JWT_SECRET= put_secret_key_on_the_auth_service
```
- Database Configuration
```
DB_CONNECTION=mysql
DB_HOST=note-management-db
DB_PORT=3306
DB_DATABASE=note-management
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
## Notes 
- The note-management service is depandent on the auth-service in the registration so when you creating new user event will be fired and push a message on a queue , it had binded with a fanout exchange and the note management will consume the user object and create a user that already have been created on authService 

## API Reference

#### Login

```http
  Post /api/Login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**| 
| `password` | `string` | **Required**|

#### Login

```http
  Post /api/Login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**| 
| `password` | `string` | **Required**|

#### Create Note

```http
  Post /api/note
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title` | `string` | **Required**| 
| `content` | `string` | **Required**|
| `user_id` | `string` | **Required**|

#### Update Note

```http
  Post /api/note/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title` | `string` | **Sometimes**| 
| `content` | `string` | **Sometimes**|
| `user_id` | `string` | **Sometimes**|

#### Show Note

```http
  GET /api/note/{id}
```
#### Delete Note

```http
  DELETE /api/note/{id}
```
#### List Note

```http
  GET /api/note
```
