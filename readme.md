#DesignTime

Adapted from: https://github.com/jeremykenedy/laravel-tasks

Laravel 8 with user authentication, password recovery, and individual user tasks lists. This also makes full use of Controllers for the routes, templates for the views, and makes use of middleware for routing.  Uses laravel ORM modeling and has CRUD (Create Read Update Delete) functionality for all tasks.

This has robust verbose examples using Laravel best practices.  The task list is a build out of https://laravel.com/docs/8.x/.

Super easy setup, can be done in 5 minutes or less.

###### A [Laravel](http://laravel.com/) 8.x with minimal [Bootstrap](http://getbootstrap.com) 3.5.x project.
| Laravel-Tasks Features  |
| :------------ |
|Built on [Laravel](http://laravel.com/) 5.2|
|Dependencies are managed with [COMPOSER](https://getcomposer.org/)|
|CRUD (Create, Read, Update, Delete) Tasks Management|
|User Registration with password reset via Email|
|User Login with remember password|

### Quick Project Setup
###### (Not including the dev environment)
1. Run `sudo git clone https://github.com/jeremykenedy/laravel-tasks.git laravel-tasks`
2. Create a MySQL database for the project
    * ```mysql -u root -p```, if using Vagrant: ```mysql -u homestead -psecret```
    * ```create database laravelTasks;```
    * ```\q```
3. From the projects root run `cp .env.example .env`
4. Configure your `.env`
5. Run `sudo composer update` from the projects root folder
6. From the projects root folder run `sudo chmod -R 755 ../laravel-tasks`
7. From the projects root folder run `php artisan key:generate`
8. From the projects root folder run `php artisan migrate`
9. From the projects root folder run `composer dump-autoload`

And thats it with the caveat of setting up and configuring your development environemnt. I recommend [VAGRANT](https://docs.vagrantup.com/v2/getting-started/) or the Laravel configured instance of Vagrant called [HOMESTEAD](http://laravel.com/docs/7/homestead).

#### View the Project in Browser
1. From the projects root folder run `php artisan serve`
2. Open your web browser and go to `http://localhost`