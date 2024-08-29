<?php

/** 
 * Plugin Name: WP Employees CRUD
 * Description: This plugin performs CRUD Operations with Employees Table. Also on Activation it will create a dynamic wordpress page and it will have a shortcode
 * Version: 1.0 
 * Author: TWELVE_ZHIV
 * 
*/

// Check if abspath define to prevent direct file calling.

if (! defined('ABSPATH')) {
    exit;
}

// Define plugin dir path
define('WCE_DIR_PATH', plugin_dir_path(__FILE__));
// Define plugin url path
define('WCE_DIR_URL', plugin_dir_url(__FILE__));

// include necessary files
include_once WCE_DIR_PATH . "my_employees.php";

// Create class object

$employeeObject = new MyEmployees();

// Register the function to run on plugin activation
// 'register_activation_hook' links the plugin activation event to the 'create_table' method.
// The first argument '__FILE__' points to the main plugin file.
// The second argument specifies the method 'create_table' of the $employeeObject to execute on activation.

register_activation_hook(__FILE__, [$employeeObject, "create_table_activation_page"]);

// When the plugin is activated, this setup ensures the 'create_table' method is called
// to create the necessary database table, preparing the plugin's environment.

// Drop db table using deactivation hook 

register_deactivation_hook(__FILE__, [$employeeObject, "drop_table"]);

// register shortcode

add_shortcode('wp-employee-form', [$employeeObject, "create_employees_form"]);

// connect scripts and style files
add_action('wp_enqueue_scripts', [$employeeObject, "add_assets_to_plugin"]);


// User login
// Process Ajax request for add employee
add_action("wp_ajax_wce_add_employee", [$employeeObject, "handle_add_employee_form_data"]);
// add action to edit employee 
add_action("wp_ajax_wce_edit_employee", [$employeeObject, "handle_edit_employee_data"]);
// add action to load employees data
add_action("wp_ajax_wce_load_employees_data", [$employeeObject, "handle_load_employees_data"]);
// add action to delete employee data
add_action("wp_ajax_wce_delete_employee", [$employeeObject, "handle_delete_employee_data"]);
// add action to  get employe data for edit 
add_action("wp_ajax_wce_get_employee_data", [$employeeObject, "handle_get_employee_data"]);

// User logged out
// Process Ajax request for add employee
// add_action("wp_ajax_nopriv_wce_add_employee", [$employeeObject, "handle_add_employee_form_data"]);
// // add action to edit employee 
// add_action("wp_ajax_nopriv_wce_edit_employee", [$employeeObject, "handle_edit_employee_data"]);
// // add action to load employees data
// add_action("wp_ajax_nopriv_wce_load_employees_data", [$employeeObject, "handle_load_employees_data"]);
// // add action to delete employee data
// add_action("wp_ajax_nopriv_wce_delete_employee", [$employeeObject, "handle_delete_employee_data"]);
// // add action to  get employe data for edit 
// add_action("wp_ajax_nopriv_wce_get_employee_data", [$employeeObject, "handle_get_employee_data"]);

