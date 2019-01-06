<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>programmer's test</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	</head>
	<body>
		<?php
			require_once "controller/user.php";
		?>
		<style type="text/css">
			body{
				margin: 8px;
			}

			#tblUser thead th, .titulo, .fixedTop thead th{
				color: #1e72ba;
				font-style: italic;
				font-weight: 900;
				padding-bottom: 5px;
			}

			#tblUser thead th, .fixedTop thead th{
				border-bottom: 1px solid #32ff06;
			}

			#tblUser tr, .fixedTop tr{
				cursor: pointer !important;
			}

			.col-md-6, .col-md-5, .col-md-12{
				margin-bottom: 15px;
			}

			#tblUser tr td{
				border-bottom: 1px solid #1e72ba;
				padding-bottom: 5px;
			}

			#tblUser tr td:first-child, #tblUser tr td:first-child + td, #tblUser tr td:first-child + td + td{
				max-width: 1px;
			}

			#tblUser tr{
				transition: background-color 0.7s, color 0.7s;
				-webkit-transition: background-color 0.7s, color 0.7s;
				-moz-transition: background-color 0.7s, color 0.7s;
				-ms-transition: background-color 0.7s, color 0.7s;
				-o-transition: background-color 0.7s, color 0.7s;
				color: #1e72ba;
			}

			#tblUser tbody tr:hover{
				background-color: #32ff064d;
			    color: black;
			}

			.threeDots{
				text-overflow: ellipsis;
			    white-space: nowrap;
			    overflow-x: hidden;
			}

			#listUser{
				overflow-x: auto;
			}

			.modal-header{
			    color: white;
			    background-color: #1e72ba;
			    background: linear-gradient(260deg, #1e72ba, #09508e);
			    -webkit-background: linear-gradient(260deg, #1e72ba, #09508e);
			    -moz-background: linear-gradient(260deg, #1e72ba, #09508e);
			    -ms-background: linear-gradient(260deg, #1e72ba, #09508e);
			    -o-background: linear-gradient(260deg, #1e72ba, #09508e);
			}

			#footerModal{
			    background-color: #3b9e26;
		        background: linear-gradient(72deg, #3b9e26, #5ec648);
		        -webkit-background: linear-gradient(72deg, #3b9e26, #5ec648);
		        -moz-background: linear-gradient(72deg, #3b9e26, #5ec648);
		        -ms-background: linear-gradient(72deg, #3b9e26, #5ec648);
		        -o-background: linear-gradient(72deg, #3b9e26, #5ec648);
			}

			#bodyModal{
				background-color: white;
				background-image: url(http://www.programmers.com.br/wp-content/themes/hagens/images/img-riscos.png);
			}

			#bodyModal label{
				color: #1e72ba;
			}

			.dates{
				text-align: center;
				font-style: italic;
				color: #32ff06;
			}

			.new{
				margin: 15px 0;
				text-align: right;
			}

			.btn{
				border-radius: 29px;
				padding: 6px 20px;
				transition: transform 0.5s;
				-webkit-transition: -webkit-transform 0.5s;
				-moz-transition: -moz-transform 0.5s;
				-ms-transition: -ms-transform 0.5s;
				-o-transition: -o-transform 0.5s;
			}

			.btn-info, .btn-info:hover{
				background-color: #1e72ba !important;
				border-color: #1e72ba !important;
			}

			.btn-success, .btn-success:hover{
				background-color: #5dc347 !important;
				border-color: #5dc347 !important;
			}


			.btn:hover{
				transform: scale(1.1);
				-webkit-transform: scale(1.1);
				-moz-transform: scale(1.1);
				-ms-transform: scale(1.1);
				-o-transform: scale(1.1);
			}

			[name="checkOrder"] + i, [name="checkOrderT"] + i{
				display: none;
				transition: transform 1s;
				-webkit-transition: -webkit-transform 1s;
				-moz-transition: -moz-transform 1s;
				-ms-transition: -ms-transform 1s;
				-o-transition: -o-transform 1s;
			}
			[name="checkOrder"]:checked + i, [name="checkOrderT"]:checked + i{
				display: inline-block;
			}
			[name="checkOrder"][desc="1"] + i, [name="checkOrderT"][desc="1"] + i{
				transform: rotateZ(180deg);
				-webkit-transform: rotateZ(180deg);
				-moz-transform: rotateZ(180deg);
				-ms-transform: rotateZ(180deg);
				-o-transform: rotateZ(180deg);
			}


			.fixedTop table{
				table-layout: fixed;
			}
			.fixedTop{
				overflow-x: scroll;
				position: fixed;
				top: 0;
				right: 8px;
				left: 8px;
				background-color: white;
			    box-shadow: 0 3px 2px 0 #134169;
			}

			.btnRemove{
				cursor: pointer;
			}
			.btnRemove span{
				color: red;
				font-style: italic;
				font-weight: 900;
			}

			.fixedTop::-webkit-scrollbar {
				height: 0px !important;
			}
			.fixedTop::-moz-scrollbar {
				height: 0px !important;
			}
			.fixedTop::-ms-scrollbar {
				height: 0px !important;
			}
			.fixedTop::-o-scrollbar {
				height: 0px !important;
			}

			::-webkit-scrollbar {
			    width: 10px;
			    height: 12px;
			}
			::-webkit-scrollbar-thumb {
			    background-color: #1e72ba;
			    border-radius: 29px;
			}
			::-webkit-scrollbar-track {
			    background-color: black;
			}
			::-webkit-scrollbar-button{
				background: #1e72ba;
			}



			::-moz-scrollbar {
			    width: 10px;
			    height: 12px;
			}
			::-moz-scrollbar-thumb {
			    background-color: #1e72ba;
			    border-radius: 29px;
			}
			::-moz-scrollbar-track {
			    background-color: black;
			}
			::-moz-scrollbar-button{
				background: #1e72ba;
			}



			::-ms-scrollbar {
			    width: 10px;
			    height: 12px;
			}
			::-ms-scrollbar-thumb {
			    background-color: #1e72ba;
			    border-radius: 29px;

			}
			::-ms-scrollbar-track {
			    background-color: black;
			}
			::-ms-scrollbar-button{
				background: #1e72ba;
			}



			::-o-scrollbar {
			    width: 10px;
			    height: 12px;
			}
			::-o-scrollbar-thumb {
			    background-color: #1e72ba;
			    border-radius: 29px;
			}
			::-o-scrollbar-track {
			    background-color: black;
			}
			::-o-scrollbar-button{
				background: #1e72ba;
			}
		</style>
		<h1 align="center" class="titulo">Programmer's</h1>

		<div class="new">
			<button type="button" id="btnNew" class="btn btn-info">New</button>
		</div>

		<div id="listUser">
			<?= UserController::listUser() ?>
		</div>

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/sweetalert2.js"></script>
		<script type="text/javascript" src="js/jquery.mask.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$(() => {
				copyTop();
				$(window).scroll();
				$('div:has(a[title^="Hosted on free web"])').remove();
			});
			$(window).resize(() => fixFixedTop())

			function fixFixedTop(){
				i = 1;
				$('#tblUser thead th').each(function(){
					$('.fixedTop thead th:nth-child('+i+')').css({width: $(this).width() + 2});
					i ++;
				})
			}

			function copyTop(){
				$('.fixedTop').remove();
				c = $('#tblUser thead').clone(true).html();
				$('#tblUser').before("<div class=\"fixedTop\" hidden=\"\">"+
													"<table width=\"100%\">"+
														"<thead>"+
															c.replace(/="checkOrder"/g, '="checkOrderT"')+
														"</thead>"+
													"</table>"+
												"</div>");
				$('#tblUser thead').html(c);
				fixFixedTop();
			}

			$('body').on('click', '[id^="trUser"]', function(){
				showUser($(this).attr('id').substring($(this).attr('id').lastIndexOf('r') + 1));
			})

			$('#btnNew').click(() => showUser(0));
			$('body').on('click', 'th:has([name="checkOrder"])', function(){
				i = $(this).find('input');
				if (!i.is(':checked')) {
					i.prop('checked', true);
				}
				else{
					i.attr("desc", (i.attr("desc") == "0" ? "1" : "0"))
				}
				reloadUser();
			})
			$('body').on('click', 'th:has([name="checkOrderT"])', function(){
				$('[name="checkOrder"][value="'+$(this).find('input').val()+'"]').click();
			})

			function maskPhone(){
				$('[name^="txtPhone"]').mask('(99) 9999-99999');
			}

			function showUser(id){
				$('#titleModal').html('User datas')
				$('#footerModal').html('');
				$('#bodyModal').html('');
				$('#modal').modal('show');
				$.ajax({
					type: 'post',
					url: 'ajax_user.php',
					data: 'action=1&id=' + id,
					success: (modal) => {
						$('#bodyModal').html(modal);
						$('#footerModal').html(	"<button type=\"button\" class=\"btn btn-danger\" id=\"btnDelete\">Delete</button>" + 
												"<button type=\"button\" class=\"btn btn-primary\" id=\"btnSave\"></button>")
						maskPhone();
					}
				})
			}

			function reloadUser(){
				o = $('[name="checkOrder"]:checked');
				if (o.length) {
					ordenar = '&' + o.serialize() + '&desc=' + o.attr('desc')
				}
				else{
					ordenar = '';
				}
				$.ajax({
					type: 'post',
					url: 'ajax_user.php',
					data: 'action=4' + ordenar,
					success: (html) => {
						$('#listUser').html(html)
						setTimeout(function() {
							copyTop();
							$(window).scroll();
						}, 100);
					}
				})	
			}

			$(window).scroll(function(){
				if ($(this).scrollTop() >= $('#tblUser').offset().top) {
					$('.fixedTop').removeAttr('hidden');
				}
				else{
					$('.fixedTop').attr('hidden', '');
				}
			});

			$('#listUser').on('scroll', function(){
				$('.fixedTop').scrollLeft($(this).scrollLeft());
			});
		</script>
	</body>

	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
	  	<div class="modal-dialog modal-lg" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" align="center" id="titleModal"></h5>
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          		<span aria-hidden="true" style="color: white;">&times;</span>
		        	</button>
		      	</div>
		      	<div class="modal-body" id="bodyModal"></div>
		      	<div class="modal-footer" id="footerModal">
		      		
		      	</div>
	    	</div>
	  	</div>
	</div>
</html>