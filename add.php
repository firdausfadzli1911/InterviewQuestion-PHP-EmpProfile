<?php

$employeeData = [];
if (!empty($_GET['id'])) {
    require_once 'model/modelEmployee.php';
    $db = new ModelEmployee('data/employee.json');

    $employeeData = $db->getSingle($_GET['id']);
}
$actionLabel = !empty($_GET['id']) ? 'Edit' : 'Add New';
$actionType = !empty($_GET['id']) ? 'update' : 'insert';
?>

<div class="modal-header">
    <h5 class="modal-title" id="employeeModalLabel"><?php echo $actionLabel ?> Employee</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div id="errorMessages" class="alert alert-danger" style="display:none;"></div>
    <form id="employeeForm">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="input_employee_name">Full Name</label>
                <input type="text" class="form-control" name="name" id="input_employee_name" placeholder="Name" value="<?php echo !empty($employeeData['name']) ? $employeeData['name'] : ''; ?>">
                <span class="error-message text-danger"></span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="input_tel">Telephone</label>
                <input type="tel" class="form-control" name="phone" id="input_tel" placeholder="Telephone" value="<?php echo !empty($employeeData['phone']) ? $employeeData['phone'] : ''; ?>">
                <span class="error-message text-danger"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="input_ic">MyKad/Passport No.</label>
                <input type="text" class="form-control" name="ic" id="input_ic" placeholder="010127011111" value="<?php echo !empty($employeeData['ic']) ? $employeeData['ic'] : ''; ?>">
                <span class="error-message text-danger"></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="input_dob">Date Of Birth</label>
                <input type="date" class="form-control" name="dob" id="input_dob" value="<?php echo !empty($employeeData['dob']) ? $employeeData['dob'] : ''; ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label for="input_gender">Gender</label>
                <select id="input_gender" class="form-select" name="gender">
                    <option value="Male" <?php echo (!empty($employeeData['gender']) && $employeeData['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (!empty($employeeData['gender']) && $employeeData['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="input_marital">Marital Status</label>
                <select id="input_marital" class="form-select" name="maritalStatus">
                <option value="Single" <?php echo (!empty($employeeData['maritalStatus']) && $employeeData['maritalStatus'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo (!empty($employeeData['maritalStatus']) && $employeeData['maritalStatus'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                <option value="Other" <?php echo (!empty($employeeData['maritalStatus']) && $employeeData['maritalStatus'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
                <span class="error-message text-danger"></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="input_race">Race</label>
                <select id="input_race" class="form-select" name="race">
                    <option value="Malay" <?php echo (isset($employeeData['race']) && ($employeeData['race']) == 'Malay') ? 'selected' : ''; ?>>Malay</option>
                    <option value="Chinese" <?php echo (isset($employeeData['race']) && ($employeeData['race']) == 'Chinese') ? 'selected' : ''; ?>>Chinese</option>
                    <option value="Indian" <?php echo (isset($employeeData['race']) && ($employeeData['race']) == 'Indian') ? 'selected' : ''; ?>>Indian</option>
                    <option value="Other" <?php echo (isset($employeeData['race']) && ($employeeData['race']) == 'Other') ? 'selected' : ''; ?>>Other Races</option>
                </select>

                <span class="error-message text-danger"></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="input_nationality">Nationality</label>
                <input type="text" class="form-control" name="nationality" id="input_nationality" placeholder="" value="<?php echo !empty($employeeData['nationality']) ? $employeeData['nationality'] : ''; ?>">
            </div>
            <span class="error-message text-danger"></span>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="input_email">Email</label>
                <input type="email" class="form-control" name="email" id="input_email" placeholder="" value="<?php echo !empty($employeeData['email']) ? $employeeData['email'] : ''; ?>">
                <span class="error-message text-danger"></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="input_date_hire">Hire Date</label>
                <input type="date" class="form-control" name="dateHire" id="input_date_hire" value="<?php echo !empty($employeeData['dateHire']) ? $employeeData['dateHire'] : ''; ?>">
                <span class="error-message text-danger"></span>
            </div>
            <div class="col-md-4 mb-3">
                <label for="input_department">Department</label>
                <input type="text" class="form-control" name="department" id="input_department" placeholder="" value="<?php echo !empty($employeeData['department']) ? $employeeData['department'] : ''; ?>">
                <span class="error-message text-danger"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="input_address">Address</label>
                <textarea id="input_address" class="form-control" name="address" rows="3" placeholder="Address"><?php echo !empty($employeeData['address']) ? htmlspecialchars($employeeData['address']) : ''; ?></textarea>
                <span class="error-message text-danger"></span>
            </div>
        </div>
        <a href="main.php" class="btn btn-secondary">Back</a>
        <input type="hidden" name="id" value="<?php echo !empty($employeeData['id']) ? $employeeData['id'] : ''; ?>">
        
        <button data-action="<?php echo $actionType ?>" type="button" id="save_btn" class="btn btn-primary">Save</button>
    </form>
</div>