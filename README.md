

# Book Store Inventory System

## Description:
 Book Store is a simple, yet effective, book inventory management system designed to help manage books in a bookstore.
 It allows for easy tracking of book details, inventory status, and other relevant information.
 This system leverages modern web technologies to provide a user-friendly and efficient solution for bookstore management.

## Features:
 - Book Management: Add, update, and delete book records.
 - Inventory Tracking: Monitor the stock levels of books.
 - Search Functionality: Easily search for books by title, author, or ISBN.
 - User Interface: A clean and intuitive user interface using TailWindCSS and FlowBite components.
 - Real-time Interactions: Dynamic interactions powered by AlpineJS.

## Requirements:
 - PHP ^7.4
 - MySQLi
 - TailWindCSS ^3.0
 - FlowBite
 - AlpineJS

## Step 1: Clone the Repository

```bash

echo "Step 1: Cloning the repository..."
git clone https://github.com/algoetech/bookstore.git
cd bookstore || { echo "Failed to change directory to 'bookstore'"; exit 1; }

```

## Step 2: Install Dependencies (if any)
### Since this project primarily uses PHP and MySQLi, we'll ensure PHP is installed.

```bash
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP 7.4 or later and try again."
    exit 1
fi
```

## Step 3: Configure the Database
```bash
echo "Step 3: Configuring the database..."
read -rp "Enter your MySQL username: " db_user
read -rsp "Enter your MySQL password: " db_pass
echo
read -rp "Enter the path to your SQL file (e.g., path/to/database.sql): " sql_file

if command -v mysql &> /dev/null; then
    mysql -u "$db_user" -p"$db_pass" -e "CREATE DATABASE bookstore;"
    mysql -u "$db_user" -p"$db_pass" bookstore < "$sql_file"
else
    echo "MySQL is not installed. Please install MySQL and try again."
    exit 1
fi
```

## Update database configuration in config.php
```bash
echo "Updating database configuration..."
cat > config.php <<EOL
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', '$db_user');
define('DB_PASSWORD', '$db_pass');
define('DB_NAME', 'bookstore');
EOL
```

## Step 5: Run the Application
```bash
echo "Step 5: Running the application..."
php -S localhost:8000
```

## Usage:
    * Once the application is up and running, you can use the following features:
    * - Add Book: Navigate to the "Add Book" section to input new book details.
    * - View Inventory: Check the list of all books in the inventory.
    * - Edit Book Details: Update the information of existing books.
    * - Delete Book: Remove a book from the inventory.

## Contribution:
     Contributions are welcome! If you would like to contribute to the project, please follow these steps:
     1. Fork the repository.
     2. Create a new branch: git checkout -b feature-branch-name.
     3. Make your changes and commit them: git commit -m 'Add some feature'.
     4. Push to the branch: git push origin feature-branch-name.
     5. Create a pull request.

## License:
     This project is licensed under the MIT License. See the LICENSE file for more information.
