<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members List</title>
    <!-- Add Bootstrap CSS here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<style>
    .stick_column{
        position: sticky;
        right: 0; 
        z-index: 1;
    }
</style>
<body>
    <div id="content">
        <div class="container">
            <h3 class="text-dark mt-4 mb-4">Employee List</h3>
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <div class="text-primary fw-bold">
                        <!-- <p class="m-0">Employee Info</p> -->
                    </div>
                    <div>
                        <a data-target-url="add.php" class="btn_add_employee btn btn-success">
                            <i class="plus"></i> Add New Member
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="overflow-x: auto;">
                        <table class="table my-0" id="employeeTable" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th style="width:10%">Name</th>
                                    <th>MyKad/IC</th>
                                    <th>Phone No</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Marital Status</th>
                                    <th>Race</th>
                                    <th>Nationality</th>
                                    <th>Email</th>
                                    <th>Hire Date</th>
                                    <th>Department</th>
                                    <th>Address</th>
                                    <th class="stick_column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="13">Loading ...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div id="employeeModalContent" class="modal-content">
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        getEmployees();

        $(document).on("click", '.btn_add_employee, .btn_edit_employee', function(e) {
            var url = $(this).data('target-url');
            e.preventDefault();
            $('#employeeModalContent').load(url, function() {
                $('#employeeModal').modal('show');
            });
        });

        $(document).on("click", '.btn_delete', function(e) {
            var url = $(this).data('delete-url');
            $.ajax({
                type: 'POST',
                url: url,
                success: function(response) {
                    if (response.type == 'success') {
                        alert(response.msg)
                        getEmployees();
                    } else {
                        $("#errorMessages").html(response.msg).fadeIn();
                        alert(response.msg)
                    }
                }
            });
         
        });
      

        $(document).on("click", '#save_btn', function(e) {

            // validation in the front-end;
            var action = $(this).data('action');
            $("#errorMessages").hide();
            let isValid = true;
            $(".error-message").text(''); 

            const name = $("#input_employee_name").val().trim();
            if (name === "") {
                $("#input_employee_name").siblings(".error-message").text("Full Name is required.");
                isValid = false;
            }

            const phone = $('#input_tel').val().trim();
            const phoneRegex = /^[0-9]{10,15}$/; 
            if (!phoneRegex.test(phone)) {
                $('#input_tel').closest('.mb-3').find('.error-message').text('Please enter a valid telephone number.');
                isValid = false;
            }

            const ic = $('#input_ic').val().trim();
            const icRegex = /^[0-9]+$/; 
            if (!icRegex.test(ic)) {
                $('#input_ic').closest('.mb-3').find('.error-message').text('Please enter a valid MyKad/Passport number.');
                isValid = false;
            }

            const email = $('#input_email').val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                $('#input_email').closest('.mb-3').find('.error-message').text('Please enter a valid email address.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return;
            } else {
                submitForm(action);
            }
        });

    });

    function submitForm(action) {
    // alert("test")

        var data = $('#employeeForm').serialize();

        $.ajax({
            type: 'POST',
            url: 'controller/controllerEmployee.php?action='+action,
            data: data,
            success: function(response) {
                // alert(data);
                if (response.type == 'success') {
                    alert(response.msg)
                    $("#employeeModal").modal('hide');
                    getEmployees();
                } else {
                    $("#errorMessages").html(response.msg).fadeIn();
                    alert(response.msg)
                }
            }
        });
    };

    function  getEmployees() {
        $.ajax({
            "url": "controller/controllerEmployee.php",
            "method": "GET",
            "timeout": 0,
            success: function(response) {
                generateList(response);
            }
        });
    }

    function generateList(employees) {
        var html = '';
        if (employees) {
            $.each(employees, function(index, employee) {
                html += `<tr>` +
                    `<td>` + (index + 1) + `</td>` +
                    `<td>` + employee.name + `</td>` +
                    `<td>` + employee.ic + `</td>` +
                    `<td>` + employee.phone + `</td>` +
                    `<td>` + employee.dob + `</td>` +
                    `<td>` + employee.gender + `</td>` +
                    `<td>` + employee.maritalStatus + `</td>` +
                    `<td>` + employee.race + `</td>` +
                    `<td>` + employee.nationality + `</td>` +
                    `<td>` + employee.email + `</td>` +
                    `<td>` + employee.dateHire + `</td>` +
                    `<td>` + employee.department + `</td>` +
                    `<td>` + employee.address + `</td>` +
                    `<td class="stick_column"><a data-target-url="add.php?id=` + employee.id + `" class="btn btn-warning btn_edit_employee">Edit</a>
                    <a data-delete-url="controller/controllerEmployee.php?action=delete&id=` + employee.id + `" class="btn btn-danger btn_delete" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </td>
                </tr>`;
            });
        } else {
            html += `<tr>
                        <td class="text-center" colspan="13">No result</td>
                    </tr>`;
        }
        $("#employeeTable tbody").html(html);
    }
</script>