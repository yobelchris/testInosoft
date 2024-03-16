## Installation
1. Use PHP 8.0 and Laravel 8

2. Make sure you already install mongodb driver for PHP

3. Clone the repository:

   ```bash
   git clone https://github.com/yobelchris/testInosoft.git
   
4. Navigate to the project directory:
    ```bash
   cd testInosoft
   
5. Install Composer dependencies:
    ```bash
   composer install
   
6. Create a copy of the .env.example file and rename it to .env
     ```bash
   cp .env.example .env
   
7. Configure the database connection in .env file

8. Configure your .env file with your database credentials and other settings.

9. Run database seeder to initialize several users
    ```bash
   php artisan db:seed
   
10. Run development server
    ```bash
    php artisan serve
