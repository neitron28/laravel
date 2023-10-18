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




