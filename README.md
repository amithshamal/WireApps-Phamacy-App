# Pharmacy Management System

This project is built with Laravel for managing a pharmacy's business processes including authentication, medication inventory management, and customer management.

## Getting Started

To run this project locally, follow these steps:

### Prerequisites

- PHP >= 7.4
- Composer
- SQLite (or any other supported database by Laravel)

### Installation

1. Clone this repository
2. Navigate to the project directory
3. run composer install to Install dependencies
4. Copy the .env.example file to .env
5. Update the database settings in the .env file.
6. Seed the database with mock data (php artisan migrate:fresh --seed)
7. open postman and import (File->import) WireApps.postman_collection.json
8. Generate Application key (php artisan key:generate)
9. execute php artisan serve to start the development server and The API will be accessible at http://127.0.0.1:8000 by default
10. To execute test run php artisan test



## setup instructions
1. Login as an admin (UN -- admin@admin.com, PW-- password)
2. Create Manager(use User Register--Manager postman call)
3. Create cashier(use User Register--Cashier postman call)

Get the token return by each action and use them as Bearer token(Bearer Token)

## Endpoints

The following endpoints are available:

- Authentication:
  - POST /api/login
  - POST /api/register
  - POST /api/logout
  - POST /api/refresh-token

- Medication Inventory Management:
  - GET /api/medications
  - POST /api/medications
  - GET /api/medications/{id}
  - PUT /api/medications/{id}
  - DELETE /api/medications/{id}

- Customer Record Management:
  - GET /api/customers
  - POST /api/customers
  - GET /api/customers/{id}
  - PUT /api/customers/{id}
  - DELETE /api/customers/{id}


## Postman Testing

You can use the provided Postman collection for testing the API endpoints.

Email: admin@admin.com, Password: password    (Admin)
