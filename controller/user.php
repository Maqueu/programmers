<?php
	require_once "model/user.php";
	require_once "controller/phone.php";

	function firstUpper($txt = ''){
		return mb_convert_case($txt, MB_CASE_TITLE, "UTF-8");
	}

	class UserController{

		static function listUser($status = 1){
			$user = New User();

			$input = [];
			for ($i = 0; $i < 4; $i++) { 
				$input[] = [
					'check' => '',
					'desc' => 0
				];
			}

			$ordenar = (isset($_POST['checkOrder']) ? $_POST['checkOrder'] : 0);
			$desc = (isset($_POST['desc']) ? $_POST['desc'] : 0);

			$input[$ordenar]['check'] = "checked=\"\"";
			$input[$ordenar]['desc'] = $desc;

			$html = 	"<table width=\"100%\" id=\"tblUser\">
							<thead>
								<tr>
									<th align=\"left\" class=\"threeDots\">
										Name
										<input type=\"radio\" name=\"checkOrder\" hidden=\"\" desc=\"".$input[0]['desc']."\" ".$input[0]['check']." value=\"0\">
										<i>^</i>
									</th>
									<th align=\"left\" class=\"threeDots\">
										Surname
										<input type=\"radio\" name=\"checkOrder\" hidden=\"\" desc=\"".$input[1]['desc']."\" ".$input[1]['check']." value=\"1\">
										<i>^</i>
									</th>
									<th align=\"left\" class=\"threeDots\" width=\"40%\">
										E-mail
										<input type=\"radio\" name=\"checkOrder\" hidden=\"\" desc=\"".$input[2]['desc']."\" ".$input[2]['check']." value=\"2\">
										<i>^</i>
									</th>
									<th align=\"left\" width=\"160\">
										Phones
										<input type=\"radio\" name=\"checkOrder\" hidden=\"\" desc=\"".$input[3]['desc']."\" ".$input[3]['check']." value=\"3\">
										<i>^</i>
									</th>
								</tr>
							</thead>
							<tbody>";
			$e = $user->listUser($ordenar, $desc);
			if ($e) {
				foreach ($e as $v) {
					$html .=	"<tr id=\"trUser".$v['id']."\">
									<td class=\"threeDots\">".firstUpper($v['name'])."</td>
									<td class=\"threeDots\">".firstUpper($v['surname'])."</td>
									<td class=\"threeDots\">".$v['email']."</td>
									<td class=\"threeDots\">".$v['phones']."</td>
								</tr>";
				}
			}
			else{
				$html .= 		"<tr>
									<td colspan=\"5\" align=\"center\">Nenhum estabelecimento encontrado</td>
								</tr>";
			}

			$html .= 		"</tbody>
						</table>";

			return $html;
		}

		function getDatas($id = 0){
			if ($id == 0) {
				$d = New StdClass();
				$d->name = $d->surname = $d->email = "";
				$d->register_date = $d->update_date = null;
			}
			else{
				$user = New User();
				$user->setId($id);
				$d = $user->getDatas();
			}

			return $d;
		}

		function insertUser(){
			$user = New User();
			$user->setName(strtolower(trim($_POST['txtName'])));
			$user->setSurname(strtolower(trim($_POST['txtSurname'])));
			$user->setEmail(strtolower(trim($_POST['txtEmail'])));

			if ($_POST['idUser'] == 0) {
				$user->insertUser();
				$id = $user->selIdByEmail();
				if (!isset($id->id)) {
					die("Unrealized cadastre");
				}
				$user->setId($id->id);
			}
			else{
				$user->setId($_POST['idUser']);
				$user->updateUser();
			}

			if (isset($_POST['txtPhone']) && is_array($_POST['txtPhone']) && 
				isset($_POST['idPhone']) && is_array($_POST['idPhone'])) {
				$phone = New PhoneController();
				$phone->insertUpdatePhone($user->getId(), $_POST['txtPhone'], $_POST['idPhone']);
			}

			return 1;
		}

		function deleteUser(){
			$user = New User();
			$user->setId($_POST['id']);
			return $user->deleteUser();
		}

		function checkEmailUser(){
			$user = New User();
			$user->setId($_POST['id']);
			$user->setEmail(strtolower(trim($_POST['txtEmail'])));

			$duplicated = $user->selIdByEmail(1);
			return ($duplicated ? "Duplicated e-mail" : 1);
		}
	}
?>