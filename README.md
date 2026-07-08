# 💼 Job Portal API

A professional Job Portal Backend built with Laravel.

The project allows companies to publish jobs, users to apply, and administrators to manage the entire hiring process.

---

# 🚀 Features

## Authentication

- User Registration
- Login
- Logout
- Laravel Sanctum Authentication
- Protected API Routes

---

## Companies

- Create Company
- Update Company
- Delete Company
- Show Company
- Company Owner Authorization
- Soft Delete

---

## Jobs

- Create Job
- Update Job
- Delete Job
- Search Jobs
- Filter Jobs
- Salary Support
- Location Support
- Soft Delete

---

## Applications

- Apply for Job
- Upload CV
- Track Status
- Application Processing
- Soft Delete

---

## Notifications

Email notification is sent when:

- Application Status Updated

---

## Events & Listeners

Project uses Laravel Events for:

- User Registration
- Job Registration
- Company Registration

Listeners are responsible for:

- Logging
- Flash Messages
- Queue Processing

---

## Authorization

Laravel Policies are used to secure:

- Applications
- Companies
- Jobs

Only owners are allowed to update or delete their resources.

---

## API Resources

The project uses Laravel API Resources for:

- User Resource
- Company Resource
- Job Resource
- Application Resource

---

## Validation

Laravel Form Request Validation is used for all incoming requests.

---

## Testing

The project includes:

- Unit Tests
- Feature Tests

Coverage includes:

- User Relationships
- Company CRUD
- Job Relationships
- Applications
- Authorization

---

## Documentation

Swagger Documentation included.

Postman Collection included.

---

# 🛠 Built With

- Laravel 12
- PHP 8.3+
- MySQL
- Laravel Sanctum
- Swagger
- PHPUnit
- Postman

---

# Database Design

## Tables

- users
- companies
- job_listings
- applications
- personal_access_tokens
- sessions

---

# Relationships

User

- Has One Company
- Has Many Jobs
- Has Many Applications

Company

- Belongs To User
- Has Many Jobs

Job

- Belongs To User
- Belongs To Company
- Has Many Applications

Application

- Belongs To User
- Belongs To Job

---

# ER Diagram

```

docs/ERD/https://github.com/Yoe2004-25/laravel-job-board/blob/main/docu/ERD.png

```

Example

<img src="https://github.com/Yoe2004-25/laravel-job-board/blob/main/docu/ERD.png">

---

# API Documentation

Swagger

```

http://localhost/documentation

```

---

# API Endpoints

## Authentication

| Method | Endpoint |
|---------|----------|
| POST | /api/register |
| POST | /api/login |
| POST | /api/logout |
| GET | /api/user |

---

## Companies

| Method | Endpoint |
|---------|----------|
| GET | /api/companies |
| POST | /api/companies |
| GET | /api/companies/{id} |
| PUT | /api/companies/{id} |
| DELETE | /api/companies/{id} |

---

## Jobs

| Method | Endpoint |
|---------|----------|
| GET | /api/jobs |
| POST | /api/jobs |
| GET | /api/jobs/{id} |
| PUT | /api/jobs/{id} |
| DELETE | /api/jobs/{id} |

---

## Applications

| Method | Endpoint |
|---------|----------|
| GET | /api/applications |
| POST | /api/applications |
| GET | /api/applications/{id} |
| PUT | /api/applications/{id} |
| DELETE | /api/applications/{id} |

---

# Installation

Clone repository

```bash
git clone https://github.com/YourUsername/job-portal-api.git
```

Install packages

```bash
composer install
```

Copy environment

```bash
cp .env.example .env
```

Generate key

```bash
php artisan key:generate
```

Configure database

```
DB_DATABASE=job
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations

```bash
php artisan migrate
```

Run seeders

```bash
php artisan db:seed
```

Start server

```bash
php artisan serve
```

---

# Testing

Run Feature Tests

```bash
php artisan test
```

or

```bash
php artisan test --testsuite=Feature
```

Run Unit Tests

```bash
php artisan test --testsuite=Unit
```

---

# Project Structure

```

app/
├── Events
├── Listeners
├── Notifications
├── Policies
├── Http
│ ├── Controllers
│ ├── Requests
│ ├── Resources
├── Models

database/
├── factories
├── migrations
├── seeders

tests/
├── Feature
├── Unit

```

---

# Included Files

- ✔ ER Diagram

- ✔ SQL Script

- ✔ Swagger Documentation

- ✔ Postman Collection

- ✔ Factories

- ✔ Seeders

- ✔ Unit Tests

- ✔ Feature Tests

---

# Future Improvements

- Email Verification

- Password Reset

- Company Dashboard

- Admin Dashboard

- Role & Permission

- Search with Laravel Scout

- Queue Workers

- Docker Support

- CI/CD Pipeline

---

# Author

**Youssif Ahmed**

Backend Laravel Developer

GitHub

https://github.com/Yoe2004-25

LinkedIn

(Add your LinkedIn here)

Email

(Add your Email here)
