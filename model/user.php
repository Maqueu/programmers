<?php
	require_once "controller/conn.php";

	class User{
		private $id;
		private $name;
		private $surname;
		private $email;

		function setId($id){$this->id = $id;}
		function getId(){return $this->id;}

		function setName($name){$this->name = $name;}
		function getName(){return $this->name;}

		function setSurname($surname){$this->surname = $surname;}
		function getSurname(){return $this->surname;}

		function setEmail($email){$this->email = $email;}
		function getEmail(){return $this->email;}

		function listUser($order = 0, $desc = 0){
			$where = "";
			switch ($order) {
				case 0:
					$order = 'name';
				break;

				case 1:
					$order = 'surname';
				break;

				case 2:
					$order = 'email';
				break;

				case 3:
					$order = 'phones';
				break;

				default:
					$order = 'name';
				break;
			}
			$desc = ($desc ? 'DESC' : '');
			$sql_selUser = "SELECT 	u.id,
									u.name,
							        u.surname,
							        u.email,
							        (
							        	SELECT 	GROUP_CONCAT(
							        				CONCAT(
							        					'<div class=''phone''>',
							        					phone,
							        					'</div>'
							        				) 
							        				ORDER BY phone SEPARATOR ' '
							        			) 
							        		FROM prog_phones p 
							        		WHERE  p.id_user = u.id
							        ) phones
								FROM prog_users u
								WHERE 1 = 1 {$where}
							    ORDER BY {$order} {$desc}";

			global $conn;
			$que_selUser = $conn->prepare($sql_selUser);
			$que_selUser->execute();

			return $que_selUser->fetchAll();
		}

		function getDatas(){
			$sql_selData = "SELECT 	name,
									surname,
									email,
									register_date,
									update_date
								FROM prog_users
							    WHERE id = :id";

			global $conn;
			$que_selData = $conn->prepare($sql_selData);
			$que_selData->bindParam('id', $this->id, PDO:: PARAM_INT);
			$que_selData->execute();

			return $que_selData->fetchObject();
		}

		function insertUser(){
			$sql_addUser = "INSERT INTO prog_users(name, surname, email) VALUES(:name, :surname, :email)";

			global $conn;
			$que_addUser = $conn->prepare($sql_addUser);
			$que_addUser->bindParam('name', $this->name, PDO:: PARAM_STR);
			$que_addUser->bindParam('surname', $this->surname, PDO:: PARAM_STR);
			$que_addUser->bindParam('email', $this->email, PDO:: PARAM_STR);

			if ($que_addUser->execute()) {
				return 1;
			}
		}

		function updateUser(){
			$sql_updUser = "UPDATE prog_users SET 	name = :name, 
													surname = :surname, 
													email = :email 
												WHERE id = :id";

			global $conn;
			$que_updUser = $conn->prepare($sql_updUser);
			$que_updUser->bindParam('name', $this->name, PDO:: PARAM_STR);
			$que_updUser->bindParam('surname', $this->surname, PDO:: PARAM_STR);
			$que_updUser->bindParam('email', $this->email, PDO:: PARAM_STR);
			$que_updUser->bindParam('id', $this->id, PDO:: PARAM_INT);

			if ($que_updUser->execute()) {
				return 1;
			}
		}

		function deleteUser(){
			$sql_delUser = "DELETE FROM prog_users WHERE id = :id";

			global $conn;
			$que_delUser = $conn->prepare($sql_delUser);
			$que_delUser->bindParam('id', $this->id, PDO:: PARAM_INT);

			if ($que_delUser->execute()) {
				return 1;
			}
		}

		function selIdByEmail($notMe = 0){
			$notMe = ($notMe ? "AND id <> :id" : "");
			$sql_selId = "SELECT id FROM prog_users WHERE email = :email {$notMe}";

			global $conn;
			$que_selId = $conn->prepare($sql_selId);
			$que_selId->bindParam('email', $this->email, PDO:: PARAM_STR);
			if ($notMe) {
				$que_selId->bindParam('id', $this->id, PDO:: PARAM_INT);
			}
			$que_selId->execute();

			return $que_selId->fetchObject();
		}
	}
?>