# WB Shop - Premium E-commerce Application

A full-stack E-commerce platform built with **Laravel 12**, **Vue 3**, **Inertia.js**, and **Tailwind CSS**. It features a complete Admin Panel, User Dashboard, Dynamic Role Management, and more.

## 🚀 Key Features

### 🌟 Frontend (User Experience)

-   **Modern UI/UX:** Fully responsive design built with Tailwind CSS, featuring a seamless Dark/Light mode toggle.
-   **SPA Experience:** Fast and smooth page transitions using Inertia.js (Single Page Application feel).
-   **Product Discovery:** Advanced search functionality, category filtering, and product details with image galleries.
-   **Shopping Experience:**
    -   AJAX-based **Add to Cart** and **Wishlist** (no page reloads).
    -   Dynamic cart management (update quantities, remove items).
-   **Checkout System:** Streamlined checkout process with order summary and payment method selection.
-   **User Dashboard:**
    -   View Order History and Status.
    -   **Download Invoices** (PDF format).
    -   Track Order status using Order ID.
    -   Manage Profile and Change Password.
-   **Localization:** Multi-language support (English, Bangla, Hindi, Spanish, Urdu).

### ⚡ Backend (Admin Panel)

-   **Dashboard Analytics:** Interactive **Charts & Graphs** (using Chart.js) showing Monthly Revenue, Order Status distribution, and Summary Cards.
-   **Product Management:** Create, edit, and delete products with image uploads, stock management, and discount pricing.
-   **Order Management:** View order details, change order status (Pending -> Processing -> Completed), and print invoices.
-   **Content Management:** Manage Homepage Sliders, Static Pages (About Us, Terms), and Categories.
-   **Communication:** View contact messages from users and **Reply via Email** directly from the admin panel.

### 🛡️ Security & Access Control (Advanced)

-   **Dynamic Role-Based Access Control (RBAC):**
    -   Powered by **Spatie Permission**.
    -   Create custom Roles (e.g., Manager, Editor).
    -   **Granular Permissions:** Assign specific permissions (e.g., `product.create`, `order.view`) to specific roles via a Group-wise UI.
-   **Authentication:** Secure Login, Registration, and Email Verification using Laravel Breeze.

---

## 🛠️ Tech Stack

-   **Backend:** PHP 8.2+, Laravel 12
-   **Frontend:** Vue.js 3, Inertia.js
-   **Styling:** Tailwind CSS, PostCSS
-   **Database:** MySQL
-   **Packages:** Spatie Permission, Chart.js, Vue-Chartjs

---

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
    _(This will create tables and insert dummy data + admin user)_

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


---

Developed by **Md. Abdur Rahim**.
