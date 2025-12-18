# 📚 Oakland Library Hub

A modern, comprehensive library management system built with Laravel 11 and Tailwind CSS. This system provides a complete solution for managing books, members, borrowing activities, and library operations with an intuitive admin dashboard and user-friendly interface.

![Oakland Library Hub](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=for-the-badge&logo=mysql)

## ✨ Features

### 🔐 Authentication & Authorization
- **Secure Login System** with fail-safe protection against spam
- **Role-based Access Control** (Admin & Member roles)
- **Dark/Light Theme Toggle** with persistent preferences
- **Responsive Design** for all devices

### 📊 Admin Dashboard
- **Interactive Analytics** with Chart.js visualizations
- **Real-time Statistics** (Total books, borrowed books, active members)
- **Book Activity Pie Chart** showing borrowed, overdue, returned late, and returned books
- **7-day Borrowing Trends** with bar charts
- **Clean, Modern UI** with consistent spacing and professional design

### 📚 Book Management
- **Complete CRUD Operations** (Create, Read, Update, Delete)
- **Book Information** (Title, Author, ISBN, Description, Available Copies)
- **Real-time Search & Filtering** with pagination
- **Duplicate Prevention** with validation
- **Form Spam Protection** with disabled buttons during submission

### 👥 Member Management
- **Member Registration & Profile Management**
- **Unique ID System** with duplicate prevention
- **Contact Information** (Name, Address, Email, Phone)
- **Borrowing History** tracking
- **Active Borrowings** counter
- **Advanced Validation** with real-time error display

### 📖 Lending System
- **Book Lending** with member ID lookup
- **Return Date Management** with automatic calculations
- **Overdue Tracking** with visual indicators
- **Return Processing** with late return detection
- **Borrowing History** with detailed records

### 📋 Book Activity Tracking
- **Comprehensive Status System**:
  - 🔵 **Borrowed** - Currently borrowed books
  - 🔴 **Overdue** - Books past their return date
  - 🟡 **Returned Late** - Books returned after due date
  - 🟢 **Returned** - Books returned on time
- **Filtering & Search** by status, member, or book
- **Detailed Activity Logs** with timestamps

### ⚙️ System Settings
- **Library Configuration** management
- **System Preferences** with persistent storage
- **Admin Controls** for system-wide settings

## 🛠️ Technology Stack

### Backend
- **Laravel 11** - Modern PHP framework
- **PHP 8.2+** - Latest PHP features
- **MySQL 8.0+** - Reliable database system
- **Eloquent ORM** - Database relationships and queries

### Frontend
- **Tailwind CSS 3.4** - Utility-first CSS framework
- **Chart.js** - Interactive data visualizations
- **Axios** - HTTP client for AJAX requests
- **Flowbite** - UI components
- **ApexCharts** - Advanced charting library

### Development Tools
- **Vite** - Fast build tool and dev server
- **Laravel Pint** - Code style fixer
- **Prettier** - Code formatter with Blade support
- **Concurrently** - Run multiple commands simultaneously

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL 8.0+

### Step-by-Step Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/naufaljct48/library.git
   cd library
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   
   Update your `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=library_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build Frontend Assets**
   ```bash
   npm run build
   ```

8. **Start the Development Server**
   ```bash
   php artisan serve
   ```

   Access the application at `http://127.0.0.1:8000`

## 🔑 Default Accounts

### Admin Account
- **Email**: `admin@admin.com`
- **Password**: `password`
- **Access**: Full system administration

### Member Account
- **Email**: `test@example.com`
- **Password**: `password`
- **Access**: Member portal (if implemented)

## 📱 User Interface

### Design Principles
- **Modern & Clean** - Professional appearance with consistent styling
- **Responsive Design** - Works seamlessly on desktop, tablet, and mobile
- **Dark/Light Themes** - User preference with system detection
- **Accessibility** - WCAG compliant with proper focus states
- **Intuitive Navigation** - Clear menu structure and breadcrumbs

### Color Scheme
- **Primary**: `#2bf8bd` (Signature teal/cyan)
- **Success**: `#34d399` (Emerald green)
- **Warning**: `#fbbf24` (Warm amber)
- **Error**: `#f87171` (Soft coral red)
- **Dark Mode**: Consistent with modern dark UI standards

## 🔧 Development

### Running in Development Mode
```bash
# Start Laravel development server
php artisan serve

# Start Vite development server (in another terminal)
npm run dev

# Or run both simultaneously
composer run dev
```

### Code Style
```bash
# Format PHP code
./vendor/bin/pint

# Format frontend code
npm run format
```

### Database Operations
```bash
# Fresh migration with seeders
php artisan migrate:fresh --seed

# Clear all caches
php artisan optimize:clear
```

## 📊 Database Schema

### Core Tables
- **users** - System users (admin/member authentication)
- **members** - Library member profiles
- **books** - Book catalog with inventory
- **borrowings** - Lending transactions and history

### Key Relationships
- Members have many borrowings
- Books have many borrowings
- Borrowings belong to members and books

## 🛡️ Security Features

- **CSRF Protection** on all forms
- **SQL Injection Prevention** via Eloquent ORM
- **Input Validation** with custom error messages
- **Unique Constraints** on critical fields
- **Form Spam Protection** with button disabling
- **Session Management** with secure cookies

## 🚀 Performance Optimizations

- **Eager Loading** to prevent N+1 queries
- **Database Indexing** on frequently queried fields
- **Asset Optimization** with Vite bundling
- **Caching Strategy** for static data
- **Pagination** for large datasets

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## 📦 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Configure production database
4. Run `composer install --optimize-autoloader --no-dev`
5. Run `npm run build`
6. Run `php artisan config:cache`
7. Run `php artisan route:cache`
8. Run `php artisan view:cache`

### Server Requirements
- PHP 8.2+
- MySQL 8.0+
- Nginx/Apache
- SSL Certificate (recommended)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Write tests for new features

## 🐛 Troubleshooting

### Common Issues

**Migration Errors**
```bash
php artisan migrate:refresh --seed
php artisan cache:clear
php artisan config:clear
```

**Permission Issues**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Asset Issues**
```bash
npm run build
php artisan view:clear
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework Team
- Tailwind CSS Team
- Chart.js Contributors
- Flowbite UI Components
- All contributors and testers

## 📞 Support

For support, email [support@oaklandlibraryhub.com](mailto:support@oaklandlibraryhub.com) or create an issue on GitHub.

---

**Made with ❤️ for modern library management**