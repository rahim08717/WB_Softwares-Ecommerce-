# WB Shop - Premium E-commerce Application

A full-stack E-commerce platform built with **Laravel 12**, **Vue 3**, **Inertia.js**, and **Tailwind CSS**. It features a complete Admin Panel, User Dashboard, Dynamic Role Management, and more.

## 🚀 Features

-   **Frontend:** Vue 3 (Composition API), Inertia.js, Tailwind CSS.
-   **Backend:** Laravel 12.
-   **Admin Panel:**
    -   Product, Category, Order Management.
    -   Dynamic Role & Permission (Super Admin, Manager).
    -   User Management, Sliders, Pages (About/Contact).
    -   Graphical Dashboard (Chart.js).
-   **User Features:**
    -   Add to Cart, Wishlist, Checkout.
    -   Order Tracking System.
    -   User Dashboard & Invoice Download.
    -   Product Reviews & Ratings.
-   **Localization:** Multi-language support (English, Bangla, etc.).

## 🛠 Prerequisites

Make sure you have the following installed:
-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL

## 📦 Installation Guide

Follow these steps to run the project locally:

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/rahim08717/WB_Softwares-Ecommerce-.git](https://github.com/rahim08717/WB_Softwares-Ecommerce-.git)
    cd WB_Softwares-Ecommerce-
    ```

2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies:**
    ```bash
    npm install
    ```

4.  **Environment Setup:**
    -   Copy the `.env` file:
        ```bash
        cp .env.example .env
        ```
    -   Open `.env` and set your Database credentials:
        ```
        DB_DATABASE=wb_shop
        DB_USERNAME=root
        DB_PASSWORD=
        ```

5.  **Generate App Key:**
    ```bash
    php artisan key:generate
    ```

6.  **Migrate Database & Seed Data:**
    *(This will create tables and insert dummy data + admin user)*
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Run Frontend Build:**
    ```bash
    npm run build
    ```

8.  **Start the Server:**
    ```bash
    php artisan serve
    ```

## 🔑 Login Credentials

-   **Admin Email:** `mywbsoft@gmail.com`
-   **User Email:** `user@gmail.com`
-   **Password:** `password` (for both)

## 📸 Screenshots
*(I can add screenshots here later)*

---
Developed by **Md. Abdur Rahim**.
