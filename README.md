## Requirements
The code challenge was build with build system Ubuntu 22.04.3 LTS
Requirements and packages may differ for other systems

Following packages where used:
- php cli, version PHP 8.1.2-1ubuntu2.14 (cli)
  - php-xml
  - php-curl
- Composer 2.2.6

## Build & run the application
To build and test the application the following steps have been executed. 
````
composer install
cp .env.example .env
docker-compose up --build
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan test
````
### Trouble shoot
The following challenges did show up during the build and have been solved in the following way:
-> Laravel sail did not build and raised an error
- Add the following entries to the .env file, see here[https://stackoverflow.com/questions/67224488/laravel-sail-wont-build-on-ubuntu-20-04-groupadd-invalid-group-id-sail]
````
WWWGROUP=1000
WWWUSER=1000
````
-> laravel container failing to connect to database
Caused by: docker network challenge with environment parameters
- set 127.0.0.1 as default value in docker-compose for mysql db host
- set env-variable in env-file DB_HOST to 'mysql' (alias of mysql) for laravel test
- DB_HOST should now be equal to service name of mysql container on docker-compose.yml



# WELCOME TO THE CPI APPLICATION TEST

We are glad that you are interested in working with us. To get to know you better, we would like to give you a small
task. Please read the following instructions carefully and complete the tasks while you are recording yourself in loom.
If you have any questions, please do not hesitate to contact us. 

*** Please fork this repository and work on your fork. ***

1. Get into the code -
   Check the code, run it and check the tests with for example `./vendor/bin/sail artisan test`

2. Complete the ProjectController with CRUD routes
3. Write tests for the ProjectController
4. Introduce a new model: Time Tracking - Following attributes the new model must have at least:

- id
- project_id
- start_time
- end_time

5. Users should be able to start and stop the timer of the tracking tool, like usual developers do to track their time. 
   Introduce a new Controller to allow users to do so. Important: Users shall not be allowed to edit the time after tracking it.
6. Every Monday we want to send an email to all users that summarizes their time tracking
7. Think about one more feature you would like to add to the application and implement it

Rules:

- Everything is allowed to complete the tasks
- You can use any library you want, but you have to justify why you use it
- Although code is now in Controller, this is not how we want to see it in production. Please refactor it, so that the
  code is in the right place
- When you are done, please create a pull request in the GitHub repository and invite us to review it. Make sure that
  you have your full name in your GitHub - if not, include it in the code or send it via mail reply to the last HR
  email.
