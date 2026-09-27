
# AgroBd - Agricultural E-Commerce Platform

**Project Start Date:** May 1, 2026

## Overview

AgroBd is a modern web-based platform designed to revolutionize agricultural commerce by connecting farmers, retailers, and buyers directly. The platform addresses the critical issue where farmers and retailers often struggle to get fair prices for their produce.

## Problem Statement

At present, farmers and retailers do not get the right price for their produce. With this problem in mind, we want to create a social media medium where buyers and sellers can buy and sell independently.

## Solution & Features

- **Farmer Profiles:** Farmers will have their own profiles with rating information
- **Product Listings:** Farmers can post sale listings of their products
- **Direct Commerce:** Buyers and retailers can purchase products directly from farmers
- **Rating System:** After transactions, parties can rate each other to build trust and credibility
- **Secure Transactions:** Built with Laravel framework for secure and reliable commerce

## Technology Stack

- **Backend Framework:** Laravel 8.x
- **Frontend:** Blade Templates with Tailwind CSS & Alpine JS
- **Database:** MySQL
- **Real-time Features:** Laravel Livewire
- **Authentication:** Laravel Jetstream & Sanctum
- **Containerization:** Docker
- **CI/CD:** Jenkins Pipeline
- **API:** RESTful API with JSON responses

## Project Status

🟢 **Active Development** - Started May 1, 2026

## Installation & Setup

### Prerequisites
- PHP 7.3+ or PHP 8.0+
- Composer
- Node.js & npm
- MySQL/MariaDB
- Docker (optional)

### Quick Start

1. Clone the repository
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install Node dependencies:
   ```bash
   npm install
   ```
4. Copy environment file:
   ```bash
   cp .env.example .env
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Build frontend assets:
   ```bash
   npm run dev
   ```

## Project Structure

- `app/` - Application logic and models
- `routes/` - Route definitions (API & Web)
- `resources/` - Views and frontend assets
- `database/` - Migrations and seeders
- `config/` - Configuration files
- `public/` - Public assets and entry point

## Key Modules

- **User Management** - Registration, authentication, profiles
- **Product Management** - Listing, inventory, categories
- **Order Management** - Purchase orders, payments, tracking
- **Payment Integration** - SSLCommerz payment gateway
- **Rating & Review** - User feedback system
- **Notifications** - Email notifications

## Contact & Support

For issues or inquiries, please refer to the project documentation or contact the development team.

---

*Last Updated: April 15, 2026*
