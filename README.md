## Create Laravel project
docker-compose exec app composer create-project --prefer-dist laravel/laravel .

## Authentication
docker-compose exec app composer require laravel/jetstream
docker-compose exec app php artisan jetstream:install livewire
docker-compose exec app php artisan migrate
docker-compose exec app npm install && npm run dev

## Create Policies
docker-compose exec app php artisan make:policy PostPolicy --model=Post

## Create Post
docker-compose exec app php artisan make:model Post

## Composer AutoLoad (# to fix for define Post.php)
docker-compose exec app composer dump-autoload

# Crud
docker-compose exec app php artisan make:controller PostController --resource
docker-compose exec app composer update
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear

# Middleware
docker-compose exec app php artisan make:middleware CheckAuthenticated

# Rules
sudo chmod 777 -R /home/neitron/PhpstormProjects/igor/laravel
docker-compose exec app php artisan view:clear
docker-compose exec app  php artisan route:clear

# Queue
- create table queue: php artisan queue:table
- run migration: php artisan migrate
- create new file WriteToLog.php: docker-compose exec app php artisan make:job WriteToLog
- start the queue worker: docker-compose exec app php artisan queue:work
- can be check: http://localhost:8010/dispatch-job

# Cache
docker-compose exec app php artisan serve
- can be test set key: http://localhost:8010/cache-set?key=yourUniqueKey&value=ThisIsTheValue
- can be test get key: http://localhost:8010/cache-get?key=yourUniqueKey

# API 
- Create API KEY: ff1ee38d76df76dc57a73eef9d5cc2ec via https://home.openweathermap.org/api_keys
- Install Guzzle: docker-compose exec app composer require guzzlehttp/guzzle
