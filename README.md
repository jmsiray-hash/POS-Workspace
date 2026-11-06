# TFA6 POS Workspace

A Laravel 12 Point of Sale (POS) application for Technical Formative Assessment 6. The app uses Eloquent models and a relational database to display customer and user directories.

## Requirements

- PHP 8.2 or newer
- Composer
- MySQL with the PDO MySQL PHP extension (XAMPP users can start MySQL from the XAMPP Control Panel)

## Local setup

Open PowerShell or a terminal in the project root.

1. Install PHP dependencies:

   ```powershell
   composer install
   ```

2. Create the local environment file if it does not already exist. In PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

   Keep an existing `.env` rather than overwriting your local settings.

3. Create a MySQL database named `pos` (for example, in phpMyAdmin). Configure `.env` to match your local MySQL settings:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pos
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   The values above are typical XAMPP defaults. Use the credentials configured on your machine.

4. Generate the Laravel application encryption key:

   ```powershell
   php artisan key:generate
   ```

5. Run the migrations and seed the database:

   ```powershell
   php artisan migrate --seed
   ```

   The seeder creates or updates five sample customers and five sample users, so it can safely be run again.

   > **Warning:** `php artisan migrate:fresh --seed` drops all existing tables before recreating them. Use it only when you are comfortable deleting the data in the configured database.

6. Start the Laravel development server:

   ```powershell
   php artisan serve
   ```

7. Open the app at <http://127.0.0.1:8000>.

## Pages

- Home: <http://127.0.0.1:8000/>
- About: <http://127.0.0.1:8000/about>
- Customers: <http://127.0.0.1:8000/customers>
- Users: <http://127.0.0.1:8000/users>

## Tests

Run the feature test suite:

```powershell
composer test
```
