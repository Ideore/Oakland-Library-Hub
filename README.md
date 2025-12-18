# 📚 Oakland Library Hub

A modern, comprehensive library management system built with Laravel 11 and Tailwind CSS. This system provides a complete solution for managing books, members, borrowing activities, and library operations with an intuitive admin dashboard and user-friendly interface.

![Oakland Library Hub](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css)

## ✨ Features

### 📊 Admin Dashboard
- **Data Analytics** with Chart.js visualizations
- **Real-time Statistics** (Total books, borrowed books, active members)
- **Book Activity Pie Chart** showing borrowed, overdue, returned late, and returned books
- **7-day Borrowing Trends** with bar charts
- **Clean, Modern UI** with consistent spacing and professional design

### 📖 Lending System
- **Book Lending** with member ID lookup
- **Return Date Management** with automatic calculations
- **Overdue Tracking** with visual indicators
- **Return Processing** with late return detection

### 📋 Book Activity Tracking
- **Comprehensive Status System**:
  - 🔵 **Borrowed** - Currently borrowed books
  - 🔴 **Overdue** - Books past their return date
  - 🟡 **Returned Late** - Books returned after due date
  - 🟢 **Returned** - Books returned on time
- **Filtering & Search** by status, member, or book


## 🔑 Default Accounts

### Admin Account
- **Email**: `admin@library.com`
- **Password**: `password`
- **Access**: Full system administration

## 🔧 Development

### Running in Development Mode
```bash
# Start Laravel development server
php artisan serve

# Start Vite development server (in another terminal)
npm run dev

# Or run both simultaneously
composer run dev