<?php
	include_once("function/helper.php");
	include_once("function/koneksi.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<script type="text/javascript" src="<?= base_url."assets/jQuery-2.2.4/jquery-2.2.4.min.js" ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?= base_url."assets/Bootstrap-3.3.7/css/bootstrap.min.css"; ?>"/>
		<title>Latihan dataTable Server-Side</title>
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
					<h4><strong>Latihan dataTable Server-Side</strong></h4>
					<ol>
						<li>Data Provinsi
							<ul>
								<li>
									<a href="<?= base_url."provinsi/listAjax.php" ?>" target="_blank">
										Versi Ajax Modals
									</a>
									<li>
									<a href="<?= base_url."provinsi/list.php" ?>" target="_blank">
										Versi Ajax non-modal
									</a>
								</li>
								</li>
							</ul>
						</li>
						<li>Data Kota/Kabupaten
							<ul>
								<li>
									<a href="<?= base_url."kota/listAjax.php" ?>" target="_blank">
										Versi Ajax Modals
									</a>
									<li>
									<a href="<?= base_url."provinsi/list.php" ?>" target="_blank">
										Versi Ajax non-modal
									</a>
								</li>
								</li>
							</ul>
						</li>
						<li>Data Kecamatan
							<ul>
								<li>
									<a href="<?= base_url."kecamatan/listAjax.php" ?>" target="_blank">
										Versi Ajax Modals
									</a>
									<li>
									<a href="<?= base_url."provinsi/list.php" ?>" target="_blank">
										Versi Ajax non-modal
									</a>
								</li>
								</li>
							</ul>
						</li>
						<li>Data Kelurahan
							<ul>
								<li>
									<a href="<?= base_url."kelurahan/listAjax.php" ?>" target="_blank">
										Versi Ajax Modals
									</a>
									<li>
									<a href="<?= base_url."provinsi/list.php" ?>" target="_blank">
										Versi Ajax non-modal
									</a>
								</li>
								</li>
							</ul>
						</li>
					</ol>
					<br>
					<p class="small">* Versi Ajax Modals: CRUD menggunakan metode php-ajax dimana modal sebagai form tambah/edit</p>
					<p class="small">* Versi Ajax non-modal: CRUD menggunakan metode php-ajax dimana formnya adalah page yang baru</p>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="<?= base_url."assets/Bootstrap-3.3.7/js/bootstrap.min.js"; ?>"></script>
        <!-- js custom -->
        <script type="text/javascript">
        	$(document).ready(function(){
    
        	});
        </script>
	</body>
</html>