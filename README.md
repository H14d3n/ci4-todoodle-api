# ci4-todoodle-api

This repository contains the backend RESTful API for the "todoodle" todo list application, built with [CodeIgniter 4](https://codeigniter.com/). It provides endpoints for managing TODO tasks and categories, with features like API key authentication, logging, and data validation.

---

## Features

- RESTful API for managing Todo's and categories
- Data exchange via JSON
- Input and URL parameter validation
- Pagination, sorting, and filtering support
- API key authentication for Todos (via URL or HTTP header)
- Logging of all API requests
- Categories can only be deleted if no TODOs are assigned
- JWT authentication for Categories
- Database migrations and seeders included
- Unit and integration tests with PHPUnit

---

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL or compatible database
- PHP extensions: intl, mbstring, json, mysqlnd, (optional: libcurl for HTTP\CURLRequest)

---

## Installation

1. **Clone the repository**

   ```sh
   git clone https://github.com/h14d3n/ci4-todoodle-api.git

   cd ci4-todoodle-api/src
   ```

2. **Install dependencies**

   ```sh
   composer install
   ```

3. **Environment setup**

   Copy the example environment file and adjust settings:

   ```sh
   cp env .env
   ```

   Edit `.env` and set your database credentials and `baseURL`.

4. **Database setup**

   - Create a new database for the project.
   - Run the migrations to create tables:

     ```sh
     php spark migrate
     ```

   - (Optional) Seed the database with initial data:

     ```sh
     php spark db:seed
     ```

5. **Set writable permissions**

   Ensure the `writable/` directory is writable by your web server.

6. **Configure your web server**

   Point your web server's document root to the `public/` directory inside `src/`.

   Example for PHP's built-in server:

   ```sh
   php spark serve
   ```

   The API will be available at `http://localhost:8080/`.

---

## API Usage

### Authentication

- Every request for **todos** must include a valid API key, either as a URL parameter (`?key=YOUR_API_KEY`) or in the `X-API-KEY` HTTP header.
- Multiple API keys are supported and managed in the database.

- Every request for **categories** must include a `JWT - Bearer Token` which is sent via the HTTP Header.

### Endpoints

- `GET /api/v1/todos` - List all todos (supports `limit`, `offset`, `order_by`, `category_id`)
- `GET /api/v1/todos/{id}` - Get a single todo
- `POST /api/v1/todos` - Create a new todo
- `PUT /api/v1/todos/{id}` - Update a todo
- `DELETE /api/v1/todos/{id}` - Delete a todo

- `GET /api/v1/categories` - List all categories (supports `limit`, `offset`, `order_by`, `name`, `id`, `cID`)
- `GET /api/v1/categories/{id}` - Get a single category
- `POST /api/v1/categories` - Create a new category
- `PUT /api/v1/categories/{id}` - Update a category
- `DELETE /api/v1/categories/{id}` - Delete a category (only if no todos are assigned)

All data is exchanged as JSON.

---

## Logging

All API requests are logged for traceability. Logs are stored in the `writable/` directory.

---

## License

This project is licensed under the GNU General Public License v3.0. See [LICENSE](../LICENSE) for details.

---

## Further Information

- [CodeIgniter 4 User Guide](https://codeigniter.com/user_guide/)
- [Frontend Repository](https://github.com/h14d3n/todoodle)
- [Backend Repository](https://github.com/h14d3n/ci4-todoodle-api)

---