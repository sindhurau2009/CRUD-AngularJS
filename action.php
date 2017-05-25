<?php
include 'DB.php';
$db = new DB();
$tblName = 'student';
if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){
    $type = $_REQUEST['type'];
    switch($type){
        case "view":
            $records = $db->getRows($tblName);
            if($records){
                $data['records'] = $db->getRows($tblName);
                $data['status'] = 'OK';
            }else{
                $data['records'] = array();
                $data['status'] = 'ERR';
            }
            echo json_encode($data);
            break;
        case "add":
            if(!empty($_POST['data'])){
                $userData = array(
                    'sid' => $_POST['data']['sid'],
                    'sname' => (isset($_POST['data']['sname']) ? $_POST['data']['sname'] : null),
                    'year' => $_POST['data']['year'],
					'gpa' => $_POST['data']['gpa']
					
                );
				$courseData = array(
					'sid' => $_POST['data']['sid'],
					'cname' => $_POST['data']['cname'],
				);
				$dat = array(
					'sid' => $_POST['data']['sid'],
                    'sname' => (isset($_POST['data']['sname']) ? $_POST['data']['sname'] : null),
                    'year' => $_POST['data']['year'],
					'gpa' => $_POST['data']['gpa'],
					'cname' => $_POST['data']['cname']
				);
				
                $insert = $db->insert($tblName,$userData,$courseData,$dat);
                if($insert){
                    $data['data'] = $insert;
                    $data['status'] = 'OK';
                    $data['msg'] = 'User data has been added successfully.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Some problem occurred, please try again.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Some problem occurred, please try again.';
            }
            echo json_encode($data);
            break;
        case "edit":
            if(!empty($_POST['data'])){
                $userData = array(
                    'sid' => $_POST['data']['sid'],
                    'sname' => $_POST['data']['sname'],
                    'year' => $_POST['data']['year'],
					'gpa' => $_POST['data']['gpa']
                );
				$courseData = array(
					'sid' => $_POST['data']['sid'],
					'cname' => $_POST['data']['cname']
				);
                $condition = array('sid' => $_POST['data']['sid']);
                $update = $db->update($tblName,$userData,$courseData,$condition);
                if($update){
                    $data['status'] = 'OK';
                    $data['msg'] = 'User data has been updated successfully.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Some problem occurred, please try again.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Some problem occurred, please try again.';
            }
            echo json_encode($data);
            break;
        case "delete":
            if(!empty($_POST['sid'])){
                $condition = array(
				'sid' => $_POST['sid']);
				$condition1 = array(
				'sid' => $_POST['sid'],
				'cname' => $_POST['cname']);
                $delete = $db->delete($tblName,$condition,$condition1);
                if($delete){
                    $data['status'] = 'OK';
                    $data['msg'] = 'User data has been deleted successfully.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Some problem occurred, please try again.';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Some problem occurred, please try again.';
            }
            echo json_encode($data);
            break;
        default:
            echo '{"status":"INVALID"}';
    }
}