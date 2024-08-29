<?php

class MyEmployees
{



    private $wpdb;
    private $table_name;
    private $table_prefix;
    // add magic construct method which allows us to create class object.
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_prefix = $this->wpdb->prefix; // wp_
        $this->table_name = $this->table_prefix . "employees_table"; // wp_employees_table
    }

    // create db table and activation hook
    public function create_table_activation_page()
    {

        // collate is using for get coding charset 
        $collate = $this->wpdb->get_charset_collate();
        // add table prefix
        $table_prefix = $this->wpdb->prefix;
        $create_command = " CREATE TABLE `" . $this->table_name . "` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
        `email` varchar(50) DEFAULT NULL,
        `designation` varchar(50) DEFAULT NULL,
        `profile_image` varchar(220) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) " . $collate . " ";

        // The following line includes the 'upgrade.php' file from the WordPress core.
        // This file provides the 'dbDelta' function, which is a powerful tool for
        // creating or updating database tables in WordPress.
        //
        // The 'dbDelta' function can:
        // 1. Create a new table if it doesn't exist.
        // 2. Update an existing table's structure (e.g., adding new columns, changing column types) 
        //    based on the SQL command you provide.
        //
        // Using 'dbDelta' is highly recommended in WordPress development because it ensures
        // that your database tables are always in sync with your code, without the need to manually 
        // check for existing tables or make changes.
        //
        // Note: The 'dbDelta' function expects SQL commands to be well-formed, and it only supports 
        // a specific subset of SQL syntax, so be cautious when constructing your table creation queries.

        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
        dbDelta($create_command);

        // wp page
        $page_title = "Employee CRUD system";
        $page_content = "[wp-employee-form]";

        //  check if page exist calling function get page by title
        $query = new WP_Query([
            'post_type' => 'page',
            'title' => $page_title,
            'posts_per_page' => 1
        ]);

        // check if page exists
        if (!$query->have_posts()) {
            // if not exist then create page
            $new_page_id = wp_insert_post(array(
                'post_title' => $page_title,
                'post_content' => $page_content,
                'post_status' => 'publish',
                'post_type' => 'page',
            ));
        }

    }

    // drop table
    public function drop_table()
    {
        $this->wpdb->query("DROP TABLE IF EXISTS " . $this->table_name);

    }

    // render Employee form layout
    public function create_employees_form()
    {
        // start ob to connect employee_form.php
        ob_start();
        include_once WCE_DIR_PATH . '/template/employee_form.php';

        // get_contents of template
        $template = ob_get_contents();
        // end ob and return the content

        ob_end_clean();  // clear output buffer and turn off output buffering

        return $template;
    }

    // public function add assets to plugin 
    public function add_assets_to_plugin()
    {

        wp_enqueue_style("employee-crud-css", WCE_DIR_URL . "assets/style.css");

        // enque script  jquery validate with cdn

        wp_enqueue_script(
            "wce-validation", // Handle name
            "https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js", // CDN URL
            array("jquery"), // Dependencies
            "1.21.0"// Version

        );

        wp_enqueue_script("employee-crud-js", WCE_DIR_URL . "assets/script.js", array("jquery"), "3.0");

        // localize script
        wp_localize_script("employee-crud-js", "wce_object", array(
            "ajax_url" => admin_url("admin-ajax.php")
        ));


    }

    // public function handle_add_employee_form_data
    // Process ajax request add employee form
    public function handle_add_employee_form_data()
    {


        // get data values from POST object
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_text_field($_POST['email']);
        $designation = sanitize_text_field($_POST['designation']);



        /** 
         * array("test_form" =>false) -> wp_handle_upload is not going to check any file attributes or even file submission
         * 
         * array("test_form" =>true) -> wp_handle_upload will validate form request, nonce, value and other form parameters
         * 
         */
        $profile_url = '';
        // check for file image
        if (isset($_FILES['profile_image']['name'])) {
            // File available
            $file_uploaded = wp_handle_upload($_FILES['profile_image'], array("test_form" => false));

            $profile_url = $file_uploaded['url'];
        }
        $this->wpdb->insert($this->table_name, [
            "name" => $name,
            "email" => $email,
            "designation" => $designation,
            "profile_image" => $profile_url
        ]);

        $employee_id = $this->wpdb->insert_id;

        if ($employee_id > 0) {
            echo json_encode([
                "status" => 1,
                "message" => "Employee added successfully"
            ]);
        } else {
            echo json_encode([
                "status" => 0,
                "message" => "Failed to save employee"
            ]);
        }


        die;
    }

    // Load DB Table Employees
    public function handle_load_employees_data()
    {
        $table_name = $this->table_name;
        $employees = $this->wpdb->get_results("SELECT * FROM {$table_name}", ARRAY_A);

        // output data using wp_send_json function
        return wp_send_json([
            "status" => true,
            "message" => "Employees data loaded successfully",
            "employees" => $employees
        ]);

    }

    // Delete DB row by id
    public function handle_delete_employee_data()
    {
        $employee_id = $_GET['id'];

        $this->wpdb->delete($this->table_name, [
            "id" => $employee_id
        ]);

        // return wp_send_json
        return wp_send_json([
            "status" => true,
            "message" => "Employee deleted  successfully"
        ]);

    }

    // function to edit employee data
    public function handle_get_employee_data()
    {

        $employee_id = $_GET['id'];

        $employee = $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d",
            $employee_id
        ));

        if ($employee) {
            return wp_send_json([
                "status" => true,
                "employee" => $employee
            ]);
        } else {
            return wp_send_json([
                "status" => false,
                "message" => "Employee not found"
            ]);
        }

    }
    public function handle_edit_employee_data()
    {
        // get employee data
        $employee_id = $_POST['employee_id'];
        $name = sanitize_text_field($_POST['employee_name']);
        $email = sanitize_text_field($_POST['employee_email']);
        $designation = sanitize_text_field($_POST['employee_designation']);

        $profile_url = '';

        // check for file image
        if (isset($_FILES['employee_profile_image']['name'])) {
            // File available
            $file_uploaded = wp_handle_upload($_FILES['employee_profile_image'], array("test_form" => false));
            $profile_url = $file_uploaded['url'];
            $this->wpdb->update($this->table_name, [
                "name" => $name,
                "email" => $email,
                "designation" => $designation,
                "profile_image" => $profile_url
                ],
                [
                    "id" => $employee_id
                ]
            );

        } else {
            $this->wpdb->update($this->table_name, [
                "name" => $name,
                "email" => $email,
                "designation" => $designation
                ],
                [
                    "id" => $employee_id
                ]
            );
    
        }
        // return wp_send_json
        return wp_send_json([
            "status" => true,
            "message" => "Employee updated successfully"
        ]);
        
    }
       
}