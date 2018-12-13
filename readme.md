

## About the project

It's a simple notepad system to practice the concepts of event sourcing and cqrs using proohp

## Setup

It was used Laravel and equivalent laravel-packages and to make it easier the process, laradock.io Docker environment.

- Clone this repository
- Initialize the submodules
```
git submodule init
git submodule update
```

If that does not work, use
```
git submodule add https://github.com/Laradock/laradock.git
```

- Copy the sample .env file for the docker environment
```
cp .env.laradock laradock\.env
```

- Copy the example .env for the laravel app
```
cp .env.example .env
```

- Start the docker images
```
cd laradock
docker-compose up -d nginx mysql workspace elasticsearch kibana
```

- Install the composer packages
```
cd laradock
docker-compose exec workspace bash
# composer install
```

- Generate the key
```
# artisan key:generate
```

## Notes

As you switch from one branch to another you may have to run 
```
# composer dump-autoload
```

So it can create the proper autoload class map.

And

```
# artisan migrate:refresh
```

To drop and recreate the necessary tables.

The following routes are available - added as GET for simplicity

http://localhost/api/user
http://localhost/api/notepad
http://localhost/api/notepad/<notepad-id>/note

### Projections

To run the projection you have to run it from the command line
```
#artisan project:notepad
```

It will keep running on the foreground. In practice you would likely use something like supervistord.


