<div
    id="wp_employee_crud_plugin">
    <!-- Add employee layout -->

    <div class="form-container  add_employee_form hide_element">
        <h3>Add Employee</h3>
        <form action="javascript:void(0)" id="frm_add_employee" method="post" enctype="multipart/form-data">

            <input type="hidden" name="action" value="wce_add_employee">
            <p>
                <label for="name">Name</label>
                <input type="text" required name="name" placeholder="Employee name" id="name">
            </p>

            <p>
                <label for="email">Email</label>
                <input type="email" required name="email" placeholder="Employee email" id="email">
            </p>

            <p>
                <label for="designation">Designation</label>
                <select required name="designation" id="designation">
                    <option value="">-- Choose Designation --</option>
                    <option value="php">PHP Developer</option>
                    <option value="java">Java Developer</option>
                    <option value="ui/ux">UI/UX Developer</option>
                    <option value="c#">C# Developer</option>
                    <option value="python">Python Developer</option>
                    <option value="wordpress">WordPress Developer</option>
                </select>
            </p>

            <p>
                <label for="file">Profile Image</label>
                <input type="file" name="profile_image" id="file">
            </p>

            <p>
                <button id="btn_save_data" type="submit">Save Data</button>
            </p>
        </form>
    </div>

    <div class="form-container edit_employee_form hide_element">
        <h3>Edit Employee</h3>

        <form action="javascript:void(0)" id="frm_edit_employee" method="post" enctype="multipart/form-data">

            <input type="hidden" name="action" value="wce_edit_employee">
            <input type="hidden" name="employee_id" id="employee_id">

            <p>
                <label for="employee_name">Name</label>
                <input type="text" required name="employee_name" placeholder="Employee name" id="employee_name">
            </p>

            <p>
                <label for="employee_email">Email</label>
                <input type="email" required name="employee_email" placeholder="Employee email" id="employee_email">
            </p>

            <p>
                <label for="employee_designation">Designation</label>
                <select required name="employee_designation" id="employee_designation">
                    <option value="">-- Choose Designation --</option>
                    <option value="php">PHP Developer</option>
                    <option value="java">Java Developer</option>
                    <option value="ui/ux">UI/UX Developer</option>
                    <option value="c#">C# Developer</option>
                    <option value="python">Python Developer</option>
                    <option value="wordpress">WordPress Developer</option>
                </select>
            </p>

            <p>
                <label for="employee_profile_image">Profile Image</label>
                <input type="file" name="employee_profile_image" id="employee_file">
            </p>

            <p>
                <button id="btn_update_data" type="submit">Update Employee</button>
            </p>
        </form>
    </div>

    <!-- List employees layout -->
    <h3>List Employees</h3>

    <div class="list-container">
        <button id="btn_open_add_employee_form">Add Employee</button>


        <table>
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Profile Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="employee_data_table"></tbody>
        </table>
    </div>
</div>

