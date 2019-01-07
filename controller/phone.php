<?php
	require_once "model/phone.php";
	class PhoneController{
		function insertUpdatePhone($user, $phones, $ids){
			$phone  = New Phone();
			$phone->setId($ids);
			$phone->setIdUser($user);
			$phone->setPhone($phones);

			return $phone->insertUpdatePhone();
		}

		static function listPhones($id){
			$phone = New Phone();
			$phone->setIdUser($id);
			$html = "";

			foreach ($phone->listPhones() as $v) {
				$model = file_get_contents('model_phone.html');
				$model = str_replace('@id', $v['id'], $model);
				$model = str_replace('@phone', $v['phone'], $model);

				$html .= $model;
			}

			return $html;
		}

		function deletePhone($user, $id){
			$phone = New Phone();
			$phone->setIdUser($user);
			$phone->setId($id);

			return $phone->deletePhone();
		}

		function deleteUsersPhone($user){
			$phone = New Phone();
			$phone->setIdUser($user);
			return $phone->deleteUsersPhone();
		}
	}
?>