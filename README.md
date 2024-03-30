# Food Delivery App Installation Guide

This guide provides detailed steps to install and set up the Food Delivery App using local environment. Follow these instructions carefully to ensure a successful installation.

**NOTE:** It is highly recommended to follow the installation guide of [food-delivery-docker-compose-boilerplate
](https://github.com/Imran17507/food-delivery-docker-compose-boilerplate)

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- PHP 8.3.4
- MySQL 8.3.0
- Laravel 11.1.1
- Composer 2.2.23
- Adminer (Optional)

## Installation Steps

1. **Clone the Application Repository**

   First, clone the application repository to your local machine. Open your terminal and run the following command:

   ```bash
   git clone git@github.com:Imran17507/food-delivery-app.git
   ```

2. **Navigate to the Application Directory**

   Change into the application directory:

   ```bash
   cd food-delivery-app
   ```

3. **Install Dependencies with Composer**

   Run the following command to install PHP dependencies through Composer:

   ```bash
   composer install
   ```

4. **Set Up Environment Configuration**

   Copy the example environment file to create a new .env file:

   ```bash
    cp .env.example .env
    ```

   Ensure the .env file contains the following database configuration:

   ```php
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=food_delivery
    DB_USERNAME=admin
    DB_PASSWORD=1234
   ```

5. **Generate Application Key**

   Generate a new application key:

	```bash
    php artisan key:generate
    ```

6. **Run Database Migrations**

   Apply the database migrations:

   ```bash
    php artisan migrate
    ```

7. **Seed the Database**

   Populate the database with initial data:

   ```bash
    php artisan db:seed
   ```

8. **Run the API Tests**

	Ensure everything is set up correctly by running:

	```bash
    ./vendor/bin/pest
    ```

## Testing API Endpoints

After installation, you can test the API endpoints using a tool like Postman or curl.

- Store Rider Location History
  ```bash
    POST http://localhost:8000/api/rider/location-history
  ```
  Payload:

	```json
	{
		"rider_id": "80",
		"service_name": "UberEats",
		"latitude": "23.807624",
		"longitude": "90.368352",
		"capture_time": "2024-03-30 08:51:55"
	}
	```

- Find The Nearest Rider
	```bash
	POST http://localhost:8000/api/restaurant/nearest-rider
	```
  Payload:

	```json
	{
		"restaurant_id": "10"
	}
	```

Follow these steps to set up and start using the Food Delivery App Service.
