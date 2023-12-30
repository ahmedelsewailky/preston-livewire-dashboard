# Preston

Preston is a dashboard admin panel that was created with laravel 10, that contain common of uses pages for any project to be available for multi propuse of using.
- RTL Support.
- Dark Mode.
- Fully Responsive.
- Chat App
- Calendar

![alt text](https://github.com/ahmedelsewailky/preston/blob/master/public/dashboard/images/screenshot.png?raw=true)

## Installation
- Make a clone from respository.
```bash
git clone git@github.com:ahmedelsewailky/preston.git
```
- Downloading packages and requirements.
```bash
composer install
```
- Creating a copy of .env.example file to `.env` .
- Generate your .env file key.
```bash
php artisan key:generate
```
- Create database with name `laravel`.
- Runing migration with seeding, this will create 5000 post.
```bash
php artisan migrate --seed
```
- Runing server.
```bash
php artisan serv
```

> Note: For using single page app just add `wire:navigate` for all links

## Features
- Updating Auth Profile.
- Users Cruds with Default Image Avatar.
- Categories Cruds with Bootstrap Modal.
- Tags Cruds with Bootstrap Modal.
- Posts Cruds with Sommernote and Select2.
- Cruds for Roles and Premissions.
- Messenger Chatapp with Mark Readable Message and Online Users.
- Calendar for Appointments.

## Packages

| Package Name | Verison |
| ------------ | ------- |
|livewire/livewire|3.0|
|livewire/volt|1.0|
|spatie/laravel-permission|6.2|
|spatie/laravel-translatable|6.5|
|laravolt/avatar|5.1|


## Plugins

| Name |   |
| ---- | - |
|Bootstrap|https://getbootstrap.com/|
|jQuery|https://jquery.com/|
|Summernote|https://summernote.org/|
|Select2|https://select2.org/|
|Apexchart|https://apexcharts.com/|
|FullCalendar|https://fullcalendar.io/|

## License
MIT
