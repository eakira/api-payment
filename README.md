# API Payment

This project is a payment API that allows managing financial transactions between accounts.


## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Testing](#testing)
- [Contribution](#contribution)
- [License](#license)

## Features

- Create, update
- Make deposits and withdrawals
- Transfer funds between accounts
- Query balance and transaction history
- RESTful API

## Technologies Used

- [Laravel](https://laravel.com) - PHP Framework
- [MySQL](https://www.mysql.com/) - Database Management System
- [Docker](https://www.docker.com/) - Containers for development and production
- [Redis](https://redis.io/) - Caching storage

## Installation

1. Clone the repository:

   ```bash
   git clone git@github.com:eakira/api-payment.git
   cd api-payment
   ```

2. Start the application using Docker Compose:

   ```bash
   docker-compose up
   ```

3. To enter the Docker container, use the following command:

   ```bash
   docker exec -it api-payment-php bash
   ```

3. Create an `.env` file from the `.env.example` file:

   ```bash
   cp .env.example .env
   ```

4. Generate a new application key:

   ```bash
   php artisan key:generate
   ```

5. Configure the database credentials in the `.env` file.

6. Run the migrations:

   ```bash
   php artisan migrate
   ```

## Configuration

To use the API, you may need to perform some additional configurations, such as:

- Set up Redis for caching.
- Define the necessary permissions for the `storage` and `bootstrap/cache` directories.

## Usage

The API can be accessed at the following routes:

- `POST /api/events` - Create a new account
```json
{
    "type": "deposit",
    "destination": 100,
    "amount": 200
}
```

- `GET /api/balance?account_id=100` - Retrieve account details
- `POST /api/event` - Make a deposit
```json
{
    "type": "deposit",
    "destination": 100,
    "amount": 200
}
```

- `POST /api/event` - Make a withdrawal
```json
{
    "type": "withdraw",
    "destination": 100,
    "amount": 200
}
```

- `POST /api/event` - Transfer funds between accounts
```json
{
    "type":"transfer", 
    "origin": 100,
    "destination": 200, 
    "amount": 15
}
```

## Testing

To run the tests, use the following command:

```bash
php artisan test
```