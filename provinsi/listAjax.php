<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");

	// print_r(PDO::getAvailableDrivers());
	// session_start();
	// var_dump($_SESSION['test']);
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
		<title>Data Provinsi (Ajax Modals)</title>
		<style type="text/css">
			body{
				padding-top: 50px;
				padding-bottom: 50px;
			}
			.loadingPage{
				display: none;
				position: fixed;
				z-index: 1000;
				top: 0;
				left: 0;
				height: 100%;
				width: 100%;
				background: rgba( 255, 255, 255, .8 ) 
                			url('pIkfp.gif') 
                			50% 50% 
                			no-repeat;
			}
			body.loading {
    			overflow: hidden;   
			}
			body.loading .loadingPage{
				display: block;
			}

		</style>
	</head>
	<body>
		<div class="container">
			<div class="row" style="padding-bottom: 20px">
				<div class="col-md-12">
					<button type="button" class="btn btn-primary" id="btn_tambah">Tambah</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table id="table_prov" class="table table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>Provinsi</th>
								<th>Aksi</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>

		<div class="loadingPage"></div>

		<!-- modal edit -->
		<div class="modal fade" id="modalProv">
		    <div class="modal-dialog modal-sm">
		        <div class="modal-content">
		            <div class="modal-header">
		                <!-- button close -->
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
		                <!-- header modal -->
		                <h4 class="modal-title"></h4>
		            </div>
		            <div class="modal-body">
		                <form id="form_modalProv" role="form" enctype="multipart/form-data">
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
		            </div>
		            <div class="modal-footer">
		            	<input class="btn btn-success" type="submit" id="btn_submit" name="action" value="Tambah">
	                	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	            	</form>
		            </div>
		        </div>
		    </div>
		</div>


		<script type="text/javascript" src="<?= base_url."assets/Bootstrap-3.3.7/js/bootstrap.min.js"; ?>"></script>
		<!-- DataTables -->
        <script type="text/javascript" src="<?= base_url."assets/DataTables/DataTables-1.10.15/js/jquery.dataTables.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/DataTables/DataTables-1.10.15/js/dataTables.bootstrap.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/DataTables/Responsive-2.1.1/js/dataTables.responsive.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/DataTables/Responsive-2.1.1/js/responsive.bootstrap.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/alertifyjs/alertify.min.js"; ?>"></script>
        <!-- js custom -->
        <script type="text/javascript">
        	$(document).ready(function(){

        		// setting datatable server-side
        		var table_prov = $("#table_prov").DataTable({
                    "language" : {
                        "lengthMenu": "Tampilkan _MENU_ data/page",
                        "zeroRecords": "Data Tidak Ada",
                        "info": "Menampilkan _START_ s.d _END_ dari _TOTAL_ data",
                        "infoEmpty": "Menampilkan 0 s.d 0 dari 0 data",
                        "search": "Pencarian:",
                        "loadingRecords": "Loading...",
    					"processing": "Processing...",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    },
                    "lengthMenu": [ 25, 50, 75, 100 ],
                    "pageLength": 25,
                    order: [],
                    processing: true,
					serverSide: true,
					ajax: {
				 		url: "actionAjax.php",
				  		type: 'POST',
				  		data: {
				  			"action" : "list",
				  		}

					},
					"columnDefs": [
						{
							"targets":[0, 3], // disable order di kolom 1 dan 3
							"orderable":false,
						}
					],
                });
                console.log(table_prov);

        		// btn tambah onclick
        		$("#btn_tambah").click(function(){
        			$("#idProv").prop("disabled", false);
        			$("#idProv").parent().find('.help-block').text("");
    				$("#idProv").closest('div').removeClass('has-error');
    				$("#namaProv").parent().find('.help-block').text("");
    				$("#namaProv").closest('div').removeClass('has-error');
        			// tampilkan modal
        			$('#form_modalProv').trigger('reset');
	        		$("#modalProv .modal-title").html("Form Tambah Data");
	        		$("#btn_submit").prop("value", "Tambah");
	            	$("#modalProv").modal();
        		});

                // btn submit onclick
                $("#form_modalProv").submit(function(e){
                	e.preventDefault();
                	var idProv = $("#idProv").val().trim();
                	var namaProv = $("#namaProv").val().trim();
                	var submit = $("#btn_submit").val();

            		$.ajax({
            			url: "actionAjax.php",
	        			type: "post",
	        			dataType: "json",
	        			data: {
	        				"idProv" : idProv,
	        				"namaProv" : namaProv,
	        				"action" : submit,
	        			},
	        			success: function(hasil){
	        				if(hasil.status){ // jika status true
	        					$('#form_modalProv').trigger('reset');
		        				$("#modalProv").modal('hide');
		        				if(submit.toLowerCase()==="edit") alertify.success('Data Berhasil Diedit');
		        				else alertify.success('Data Berhasil Ditambah');
		        				table_prov.ajax.reload();
	        				}
	        				else{ // jika status false
	        					// cek jenis error
	        					if(hasil.errorDb){
	        						alert("Koneksi Database Error, Silahkan Coba Lagi");
	        						$('#form_modalProv').trigger('reset');
		        					$("#modalProv").modal('hide');
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

	        				console.log(hasil);
	        			},
	        			error: function (jqXHR, textStatus, errorThrown) // error handling
				        {
				        	alert("Operasi Gagal");
				            console.log(jqXHR, textStatus, errorThrown);
				        }
            		})

                	return false;
                })

        	});
			
			// fungsi get data edit
        	function edit_prov(id){
        		$.ajax({
        			url: "actionAjax.php",
        			type: "post",
        			dataType: "json",
        			data: {
        				"id" : id,
        				"action" : "getEdit",
        			},
        			beforeSend: function(){
        				$("body").addClass("loading");
        			},
        			success: function(data){
        				$("body").removeClass("loading");
        				// reset modal
        				$("#idProv").parent().find('.help-block').text("");
        				$("#idProv").closest('div').removeClass('has-error');
        				$("#namaProv").parent().find('.help-block').text("");
        				$("#namaProv").closest('div').removeClass('has-error');

        				// tampilkan modal
		        		$("#modalProv .modal-title").html("Form Edit Data");
		        		$("#idProv").val(id);
		        		$("#idProv").prop("disabled", true);
		        		$("#namaProv").val(data.name);
		        		$("#btn_submit").prop("value", "Edit");
		            	$("#modalProv").modal();
		          		// alert(data.name);
        			},
        			error: function (jqXHR, textStatus, errorThrown) // error handling
			        {
			            alert('Error get data from ajax');
			        }
        		})
            	// console.log(id);
            }

        </script>
	</body>
</html>