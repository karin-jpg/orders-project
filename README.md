# Symfony 4 API Documentation

## Overview
This Symfony 4 API implemented with DDD provides functionalities to manage orders, including importing orders from a JSON file, retrieving paginated orders, canceling orders, and searching orders by customer or status.

## Requirements
- [PHP](https://www.php.net/) 7.1.3 or higher
- [Composer](https://getcomposer.org/download/) 2.5.8 or higher
- [Symfony 4](https://symfony.com/doc/4.x/setup.html)
- [Doctrine ORM](https://symfony.com/doc/4.x/doctrine.html)
- [SQLite3](https://www.sqlite.org/) or another supported database

## Installation
1. Clone this repository;

2. Navigate to the project directory:
    ```sh
    cd <project_directory>
    ```

3. Copy and paste the .env.example file and change its name to .env
   
4. Install dependencies:
    ```sh
    composer install
    ```
5. Create the app.db file on var/sqlite - the following commands will not work if the file is not created or on the right folder defined on step 3

6. Create the database:
    ```sh
    php bin/console doctrine:database:create
    ```

7. Update the database with the entities:
    ```sh
    php bin/console doctrine:schema:update --force --complete
    ```
8. Run the local server - if done correctly, it should be available on the http://127.0.0.1:8000
    ```sh
    symfony server:start
    ```

Remember to import the orders from the JSON file as instructed below before using the API!

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
