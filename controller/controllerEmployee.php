<?php
session_start();

require_once './../model/modelEmployee.php';

$employee = new ModelEmployee();
$response = [];
// validation in the back-end;
function validationError($params)
{
    $result = '';
    if (empty($params['name'])) {
        $result .= '<li>Name is required.</li>';
    }

    if (empty($params['phone']) || !preg_match('/^[0-9]{10,15}$/', $params['phone'])) {
        $result .= '<li>Please enter a valid phone number (10-15 digits).</li>';
    }

    if (empty($params['email']) || !filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
        $result .= '<li>Please enter a valid email address.</li>';
    }

    if (empty($params['dateHire'])) {
        $result .= '<li>Date Hire is required.</li>';
    }

    if (empty($params['ic'])) {
        $result .= '<li>IC is required.</li>';
    }

    if (empty($params['department'])) {
        $result .= '<li>Department is required.</li>';
    }

    if (empty($params['address'])) {
        $result .= '<li>Address is required.</li>';
    }

    if (empty($params['nationality'])) {
        $result .= '<li>Nationality is required.</li>';
    }
    return $result;
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = 'get';
} else {
    $action = !empty($_GET['action']) ? $_GET['action'] : null;

    //sanitize input
    $id = !empty($_POST['id']) ? trim($_POST['id']) : (!empty($_GET['id'])?trim($_GET['id']):null);
}


switch ($action) {
    case "get":
        if (isset($_GET['id'])) {
            $response = $employee->getSingle(intval($_GET['id']));
        } else {
            $allEmployees = $employee->getRows();
            $response = $allEmployees;
        }
        break;
    case "insert":
        if ($errorMsg = validationError($_POST)) {
            $response['type'] = 'error';
            $response['msg'] = '<ul>' . $errorMsg . '</ul>';
        } else {

            //prepare data to insert
            $userData = [];
            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    $userData[$key] = trim($value);
                }
            }

            $inserted = $employee->insert($userData);

            if ($inserted) {
                $response['type'] = 'success';
                $response['msg'] = 'Member data has been added successfully.';
            } else {
                $response['type'] = 'error';
                $response['msg'] = 'Some problem occurred, please try again.';
            }
        }
        break;
    case "update":
        if ($errorMsg = validationError($_POST)) {
            $response['type'] = 'error';
            $response['msg'] = '<ul>' . $errorMsg . '</ul>';
        } else {
            if (!empty($id)) {
                //prepare data to update
                $userData = [];
                foreach ($_POST as $key => $value) {
                    if (!empty($value)) {
                        $userData[$key] = trim($value);
                    }
                }
                $updated = $employee->update($userData, $_POST['id']);

                if ($updated) {
                    $response['type'] = 'success';
                    $response['msg'] = 'Member data has been updated successfully.';
                } else {
                    $response['type'] = 'error';
                    $response['msg'] = 'Some problem occurred, please try again.';
                }
            } else {
                $response['type'] = 'error';
                $response['msg'] = 'Id required !';
            }
        }
        break;
    case "delete":
        if (!empty($id)) {
            $delete = $employee->delete($id);

            if ($delete) {
                $response['type'] = 'success';
                $response['msg'] = 'Member data has been deleted successfully.';
            } else {
                $response['type'] = 'error';
                $response['msg'] = 'Some problem occurred, please try again.';
            }
        } else {
            $response['type'] = 'error';
            $response['msg'] = 'Id required !';
        }
        break;
    default:
        $response['type'] = 'error';
        $response['msg'] = 'Undefined method';
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);