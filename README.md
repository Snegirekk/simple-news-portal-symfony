- Clone the project
```
$ git clone git@bitbucket.org:Snegirekk/employees-schedule.git
$ cd employees-schedule
```

- Install dependencies
```
$ composer install
```

- Configure env vars
```
$ cp .env .env.local
$ nano .env.local
```
Edit `DATABASE_URL` with your credentials

- Create DB, load fixtures
```
$ bin/console doctrine:database:create
$ bin/console doctrine:migrations:migrate
$ bin/console doctrine:fixtures:load
```

Go to the public directory and launch dev server
```
$ cd public
$ php -S 127.0.0.1:8080
```

All done, feel free to checkout this great news portal