# Pharmacy Management System

This project is built with Laravel for managing a pharmacy's business processes including authentication, medication inventory management, and customer management.

## Getting Started

To run this project locally, follow these steps:

### Prerequisites

- PHP >= 7.4
- Composer
- SQLite (or any other supported database by Laravel)

### Installation

1. Clone this repository:
2. Navigate to the project directory:
3. run composer install to Install dependencies:
4. Copy the .env.example file to .env:
5. Update the database settings in the .env file.
7. Migrate the database:
8. Seed the database with mock data:


### Running the Server

To start the Laravel development server, run the following command:
php artisan serve


The API will be accessible at http://localhost:8000 by default.

## Endpoints

The following endpoints are available:

- Authentication:
  - POST /api/login
  - POST /api/register

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
