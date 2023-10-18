## Create Laravel project
docker-compose exec app composer create-project --prefer-dist laravel/laravel .

## Authentication (#Laravel JetStream є потужним стеком, який надає імплементацію для аутентифікації)
docker-compose exec app composer require laravel/jetstream
