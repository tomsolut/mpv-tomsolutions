# MED - Laravel 12 Project

## Introduction
OMR is a Laravel 12-based application with FILAMENT 3 . This document provides installation and setup instructions.

## Requirements
- PHP 8.3+
- Composer
- MySQL / PostgreSQL / SQLite

## Installation
### 1. Clone the Repository
```sh
git clone https://github.com/tooyndev/med.git
cd med
```

### 2. Install Dependencies
```sh
composer install
npm install
```

### 3. Copy Environment File
```sh
cp .env.example .env
```

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Configure Database
Edit the `.env` file and set up your database connection:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=omr
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migrations
```sh
php artisan migrate --seed
```

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.
