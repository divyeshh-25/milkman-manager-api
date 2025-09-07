# 🥛 Milkman Manager API

REST API for milk delivery management system. Handle customers, daily deliveries, billing, and payments for small dairy businesses.

## ✨ Features

- **Customer Management**: Add, edit, and manage 100-200+ customers with milk preferences
- **Daily Delivery Tracking**: Record daily milk deliveries with quantity adjustments
- **Automated Billing**: Generate monthly bills automatically from delivery data
- **Payment Processing**: Track payments with multiple methods (Cash/UPI/Bank Transfer)
- **Multiple Milk Types**: Support for Cow, Buffalo, Mix with different rates
- **Mobile-Friendly**: Optimized for mobile delivery updates
- **JWT Authentication**: Secure API access with role-based permissions

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+ (depending on implementation)
- SQLite (development) / MySQL/PostgreSQL (production)

### Installation

```bash
# Clone the repository
git clone https://github.com/divyeshh-25/milkman-manager-api
cd milkman-manager-api

# Install dependencies
composer install

# Environment setup
cp .env.example .env
# Update database credentials in .env

# Database setup
php artisan migrate

# Seed sample data
php artisan db:seed

# Start development server
php artisan serve
```

## 📋 API Endpoints

### Authentication
```
POST   /api/auth/register    # Register new user
POST   /api/auth/login       # User login
POST   /api/auth/logout      # User logout
GET    /api/auth/me          # Get current user
```

### Customers
```
GET    /api/customer        # List all customers
POST   /api/customer        # Create new customer
GET    /api/customer/{id}   # Get customer details
PUT    /api/customer/{id}   # Update customer
DELETE /api/customer/{id}   # Delete customer
GET    /api/customer/search?q={query}  # Search customers
```

### Milk Types
```
GET    /api/milk-type       # List all milk types
POST   /api/milk-type       # Create milk type
PUT    /api/milk-type/{id}  # Update milk type
DELETE /api/milk-type/{id}  # Delete milk type
```

### Daily Deliveries
```
GET    /api/deliverie?date={YYYY-MM-DD}  # Get deliveries for date
POST   /api/deliverie                    # Record delivery
PUT    /api/deliverie/{id}               # Update delivery
DELETE /api/deliverie/{id}               # Delete delivery
POST   /api/deliverie/bulk               # Bulk delivery update
GET    /api/deliverie/customer/{id}      # Customer delivery history
```

### Bills
```
GET    /api/bill?month={YYYY-MM}         # Get bills for month
POST   /api/bill/generate?month={YYYY-MM} # Generate monthly bills
GET    /api/bill/{id}                    # Get bill details
GET    /api/bill/{id}/pdf                # Download bill PDF
POST   /api/bill/{id}/send-whatsapp      # Send bill via WhatsApp
```

### Payments
```
GET    /api/payment                      # List payments
POST   /api/payment                      # Record payment
GET    /api/payment/customer/{id}        # Customer payment history
PUT    /api/payment/{id}                 # Update payment
```

### Dashboard & Reports
```
GET    /api/dashboard/stats               # Dashboard statistics
GET    /api/report/revenue?start_date={date}&end_date={date}  # Revenue report
GET    /api/report/pending-payments      # Pending payments report
GET    /api/report/delivery-summary?month={YYYY-MM}  # Delivery summary
```

## 📊 Database Schema

### Key Tables
- **milk_types**: Different milk varieties and rates
- **customers**: Customer information and preferences
- **deliveries**: Daily delivery records
- **bills**: Monthly billing information
- **bill_items**: Detailed bill breakdown by milk type
- **payments**: Payment tracking and history

## 🔧 Configuration

### Environment Variables
```env
# Database
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# App Settings
APP_NAME="Milkman Manager"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:3000

# Email (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587

```

## 💡 Future Enhancements

- [ ] Multi-tenant SaaS architecture
- [ ] WhatsApp Business API integration
- [ ] Advanced analytics and reporting
- [ ] Mobile app with offline sync
- [ ] Inventory management for dairy suppliers
- [ ] Route optimization for deliveries
- [ ] Subscription billing models

## 📞 Support

- 📧 Email: divyeshcodes@gmail.com
- 🐛 Issues: [GitHub Issues](https://github.com/divyeshh-25/milkman-manager-api/issues)

---

**Made with ❤️ for small dairy businesses in India**