# 🏥 IITG Hospital Management System

A web-based hospital management portal developed as part of a group project at **Indian Institute of Technology Guwahati (IITG)**. The system facilitates medical services for students, faculty, and staff with secure role-based access and streamlined workflows.

## 📌 Project Overview

This application is designed to automate and enhance hospital operations like:

- Appointment scheduling
- Inventory management
- Prescription and test handling
- Billing system
- Role-based dashboards

## 🔧 Tech Stack

- **Frontend:** HTML5, CSS3, Vanilla JavaScript  
- **Backend:** PHP 8.1  
- **Database:** MySQL 8.0  
- **Server:** Apache 2.4  
- **Security:** SHA-256 hashing, prepared statements

---

## 🚀 Getting Started

Follow these steps to run the project on your local machine:

### ✅ Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) (PHP, Apache, MySQL)
- Code editor like [VS Code](https://code.visualstudio.com/)

### 🛠️ Installation Steps

1. **Download and Install XAMPP**  
   - Start **Apache** and **MySQL** from the XAMPP control panel.

2. **Clone or Download this Repository**  
   - Place the project folder inside the `htdocs` directory (usually `C:\xampp\htdocs` on Windows).

3. **Import the Database**  
   - Open **phpMyAdmin** (usually at [http://localhost/phpmyadmin](http://localhost/phpmyadmin))
   - Create a new database (e.g., `hospital_db`)
   - Import the `dbqueries.sql` file included in the repository to create the necessary tables.

4. **Configure Database Connection**  
   - Open `db.php` in your code editor
   - Update the database name, username, and password if necessary:
     ```php
     $conn = new mysqli('localhost', 'root', '', 'hospital_db');
     ```

5. **Run the Application**  
   - Open your browser and go to: [http://localhost/your-folder-name/index.php](http://localhost/your-folder-name/index.php)

---

## 🧪 Testing & Validation

- 1000 iterations of prescription validation
- 50-user concurrent booking simulations
- Inventory consistency and role-based access tests

## 📈 Future Scope

- Mobile application version
- AI-powered diagnostic assistant
- Advanced analytics and reporting

## 📄 References

- [PHP Documentation](https://www.php.net/manual/en/)
- [MySQL 8.0 Reference Manual](https://dev.mysql.com/doc/)

---

🔒 All data is handled with security best practices.  
📅 Last updated: April 30, 2025
