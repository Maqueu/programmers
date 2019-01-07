<?php
	require_once "controller/user.php";
	require_once "controller/phone.php";
	$user = New UserController();
	$id = (isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : 0);
	$d = $user->getDatas($id);

	if (!$d) {
		die("<h3 align=\"center\">Error while searching users</h3>");
	}
?>
<form id="frmUser">
	<div class="row">
		<input type="hidden" name="action" value="2">
		<input type="hidden" name="idUser" value="<?= $id ?>">
		<div class="col-md-6">
			<label for="txtName">Name</label>
			<input type="text" class="form-control" maxlength="70" name="txtName" id="txtName" value="<?= $d->name ?>">
		</div>
		<div class="col-md-6">
			<label for="txtSurname">Surname</label>
			<input type="text" class="form-control" maxlength="100" name="txtSurname" id="txtSurname" value="<?= $d->surname ?>">
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<label for="txtEmail">E-mail</label>
			<input type="email" class="form-control" maxlength="200" name="txtEmail" id="txtEmail" value="<?= $d->email ?>">
		</div>
	</div>
	<div id="listPhones" class="row">
		<?php
			if ($id != 0) {
				echo PhoneController::listPhones($id);
			}
		?>
	</div>
	<button type="button" id="btnPhone" class="btn btn-primary">+ Phone</button>
</form>
<div id="modelPhone" hidden="">
	<?php
		$htmlPhone = file_get_contents('model_phone.html');
		$htmlPhone = str_replace('@id', 0, $htmlPhone);
		$htmlPhone = str_replace('@phone', '', $htmlPhone);

		echo $htmlPhone;
	?>
</div>
<div class="dates">
<?php
	if ($d->register_date) { ?>	
		<div>
			<strong>Registered:</strong> 
			<?= date('d/m/Y', strtotime($d->register_date)) ?> at 
			<?= date('H:i:s', strtotime($d->register_date)) ?>
		</div>
<?php
	}
	if ($d->update_date) { ?>	
		<div>
			<strong>Updated:</strong> 
			<?= date('d/m/Y', strtotime($d->update_date)) ?> at 
			<?= date('H:i:s', strtotime($d->update_date)) ?>
		</div>
<?php
	}
?>
</div>

<script type="text/javascript">
	$(() => {
		if (<?= $id ?> == 0) {
			$('#btnDelete').remove();
			$('#btnSave').html("Register");
		}
		else{
			$('#btnSave').html("Save");
		}
	});

	function erroFormulario(texto, qual){
		swal({
			title: "Opps...", 
			text: texto,
			type: "error"
		}).then(() => {
			setTimeout(() => qual.focus(), 300);
		})
	}

	function isEmail(email) {
	    var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    return re.test(email);
	}

	$('body').off('click', '#btnSave').on('click', '#btnSave', function(){
		erro = 0;

		if ($('#txtName').val().trim() == '') {
			erroFormulario('Fill the name', $('#txtName'));
			erro = 1;
			return
		}

		if ($('#txtSurname').val().trim() == '') {
			erroFormulario('Fill the surname', $('#txtSurname'));
			erro = 1;
			return
		}

		if ($('#txtEmail').val().trim() == '') {
			erroFormulario('Fill the e-mail', $('#txtEmail'));
			erro = 1;
			return;
		}

		if (!isEmail($('#txtEmail').val().trim())) {
			erroFormulario('invalid e-mail', $('#txtEmail'));
			erro = 1;
			return;
		}

		
		$('#listPhones [name^="txtPhone"]').each(function(){
			if ($(this).val().trim().length < 14) {
				erroFormulario('Fill the phone', $(this));
				erro = 1;
				return false;
			}
		});
		

		if (erro == 0) {
			// check duplicated e-mail
			$.ajax({
				type: 'post',
				url: 'ajax_user.php',
				data: 'action=5&' + $('#txtEmail').serialize() + '&id=<?= $id ?>',
				success: (validEmail) => {
					if (validEmail == 1) {
						$.ajax({
							type: 'post',
							url: 'ajax_user.php',
							data: $('#frmUser').serialize(),
							success: (erro) => {
								if (erro == 1) {
									$('#modal').modal('hide');
									swal({
										title: "Success",
										text: (<?= $id ?> == 0 ? "Registered" : "Updated") + " successfully",
										type: "success"
									}).then(() => reloadUser());
								}
								else{
									swal({
										title: "Opps...", 
										text: erro,
										type: "error"
									});
								}
							}
						})
					}
					else{
						erroFormulario(validEmail, $('#txtEmail'));
					}
				}
			})
		}
	});

	$('body').off('click', '#btnDelete').on('click', '#btnDelete', function(){
		swal({
                title: "Delete",
                text: "Do You really wanna Delete this user?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }
        ).then((result) => {
            if (result.value) {
				$.ajax({
					type: 'post',
					url: 'ajax_user.php',
					data: 'action=3&id=' + <?= $id ?>,
					success: (erro) => {
						if (erro == 1) {
							$('#modal').modal('hide')
							reloadUser();
						}
						else{
							swal({
								title: "Opps...", 
								text: erro,
								type: "error"
							})
						}
					}
				})
            }
        })
	})

	$('#btnPhone').click(() => addPhone());
	addPhone = () => {
		$('#listPhones').append($('#modelPhone').html());
		$('#listPhones [name^="txtPhone"]:last').focus();
		maskPhone();
	};

	$('body').off('click', '.btnRemove').on('click', '.btnRemove', function(){
		swal({
                title: 'Delete',
                text: "Do You really wanna delete this phone",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }
        ).then((result) => {
            if (result.value) {
            	idPhone = $(this).find('[name^="idPhone"]').val()
            	if (idPhone == 0){
					$(this).prev().remove();
					$(this).remove();
            	}
            	else{
					$.ajax({
						type: 'post',
						url: 'ajax_phone.php',
						data: 'action=1&user=' + <?= $id ?> + '&phone=' + idPhone,
						success: (erro) => {
							if (erro == 1) {
								$(this).prev().remove();
								$(this).remove();
							}
							else{
								swal({
									title: "Opps...", 
									text: erro,
									type: "error"
								})
							}
						}
					})
            	}
            }
        })
	})
</script>