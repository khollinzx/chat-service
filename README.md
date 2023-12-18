<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center"><a href="" target="_blank"><img alt="" src="https://pbs.twimg.com/profile_images/1509047739958579202/-tGwtwAq_400x400.jpg" width="400"></a></p>


## About TreeKle (API Service)

Chat-Service-Backend: this was an assessment assigned to me, in order to implement a chat app service, where the client part would be coded on a React-Native framework.
## Installtion

### Prequisite

Install Docker (Mac OS or Windows), PHP 8.0 & Composer
Ensure Docker is running

### Clone Repository
Clone repo using the https link.
```
git clone https://github.com/khollinzx/chat-service-backend-end 
```
OR SSH link
```
git clone git@github.com:khollinzx/chat-service-backend-end.git 
```

### Set Up

```
Run cd chat-service
cp .env.example .env
Request for .env contents and replace
Run composer install
Edit docker.compose.yml  replace '${APP_PORT:-80}:80' with "8091:80"
Run alias sail='bash vendor/bin/sail'
Run sail up
If there is an error with mysql starting, change FORWARD_DB_PORT=3306 to 3307 and run sail down then sail up
Run sail artisan migrate:fresh --seed
sail artisan passport:install
```

### Postman

```
Request for postman login details
Login and start building !!

--- https://documenter.getpostman.com/view/10224661/2s9YkocLVw
```
