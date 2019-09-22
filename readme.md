This Application has Apis for image representation applications.
It uses passport to Create authentication for endpoints JWT authentication security.


STEPS TO RUN THE APPLICATION:

    - configure the database that will be used in .env file.
    - run "php artisan migrate" command ===> this command create the database tables of the website.
    - run "php artisan passport:install --force" command ===> this command is used to make sure that passport is installed correctly for authentication.(some time thier is errors happen in the passport when the users table is recreated so force install is needed).

    - run "php artisan db:seed --class=GenresTableSeeder" ==> add data to the genres table.
    - run "php artisan db:seed --class=ActorsTableSeeder" ==> add data to the actors table.
    - run "php artisan db:seed --class=MoviesTableSeeder" ==> generate dummy data to movies table, create random connections between the created movies with genres and actors and add english and german description to the created movies which will always be "english description" and "german description" for the sake of testing.


Apis description:

    -here is link for the post man collection of apis https://www.getpostman.com/collections/797642123f59dad25be7
    -register with admin field = 1 to create admin user.
    -in the header the field authentication field will need to be updated with the JWT after the Bearer (Bearer {JWT})that will be send in the response json when register or login.
    to close the authentication and authorization features in terms of test please comment the 32, 37, 50 and 51 lines in route/api.php file.
