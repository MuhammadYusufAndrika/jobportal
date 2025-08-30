# Loker Oku Timur - Job Vacancy Website

A comprehensive job vacancy website built with Laravel 10, Filament 3, and TailwindCSS specifically designed for the Ogan Komering Ulu Timur region.

## Features

### 🎯 Core Features
- **Modern Job Listings**: Beautiful, responsive job cards with search and filtering
- **Advanced Search**: Search by title, company, location, and salary range
- **Custom Application Forms**: Companies can create unique application forms for each job
- **Role-based Access Control**: Three user roles (Admin, Company, User) with different permissions
- **Real-time Applications**: Users can apply directly through custom forms
- **Mobile-First Design**: Fully responsive design optimized for all devices

### 👥 User Management
- **Admin Role**: 
  - Manage all users and change their roles
  - Oversight of all job postings and applications
  - Full system administration capabilities
- **Company Role**: 
  - Post and manage job vacancies
  - Create custom application forms with various field types
  - View and manage applications for their jobs
- **User Role**: 
  - Browse and search job listings
  - Apply to jobs through custom forms
  - Track application status

### 💼 Job Management
- **Rich Job Postings**: Title, company, location, description, salary, and deadline
- **Location Filter**: Limited to 20 districts in Ogan Komering Ulu Timur
- **Custom Forms**: Support for text, email, number, textarea, select, file upload, and checkbox fields
- **Application Tracking**: Companies can view all applications with submitted form data

## Tech Stack

- **Backend**: Laravel 10
- **Admin Panel**: Filament 3
- **Frontend**: TailwindCSS + Blade Templates
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission
- **Database**: MySQL
- **File Storage**: Laravel Storage

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL

### Step 1: Create Laravel Project
```bash
composer create-project laravel/laravel loker-oku-timur
cd loker-oku-timur
```

### Step 2: Install Dependencies
```bash
# Install Filament
composer require filament/filament:"^3.0"
php artisan filament:install --panels

# Install Spatie Permission
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Install Laravel Breeze for authentication
composer require laravel/breeze --dev
php artisan breeze:install blade
```

### Step 3: Database Setup
1. Create a MySQL database named `loker_oku_timur`
2. Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loker_oku_timur
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 4: Create Models and Migrations
```bash
# Create models with migrations
php artisan make:model Job -m
php artisan make:model JobApplication -m
php artisan make:model ApplicationForm -m

# Create seeders
php artisan make:seeder RoleSeeder
php artisan make:seeder UserSeeder

# Create Filament resources
php artisan make:filament-resource Job
php artisan make:filament-resource User
php artisan make:filament-resource JobApplication

# Create controllers
php artisan make:controller HomeController
php artisan make:controller JobController
```

### Step 5: Copy Project Files
Copy all the provided files to their respective locations in your Laravel project:

- Models: `app/Models/`
- Migrations: `database/migrations/`
- Seeders: `database/seeders/`
- Filament Resources: `app/Filament/Resources/`
- Controllers: `app/Http/Controllers/`
- Views: `resources/views/`
- Routes: `routes/web.php`
- Providers: `app/Providers/`

### Step 6: Run Migrations and Seed Data
```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

### Step 7: Install Frontend Dependencies
```bash
npm install && npm run build
```

### Step 8: Start Development Server
```bash
php artisan serve
```

## Default User Accounts

After running the seeder, you'll have these default accounts:

### Admin Account
- **Email**: admin@lokerokuTimur.com
- **Password**: password
- **Role**: Admin

### Company Account
- **Email**: company@example.com
- **Password**: password
- **Role**: Company

### Regular User Account
- **Email**: user@example.com
- **Password**: password
- **Role**: User

## Usage Guide

### For Administrators
1. Login to `/admin` with admin credentials
2. Manage users in **User Management** section
3. Change user roles from "user" to "company" as needed
4. Monitor all job postings and applications

### For Companies
1. Register a new account (will be assigned "user" role by default)
2. Contact admin to upgrade role to "company"
3. Login to `/admin` to access company dashboard
4. Create job postings with custom application forms
5. View and manage applications for your jobs

### For Job Seekers
1. Browse jobs on the homepage
2. Use search and filters to find relevant positions
3. Register and login to apply for jobs
4. Fill out custom application forms for each position

## File Structure

```
app/
├── Filament/
│   └── Resources/
│       ├── JobResource.php
│       ├── UserResource.php
│       └── JobApplicationResource.php
├── Http/Controllers/
│   ├── HomeController.php
│   └── JobController.php
├── Models/
│   ├── User.php
│   ├── Job.php
│   ├── JobApplication.php
│   └── ApplicationForm.php
└── Providers/
    ├── AppServiceProvider.php
    ├── EventServiceProvider.php
    └── Filament/AdminPanelProvider.php

database/
├── migrations/
└── seeders/
    ├── RoleSeeder.php
    ├── UserSeeder.php
    └── DatabaseSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php
├── jobs/
│   └── show.blade.php
└── home.blade.php

routes/
└── web.php
```

## Locations Supported

The system supports all 20 districts in Ogan Komering Ulu Timur:

1. Buay Madang
2. Belitang
3. Belitang II
4. Belitang III
5. Semendawai Suku III
6. Semendawai Timur
7. Buay Pemuka Peliung
8. Cempaka
9. Buay Pemuka Bangsa Raja
10. Buay Sandang Aji
11. Madang Suku I
12. Madang Suku II
13. Madang Suku III
14. Semendawai Barat
15. Bunga Mayang
16. Buay Madang Timur
17. Lambu Kibang
18. Belitang Jaya
19. Belitang Madang Raya
20. Belitang Mulya

## Application Form Field Types

Companies can create forms with these field types:
- **Text**: Single line text input
- **Email**: Email address input
- **Number**: Numeric input
- **Textarea**: Multi-line text input
- **Select**: Dropdown with custom options
- **File**: File upload (CV, documents, etc.)
- **Checkbox**: Yes/no or agreement fields

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Security

If you discover any security vulnerabilities, please send an e-mail to the development team.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, email support@lokerokuTimur.com or create an issue in the repository.

---

**Built with ❤️ for Ogan Komering Ulu Timur community**