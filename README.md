## Setup steps

- Take a clone from git repository
- Run command ***composer install***
- Set database connection details to env file
- Run Command ***php artisan migrate***
- Run Command ***php artisan db:seed***

- To run test cases, run command ***./vendor/bin/phpunit***
- To run coding standards related checks using phpstan and phpcs, run command ***composer phpstancs***

## API

- Run command ***php artisan serve --port=8000***
- API documentation: ***http://localhost:8000/api/documentation***
- API Base Path: ***http://localhost:8000/api/***