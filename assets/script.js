jQuery(document).ready(function ($) {
    console.log("Welcome to CRUD Plugin of employees");

    // Add form validation
    jQuery("#frm_add_employee").validate();

    // form submit
    jQuery("#frm_add_employee").on("submit", function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        jQuery.ajax({
            url: wce_object.ajax_url,
            data: formData,
            method: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    loadEmployeeData();
                }
            }
        })
    })

    // Render employees
    loadEmployeeData();

    // delete employee
    jQuery(document).on("click", ".btn_delete_employee", function () {

        var employeeID = jQuery(this).data("id"); // jQuery(this).attr("data-id");
        if (confirm("Are you sure you want to delete this employee?")) {
            jQuery.ajax({
                url: wce_object.ajax_url,
                data: {
                    action: "wce_delete_employee",
                    id: employeeID
                },
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        alert(response.message);
                        loadEmployeeData();
                    }
                }
            })
        }
    })

    // edit employee
    // Open Add employee
    jQuery(document).on("click", "#btn_open_add_employee_form", function () {
        jQuery(".add_employee_form").toggleClass("hide_element");
    })

    // open edit employee 
    jQuery(document).on("click", ".btn_edit_employee", function () {
        var employeeID = jQuery(this).data("id");
    
        // call ajax to get the employee data
        jQuery.ajax({
            url: wce_object.ajax_url,
            data: {
                action: "wce_get_employee_data", // Action which will called to get data
                id: employeeID
            },
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    // Fill form form editing
                    jQuery("#employee_id").val(response.employee.id); // Set the employee ID
                    jQuery("#employee_name").val(response.employee.name);
                    jQuery("#employee_email").val(response.employee.email);
                    jQuery("#employee_designation").val(response.employee.designation);
                    jQuery("#employee_file").val(response.employee.file);
    
                    // show form
                    jQuery(".edit_employee_form").removeClass("hide_element");

                    // Scroll to top
                    jQuery('html, body').animate({
                        scrollTop: jQuery(".edit_employee_form").offset().top
                    }, 500); 
                }
            }
        });
    });
    
    //  submiting and send data after editing employee
    jQuery("#frm_edit_employee").on("submit", function (e) {
        e.preventDefault();
        
        var formData = new FormData(this);

        // add ajax
        jQuery.ajax({
            url: wce_object.ajax_url,
            data: formData,
            method: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    loadEmployeeData();
                    jQuery(".edit_employee_form").toggleClass("hide_element");
                }
            }
        })
    })
    
    

});

// Load all Employees from DB Table
function loadEmployeeData() {
    jQuery.ajax({
        url: wce_object.ajax_url,
        data: {
            action: "wce_load_employees_data"
        },
        method: "GET",
        dataType: "json",
        success: function (response) {

            var employeesDataHTMl = "";
            // load data from db employees using jQuery each function
            jQuery.each(response.employees, function (index, employee) {

                let employeesProfileImage = employee.profile_image ? employee.profile_image : "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
                employeesDataHTMl += `     
                <tr>
                <td>${employee.id}</td>
                <td>${employee.name}</td>
                <td>${employee.email}</td>
                <td>${employee.designation}</td>
                <td><img src="${employeesProfileImage}" width="50" height="50"></td>
                <td>
                    <button data-id="${employee.id}" class="btn_edit_employee">Edit</button>
                    <button data-id="${employee.id}" class="btn_delete_employee">Delete</button>
                </td>
            </tr>`;
            });
            // bind data to the table by id
            jQuery("#employee_data_table").html(employeesDataHTMl);
        }
    })

}


