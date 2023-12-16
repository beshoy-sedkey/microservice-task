# Authentication Microservice
This repository contains the code for an authentication microservice built with Laravel. This service handles user registration, authentication, and authorization.
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
cd auth-microservice
cp .env.example .env
docker-compose build --up -d 
for migrate tables in db
RUN docker ps (select the CONTAINER ID for auth service)
RUN docker exec -ti --user root (container_id) /bin/bash
RUN php artisan migrate
for running Test
RUN docker ps (select the CONTAINER ID for auth service)
RUN docker exec -ti --user root (container_id) /bin/bash
RUN php artisan migrate

