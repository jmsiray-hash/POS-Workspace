# IT0049 POS Workspace

A CodeIgniter 4 point-of-sale foundation with database-backed customer and user pages.

## Local setup

### Requirements

- PHP 8.1 or later with the `mysqli` extension enabled
- Composer
- MySQL (XAMPP users can start MySQL from the XAMPP Control Panel)

### Install and configure

1. Clone the repository and install its PHP dependencies:

   ```bash
   git clone https://github.com/jmsiray-hash/POS-Workspace.git
   cd POS-Workspace
   composer install
   ```

2. Create the local database and tables, and insert the sample records by importing [`database/pos_db.sql`](database/pos_db.sql). For example, with XAMPP phpMyAdmin, open `http://localhost/phpmyadmin`, choose **Import**, select the SQL file, then run the import.

3. Configure the database connection in `.env` for your local MySQL account. The default XAMPP settings are:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   database.default.hostname = 127.0.0.1
   database.default.database = pos_db
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

   Change the username, password, hostname, or port if your local MySQL setup differs. Keep MySQL running while using the application.

## Run the application

From the repository directory, start the CodeIgniter development server:

```bash
php spark serve
```

Open `http://localhost:8080` in your browser. The local pages are:

- **Home:** http://localhost:8080/
- **About:** http://localhost:8080/about
- **Customers Page:** http://localhost:8080/customers
- **Users Page:** http://localhost:8080/users

With Apache configured to serve the project from XAMPP, you can also try:

- **Customers Page:** http://localhost/POS-Workspace/public/customers
- **Users Page:** http://localhost/POS-Workspace/public/users

## Test the local setup

- Confirm the Home, About, Customers, and Users pages load and their navigation links work.
- Confirm the Customers page displays customer names, emails, phone numbers, and creation dates from MySQL.
- Confirm the Users page displays usernames, full names, and creation dates from MySQL.
- If either account page reports a database connection error, check that MySQL is running and the `.env` connection settings match your local server.
