Step 1:

Composer install

Step 2:

copy .env.example file to .env and add database details

Step 3:

php artisan migrate

Step 4:
configuration is done

Step 5:
Change Google API to your api in resources/views/client/addressess.blade.php

List of API's(Post Requests)

http://localhost/api/login accepts email and password
http://localhost/api/register accepts email, name, password
http://localhost/user/saveAddress accepts address[], type[], token

Address view(Get Request)

http://localhost/api/user/{api}



