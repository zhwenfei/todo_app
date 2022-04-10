# Todo List RESTful API with Laravel**

## Requirements

- Laravel Sail with Docker: [docker-compose.yml](https://github.com/zhwenfei/todo_app/blob/main/docker-compose.yml)
- PHP - version 8
- Laravel - version 9
- MySql - version 8
- API Authentication - Laravel Sanctum

## Setup

- Run db migration:
```
php artisan migrate
```
- Use Laravel Tinker to insert user reocord and generate API token
```
$user = User::create(["name"=> "todo_app","email"=>"todo_app@test.com","password"=>bcrypt("123456")]);
$user->createToken('test_token');
```

- Copy plainTextToken from the above createToken output, whcih would should be included in the Authorization header as a Bearer token for API client

## Main codes
- https://github.com/zhwenfei/todo_app/blob/main/app/Http/Controllers/TodoAppController.php
- https://github.com/zhwenfei/todo_app/blob/main/app/Services/TodoService.php

# API endpoints:
- Provided seperatedly in Postman collection
