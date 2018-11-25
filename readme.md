## Installation 

Make a new folder. for example 'Laravel'

$ cd Laravel

First clone the repository

```bash
git clone https://github.com/starofpython999/laravel_OAuth2.git

```

```
cd laravel_OAuth2
```


Install dependencies

```bash
composer install
```

Copy the `.env` file an create an application key

```
cp .env.example .env && php artisan key:generate
```

Migrate the tables.

```
php artisan migrate
```

```
php artisan db:seed
```

This comes with Passport include as the default authenticatin method. You should now install it using this command.

```
php artisan passport:install
```

Now serve your application and try to request a token using cURL

```bash
php artisan serve
```
Log in with following credential.
```
username: fahd@example.com
password: 123456
```

After you log in, you can see that two dialogs are created.
You can create OAuth Client.
Create like below.
```
Name: demo
Redirect URL : http://localhost:8000/lists
```

```bash
Create new Tab and copy this link.
localhost:8000/oauth/authorize?client_id=3&response_type=code&redirect_uri=http%3A%2F%2Flocalhost:8000%2Flists

Click Authorize button.
```