<?php
	if(!isset($_POST['action']) || !is_numeric($_POST['action'])){
		die;
	}

	require_once "controller/phone.php";

	switch ($_POST['action']) {
		case 1: // delete phone
			$phone = New PhoneController();
			echo $phone->deletePhone($_POST['user'], $_POST['phone']);
		break;
	}
?>