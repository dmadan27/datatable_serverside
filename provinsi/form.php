<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");

	$id = isset($_GET['id']) ? $_GET['id'] : false;

	if($id) $btn = "edit";
	else $btn = "tambah";
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<script type="text/javascript" src="<?= base_url."assets/jQuery-2.2.4/jquery-2.2.4.min.js" ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?= base_url."assets/Bootstrap-3.3.7/css/bootstrap.min.css"; ?>"/>
		<link rel="stylesheet" type="text/css" href="<?= base_url."assets/DataTables/DataTables-1.10.15/css/dataTables.bootstrap.min.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url."assets/DataTables/Responsive-2.1.1/css/responsive.bootstrap.min.css"; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url."assets/alertifyjs/css/alertify.min.css"; ?>"/>
		<title>Data Provinsi</title>
		<style type="text/css">
			body{
				padding-top: 50px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4>Form <?= ucfirst($btn); ?> Data Provinsi</h4>
					<form id="formProv" role="form" enctype="multipart/form-data">
						<!-- field id -->
		                    <div class="form-group">
		                        <label for="idProv">ID Provinsi</label>
		                        <input type="text" id="idProv" name="idProv" class="form-control" placeholder="Masukkan ID Provinsi">
		                        <span class="help-block small"></span>
		                    </div>
		                   	<!-- field nama provinsi -->
		                    <div class="form-group">
		                        <label for="namaProv">Nama Provinsi</label>
		                        <input type="text" name="namaProv" id="namaProv" class="form-control" placeholder="Masukkan Nama Provinsi">
								<span class="help-block small"></span>
							</div>
						<!-- button -->
						<div class="form-group">
							<input class="btn btn-success" type="submit" id="btn_submit" name="action" value="<?= ucfirst($btn); ?>">
		                	<a type="button" class="btn btn-default" href="<?= base_url."provinsi/list.php"; ?>">Batal</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="<?= base_url."assets/Bootstrap-3.3.7/js/bootstrap.min.js"; ?>"></script>
        <!-- js custom -->
        <script type="text/javascript">
        	$(document).ready(function(){
        		var base_url = "<?php print base_url; ?>";
        		var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;

        		// jQuery.isEmptyObject({});

        		console.log(jQuery.isEmptyObject(urlParams.id));
        		console.log(urlParams);
        		// if(urlParams) console.log("edit");
        		// else console.log("tambah");

        		$("#formProv").submit(function(e){
        			e.preventDefault();
                	var idProv = $("#idProv").val().trim();
                	var namaProv = $("#namaProv").val().trim();
                	var submit = $("#btn_submit").val();

                	$.ajax({
                		url: "action.php",
	        			type: "post",
	        			dataType: "json",
	        			data: {
	        				"idProv" : idProv,
	        				"namaProv" : namaProv,
	        				"action" : submit,
	        			},
	        			success: function(hasil){
	        				if(hasil.status){
	        					// arahkan ke page list
	        					document.location=base_url+"provinsi/list.php";
	        				}
	        				else{
	        					if(hasil.errorDb){
	        						alert("Koneksi Database Error, Silahkan Coba Lagi");
	        						$('#formProv').trigger('reset');
	        					}
	        					else{
	        						// set error dan value idProv
		        					$("#idProv").parent().find('.help-block').text("");
		        					if(hasil.pesanError.idProvError !== ""){
		        						$("#idProv").parent().find('.help-block').text(hasil.pesanError.idProvError);
		        						$("#idProv").closest('div').addClass('has-error');
		        					}
		        					$("#idProv").val(hasil.set_value.idProv);

		        					// set error dan value namaProv
		        					$("#namaProv").parent().find('.help-block').text("");
		        					if(hasil.pesanError.namaProvError !== ""){
		        						$("#namaProv").parent().find('.help-block').text(hasil.pesanError.namaProvError);
			        					$("#namaProv").closest('div').addClass('has-error');
		        					}	
		        					$("#namaProv").val(hasil.set_value.namaProv);
	        					}	
	        				}
	        			},
	        			error: function (jqXHR, textStatus, errorThrown) // error handling
				        {
				        	alert("Operasi Gagal");
				            console.log(jqXHR, textStatus, errorThrown);
				        }
                	})

                	return false;
        		});

        		// cek status form, tambah/edit
        		if(!jQuery.isEmptyObject(urlParams.id)){ // jika ada parameter get
        			edit_prov(urlParams.id);
        		}
        	

        	});

        	// fungsi get data edit
        	function edit_prov(id){
        		$.ajax({
        			url: "action.php",
        			type: "post",
        			dataType: "json",
        			data: {
        				"id" : id,
        				"action" : "getEdit",
        			},
        			success: function(data){
        				// reset form
        				// $("#idProv").parent().find('.help-block').text("");
        				// $("#idProv").closest('div').removeClass('has-error');
        				// $("#namaProv").parent().find('.help-block').text("");
        				// $("#namaProv").closest('div').removeClass('has-error');

		        		$("#idProv").val(id);
		        		$("#idProv").prop("disabled", true);
		        		$("#namaProv").val(data.name);
		        		$("#btn_submit").prop("value", "Edit");
        			},
        			error: function (jqXHR, textStatus, errorThrown) // error handling
			        {
			            alert("Operasi Gagal");
			            console.log(jqXHR, textStatus, errorThrown);
			        }
        		})
            	// console.log(id);
            }

        </script>
	</body>
</html>