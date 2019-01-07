<?php
	require_once "controller/conn.php";

	class Phone{
		private $id;
		private $idUser;
		private $phone;

		function setId($id){$this->id = $id;}
		function getId(){return $this->id;}

		function setIdUser($idUser){$this->idUser = $idUser;}
		function getIdUser(){return $this->idUser;}

		function setPhone($phone){$this->phone = $phone;}
		function getPhone(){return $this->phone;}

		function insertUpdatePhone(){
			$sql_addPhone = "INSERT INTO prog_phones(id_user, phone) VALUES(:user, :phone)";
			$sql_updPhone = "UPDATE prog_phones SET phone = :phone WHERE id_user = :user AND id = :id";

			global $conn;
			$que_addPhone = $conn->prepare($sql_addPhone);
			$que_addPhone->bindParam('user', $this->idUser, PDO:: PARAM_INT);

			$que_updPhone = $conn->prepare($sql_updPhone);
			$que_updPhone->bindParam('user', $this->idUser, PDO:: PARAM_INT);


			foreach ($this->phone as $k => $v) {
				if ($this->id[$k] == 0) {
					$que_addPhone->bindParam('phone', $this->phone[$k], PDO:: PARAM_STR);

					if (!$que_addPhone->execute()) {
						die("Error while registering the phone");
					}
				}
				else{
					$que_updPhone->bindParam('phone', $this->phone[$k], PDO:: PARAM_STR);
					$que_updPhone->bindParam('id', $this->id[$k], PDO:: PARAM_INT);

					if (!$que_updPhone->execute()) {
						die("error while updating the phone");
					}
				}
			}

			return 1;
		}

		function listPhones(){
			$sql_selPhones = "SELECT id, phone FROM prog_phones WHERE id_user = :id";

			global $conn;
			$que_selPhones = $conn->prepare($sql_selPhones);
			$que_selPhones->bindParam('id', $this->idUser, PDO:: PARAM_INT);
			$que_selPhones->execute();

			return $que_selPhones->fetchAll();
		}

		function deletePhone(){
			$sql_delPhone = "DELETE FROM prog_phones WHERE id_user = :user AND id = :id";

			global $conn;
			$que_delPhone = $conn->prepare($sql_delPhone);
			$que_delPhone->bindParam('user', $this->idUser, PDO:: PARAM_INT);
			$que_delPhone->bindParam('id', $this->id, PDO:: PARAM_INT);

			if ($que_delPhone->execute()) {
				return 1;
			}
		}

		function deleteUsersPhone(){
			$sql_delUsersPhone = "DELETE FROM prog_phones WHERE id_user = :user";

			global $conn;
			$que_delUsersPhone = $conn->prepare($sql_delUsersPhone);
			$que_delUsersPhone->bindParam('user', $this->idUser, PDO:: PARAM_INT);

			if ($que_delUsersPhone->execute()) {
				return 1;
			}
		}
	}
?>