<?php
	if(!isset($_POST['action']) || !is_numeric($_POST['action'])){
		die;
	}

	require_once "controller/user.php";

	switch ($_POST['action']) {
		case 1: // modal user
			require_once "modal_user.php";
		break;

		case 2: // insert user
			$user = New UserController();
			echo $user->insertUser();
		break;

		case 3: // delete user and its phones
			$user = New UserController();
			echo $user->deleteUser();
		break;

		case 4: // Reload User
			echo UserController::listUser();
		break;

		case 5: // check e-mail
			$user = New UserController();
			echo $user->checkEmailUser();
		break;
	}
?>