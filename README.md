Here's a sample README for your project that you can use to post on GitHub:

---

# Attendance API - Laravel RESTful API

This is a simple Laravel-based RESTful API for managing employee attendance. The API provides functionality for user registration, login, and CRUD operations on attendance records. The API also supports authentication using Laravel Sanctum and includes the ability to generate dummy data using Laravel's Faker library.

## Features
- **User Registration**: Allows users to register with a name, email, and password.
- **User Login**: Users can log in with email and password to obtain an authentication token.
- **Attendance CRUD**: Perform Create, Read, Update, and Delete operations on attendance records.
- **Sanctum Authentication**: Secure the API with Bearer Token authentication using Laravel Sanctum.
- **Dummy Data Generation**: The API includes functionality for generating dummy data (attendances and users) using Faker.

## Installation

Follow these steps to set up the project locally:

### 1. Clone the Repository

First, clone the repository to your local machine:

```bash
git clone https://github.com/your-username/attendance-api.git
cd attendance-api
```

### 2. Install Dependencies

Make sure you have [Composer](https://getcomposer.org/) installed. Then, install the project's dependencies by running:

```bash
composer install
```

### 3. Set Up the Environment

Create a `.env` file by copying the `.env.example` file:

```bash
cp .env.example .env
```

### 4. Configure the Database

Update your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=attendance_db
DB_USERNAME=root
DB_PASSWORD=
```

Make sure to create the database (e.g., `attendance_db`) in MySQL or your preferred database system.

### 5. Generate the Application Key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### 6. Run Migrations

Run the database migrations to set up the necessary tables:

```bash
php artisan migrate
```

### 7. Seed the Database (Optional)

If you want to seed the database with dummy data, use the following command:

```bash
php artisan db:seed
```

This will create users and attendance records using the factory and Faker.

Serve the Application

Now, you can serve the application using the built-in Laravel development server:

```bash
php artisan serve
```

The API will be accessible at `http://127.0.0.1:8000`.

---

## API Endpoints

### **POST /api/register**

Register a new user.

**Request:**
```json
{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "message": "User registered successfully.",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com"
  }
}
```

---

### **POST /api/login**

Log in and receive an authentication token.

**Request:**
```json
{
  "email": "johndoe@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "message": "Login successful.",
  "access_token": "your-token-here"
}
```

---

### **GET /api/user**

Get the authenticated user's details (requires authentication).

**Response:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "johndoe@example.com"
}
```

---

### **Attendance CRUD Operations (Requires Authentication)**

#### **GET /api/attendances**

Retrieve a list of all attendance records.

**Response:**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "attendance_date": "2024-12-01",
    "status": "present"
  },
  ...
]
```

#### **POST /api/attendances**

Create a new attendance record.

**Request:**
```json
{
  "attendance_date": "2024-12-02",
  "status": "absent"
}
```

**Response:**
```json
{
  "message": "Attendance created successfully.",
  "attendance": {
    "id": 2,
    "user_id": 1,
    "attendance_date": "2024-12-02",
    "status": "absent"
  }
}
```

#### **PUT /api/attendances/{id}**

Update an existing attendance record.

**Request:**
```json
{
  "attendance_date": "2024-12-03",
  "status": "late"
}
```

**Response:**
```json
{
  "message": "Attendance updated successfully.",
  "attendance": {
    "id": 2,
    "user_id": 1,
    "attendance_date": "2024-12-03",
    "status": "late"
  }
}
```

#### **DELETE /api/attendances/{id}**

Delete an attendance record.

**Response:**
```json
{
  "message": "Attendance deleted successfully."
}
```

---

## Contributing

If you would like to contribute to this project, feel free to fork the repository, create a new branch, and submit a pull request with your changes. Please make sure to follow the code style and write tests for any new features.

## License

This project is open-source and available under the [MIT License](LICENSE).

---

Let me know if you need further adjustments or additional details!
