# CRUD_BASED_WORDPRESS_PLUGIN
This WordPress plugin provides a comprehensive CRUD (Create, Read, Update, Delete) interface for managing employees within your WordPress site. It allows users to perform the following actions:

Create: Add new employee records, including details such as name, email, designation, and profile image.

Read: View a list of all employees with their details displayed in a table format. Each employee's record includes an ID, name, email, designation, and profile image.

Update: Edit existing employee records. Users can modify details such as name, email, designation, and profile image. The form used for editing is dynamically populated with the employee’s current information.

Delete: Remove employee records from the system. A confirmation prompt ensures that deletions are intentional.

Features:

Form Handling: Utilizes AJAX to handle form submissions without reloading the page, ensuring a smooth user experience.
Dynamic Data Loading: Uses AJAX to dynamically load and display employee data, reducing page load times and improving efficiency.
Form Validation: Implements client-side validation to ensure that all required fields are correctly filled out before submission.
Responsive Design: Ensures that the employee management interface is fully responsive and functional on all devices.
User-Friendly Interface: Provides an intuitive and easy-to-use interface for managing employee records.
How It Works:

Add Employee: Users fill out a form to input employee details and submit it via AJAX. The data is then saved to the database, and the employee list is updated.
Edit Employee: Clicking on the "Edit" button next to an employee record opens a form pre-filled with the employee’s details. Users can make changes and submit them to update the record.
Delete Employee: Clicking on the "Delete" button prompts the user to confirm the deletion. Once confirmed, the employee record is removed from the database.
View Employees: The list of employees is displayed in a table format, showing all relevant details and providing options to edit or delete records.
This plugin is ideal for businesses and organizations that need a simple yet effective way to manage employee information directly from their WordPress site.


