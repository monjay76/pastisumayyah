SMART Pasti Sumayyah System

A Digitalized Management & Student Performance Tracking System for PASTI Kindergartens.

Project Overview

SMART Pasti Sumayyah is a web-based management solution built with the Laravel framework. It is designed to bridge the gap between administrators, teachers, and parents in a kindergarten setting. The system focuses on automating student assessment reports and providing a transparent feedback channel for parents.

Key Features

-Dynamic Student Performance Module: A criteria-based grading system (Ansur Maju, Maju, Sangat Maju) tailored for various subjects   like Pra Tahfiz, Nurul Quran, and general academics.

-Smart Search & Live Filtering: An AJAX-powered filtering system that allows users to query student records by Name, MyKid ID, Class, or Subject without page reloads.

-Modern SaaS Dashboard: A clean, card-based UI/UX designed for high readability and ease of use on desktop devices.

-Interactive Parent Feedback: A streamlined communication portal for parents to submit inquiries or suggestions directly to the school management.

-Data Integrity: Robust database architecture utilizing foreign key constraints and composite unique indexes to ensure data accuracy.

Technical Stack

Backend: PHP 8.2+ with Laravel Framework.

Database: MySQL utilizing Eloquent ORM for expressive database interactions.

Frontend: Blade Templating Engine, Tailwind CSS, and JavaScript (Axios/AJAX).

Installation & Setup
1. Clone the repository
git clone https://github.com/your-username/pasti-sumayyah.git

2. Install dependancies 
composer install

3. Configure environment
cp .env.example .env
php artisan key:generate

4. Database migration & seeding
php artisan migrate --seed

5. Start the local server
php artisan serve

