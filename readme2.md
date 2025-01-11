I have hr management website 
There is a website with bootstrap 5.3 and mysql database

Site flow:

1. index.php
2. login.php ["email", "password"]
3. dashboard.php ["punch in", "punch out", "total time display for today"]
4. task.php (User will write title and description above what work he did for today)
5. leave.php (How many leave they got, paid leave and emergency leave etc)
6. profile.php (User will complete their profile)

For Admins: /admin

1. admin/dashboard.php
2. admin/employees.php [list of all employees in table, name, number and button for view more]
3. admin/emp.php?id=[id] detailed information for that employee
4. admin/form for adding new employee [newemployee.php]
5. admin/tasks.php [able to seee all employee's sent task in list]
6. admin/leaves.php [able to see all sent leaves by employesss and manage it's status]

Components: /components

1. components/header.php
2. components/footer.php

Databse flow:

users: [id, username, email, password, mobile, age, type (admin/employee), joining_date, salery (per month), social media links (array object), created_at, updated_at]
leaves: [id, uid, start_date, end_date, reason, status (pending/approved/rejected)]
task: [id, uid, title, description, date]
time: [id, uid, time in array (['time', 'time', 'time', 'time']), date]

