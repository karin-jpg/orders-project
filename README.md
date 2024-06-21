# Symfony 4 API Documentation

## Overview
This Symfony 4 API provides functionalities to manage orders, including importing orders from a JSON file, retrieving paginated orders, canceling orders, and searching orders by customer or status.

## Requirements
- PHP 7.1.3 or higher
- Symfony 4
- Doctrine ORM
- SQLite3 or another supported database

## Installation
1. Clone this repository;

2. Navigate to the project directory:
    ```sh
    cd <project_directory>
    ```

3. Install dependencies:
    ```sh
    composer install
    ```

4. Configure the `.env` file with your database credentials (example):
    ```env
    DATABASE_URL="sqlite:///%kernel.project_dir%/var/sqlite/app.db"
    ```

5. Create the database:
    ```sh
    php bin/console doctrine:database:create
    ```

6. Update the database with the entities:
    ```sh
    php bin/console doctrine:schema:update --force --complete
    ```
7. Run the local server - if done correctly, it should be available on the http://127.0.0.1:8000
    ```sh
    Symfony server:start
    ```
## Functionality

1. Import Orders from JSON File
Creates a command to import data from `orders.json` into the database using Doctrine ORM.
Json structure:
```json
  {
		"id": 1000,
		"date": "2020-07-22 18:57:51",
		"customer": "Hilary Greer",
		"address1": "488-8906 Facilisis Avenue",
		"city": "Mobile",
		"postcode": "511162",
		"country": "Switzerland",
		"amount": 6093,
		"status": "cancelled",
		"deleted": "No",
		"last_modified": "2020-10-16 05:35:52"
	}
```

 Command
```sh
php bin/console app:import-entities ./src/Resource/entities.json
```
Remember that if the file is moved from the original folder, the path to it should be ajusted on the console command
 2. Get Order
Retrieve orders.
GET Request
Path: /orders
Example:
```sh
curl -X GET http://127.0.0.1:8000/orders/page/1
```

 3. Cancel order
Allow users to cancel an order.
POST Request
Path: /orders/{orderId}/cancel
Returns an array of orders
Example:
```sh
curl -X DELETE http://127.0.0.1:8000/orders/1000/cancel
```

 4. Search orders by customer
Allow users to search for orders by customer. This endpoint receives a JSON with the customer name to filter all orders from that customer.
POST Request
Path: /orders/customer
Returns an array of orders of that customer
Request Body:
```json
{
    "customer": "John Doe"
}
```
Example:
```sh
curl -X POST http://127.0.0.1:8000/orders/customer -H "Content-Type: application/json" -d '{"customer": "Very creative customer name"}'
```

 5. Search orders by status
Allow users to search for orders by status. This endpoint receives a JSON with the order status to filter the orders.
Path: /orders/status
Returns an array of orders with that status
Request Body:
```json
{
    "status": "cancelled"
}
```
Example:
```sh
curl -X POST http://127.0.0.1:8000/orders/status -H "Content-Type: application/json" -d '{"status": "cancelled"}'
```

### Conclusion
This API provides functionalities for managing orders, 
including importing orders from a JSON file, 
retrieving paginated orders, 
canceling orders, 
and searching for orders by customer or status. 

Follow the provided instructions for installation and usage to get started.
