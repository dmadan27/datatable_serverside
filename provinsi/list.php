<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");

	session_start();

	$notif = isset($_SESSION['notif']) ? $_SESSION['notif'] : false;
	// var_dump($notif);
	unset($_SESSION['notif']);
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
				padding-bottom: 50px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row" style="padding-bottom: 20px">
				<div class="col-md-12">
					<a href="<?= base_url."provinsi/form.php"; ?>" role="button" class="btn btn-primary" id="btn_tambah">Tambah</a>
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

		<script type="text/javascript" src="<?= base_url."assets/Bootstrap-3.3.7/js/bootstrap.min.js"; ?>"></script>
		<!-- DataTables -->
        <script type="text/javascript" src="<?= base_url."assets/DataTables/DataTables-1.10.15/js/jquery.dataTables.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/DataTables/DataTables-1.10.15/js/dataTables.bootstrap.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/DataTables/Responsive-2.1.1/js/dataTables.responsive.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/DataTables/Responsive-2.1.1/js/responsive.bootstrap.min.js"; ?>"></script>
        <script type="text/javascript" src="<?= base_url."assets/alertifyjs/alertify.min.js"; ?>"></script>
        
        <?php 
        	if($notif){
        		?>
        			<script>
        				var notif = "<?php echo $notif; ?>";
        				alertify.success(notif);
        			</script>
        		<?php
        	} 
        ?>

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
                    "order": [],
                    processing: true,
					serverSide: true,
					ajax: {
				 		url: "action.php",
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

        	});
        </script>
	</body>
</html>