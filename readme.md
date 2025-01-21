# HR Management Website Documentation

## Overview
This is a web-based HR management system built with **Bootstrap 5.3** and **MySQL**. The platform supports two types of users: employees and admins. It facilitates time tracking, task management, leave requests, and employee management.

## Features

### For Employees
1. **Index**
   - Landing page of the website.

2. **Login**
   - Endpoint: `login.php`
   - Fields: `email`, `password`

3. **Dashboard**
   - Endpoint: `dashboard.php`
   - Actions:
     - Punch In
     - Punch Out
     - Display total time worked for today.

4. **Task Management**
   - Endpoint: `task.php`
   - Functionality: Allows employees to record their daily work by providing a title and description.

5. **Leave Management**
   - Endpoint: `leave.php`
   - Functionality: Displays leave details, including paid leave and emergency leave.

6. **Profile Completion**
   - Endpoint: `profile.php`
   - Functionality: Allows employees to complete or update their profile.

### For Admins

1. **Dashboard**
   - Endpoint: `/admin/dashboard.php`

2. **Employee List**
   - Endpoint: `/admin/employees.php`
   - Functionality: Displays all employees in a table with their name, number, and a button to view more details.

3. **Employee Details**
   - Endpoint: `/admin/emp.php?id=[id]`
   - Functionality: Shows detailed information about a specific employee.

4. **Add New Employee**
   - Endpoint: `/admin/newemployee.php`
   - Functionality: Form for adding new employees.

5. **Task Management**
   - Endpoint: `/admin/tasks.php`
   - Functionality: Admins can view a list of all tasks submitted by employees.

6. **Leave Management**
   - Endpoint: `/admin/leaves.php`
   - Functionality: Allows admins to view and manage all leave requests submitted by employees.

## Components
1. **Header**
   - File: `/components/header.php`

2. **Footer**
   - File: `/components/footer.php`

## Database Structure

### Tables

#### `users`
| Column          | Type          | Description                            |
|-----------------|---------------|----------------------------------------|
| id              | INT           | Primary key                           |
| username        | VARCHAR(255)  | Employee's username                   |
| email           | VARCHAR(255)  | Employee's email                      |
| password        | VARCHAR(255)  | Employee's hashed password            |
| mobile          | VARCHAR(15)   | Employee's mobile number              |
| age             | INT           | Employee's age                        |
| type            | ENUM          | `admin` or `employee`                 |
| joining_date    | DATE          | Joining date of the employee          |
| salary          | FLOAT         | Salary (per month)                    |
| social_media    | JSON          | Social media links (array object)     |
| created_at      | TIMESTAMP     | Record creation time                  |
| updated_at      | TIMESTAMP     | Record update time                    |

#### `leaves`
| Column      | Type      | Description                            |
|-------------|-----------|----------------------------------------|
| id          | INT       | Primary key                           |
| uid         | INT       | User ID (foreign key)                 |
| start_date  | DATE      | Leave start date                      |
| end_date    | DATE      | Leave end date                        |
| reason      | TEXT      | Reason for leave                      |
| status      | ENUM      | `pending`, `approved`, `rejected`     |

#### `task`
| Column      | Type      | Description                            |
|-------------|-----------|----------------------------------------|
| id          | INT       | Primary key                           |
| uid         | INT       | User ID (foreign key)                 |
| title       | VARCHAR   | Title of the task                     |
| description | TEXT      | Task description                      |
| date        | DATE      | Date of the task                      |

#### `time`
| Column      | Type      | Description                            |
|-------------|-----------|----------------------------------------|
| id          | INT       | Primary key                           |
| uid         | INT       | User ID (foreign key)                 |
| time        | JSON      | Array of punch-in and punch-out times |
| date        | DATE      | Date of the recorded time             |

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/dhruvlathia/hr-management
   ```

2. Set up the database:
   - Import the provided SQL file (`database.sql`) into your MySQL server.

3. Configure database connection:
   - Update database credentials in the `config.php` file.

4. Start the server:
   ```bash
   php -S localhost:8000
   ```

5. Open the application:
   - Navigate to `http://localhost:8000` in your web browser.

## Usage
- Employees log in and manage their tasks, time, and leave requests.
- Admins log in to manage employees, tasks, and leave requests.

## Credits

This project was developed by **Dhruv Lathia**. 

GitHub: [Dhruv Lathia](https://github.com/dhruvlathia)

LinkedIn: [Dhruv Lathia](https://www.linkedin.com/in/dhruvlathia)

If you use this project or find it helpful, don't forget to give it a ⭐ on GitHub!

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT). Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

ADDITIONAL REQUIREMENT: If you use this software in your project, you must give
appropriate credit by mentioning the author and linking back to this repository.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

### MIT License Overview:
- **Permission**: Commercial use, modification, distribution, and private use.
- **Limitation**: No liability, warranty, or guarantee.
- **Requirement**: Include the original license in all copies or substantial portions of the software.

For more information, refer to the full license text in the `LICENSE` file.
