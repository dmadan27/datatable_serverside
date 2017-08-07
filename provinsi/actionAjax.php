<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");

	// session_start();

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	// $action = "edit";

	// proteksi halaman
	if(!$action){
		die("Dilarang Akses Halaman Ini !!");
	}
	else{
		if(strtolower($action) === "list") listAjax($koneksi); // list datatable
		else if(strtolower($action) === "tambah") actionAdd($koneksi); // aksi tambah
		else if(strtolower($action) === "getedit"){ // get data untuk edit
			$id = isset($_POST['id']) ? $_POST['id'] : false;
			getEdit($koneksi, $id);
		}
		else if(strtolower($action) === "edit") actionEdit($koneksi); // aksi edit
	}

	// fungsi list datatable
	function listAjax($koneksi){
		// configurasi tabel yg diinginkan
		$config_db = array(
			'tabel' => 'provinces',
			'kolomOrder' => array(null, 'id', 'name', null),
			'kolomCari' => array('id', 'name'),
			'orderBy' => array('id' => 'asc'),
		);

		// panggil fungsi get datatable
		$query = get_dataTable($config_db);

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		// siapkan data
		$data = array();
		$no_urut = $_POST['start'];
		foreach($result as $row){
			$no_urut++;
			$aksi = '<button type="button" class="btn btn-success" onclick="edit_prov('."'".$row["id"]."'".')">Edit</button>';
			
			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['id'];
			$dataRow[] = $row['name'];
			$dataRow[] = $aksi;

			$data[] = $dataRow;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => recordTotal($koneksi, $config_db['tabel']),
			'recordsFiltered' => recordFilter($koneksi, $config_db),
			'data' => $data,
		);

		echo json_encode($output);
	}

	function setQuery($tabel, $kolomOrder, $kolomCari, $orderBy){
		// inisialisasi request datatable
		$search = isset($_POST['search']['value']) ? $_POST['search']['value'] : false;
		$order = isset($_POST['order']) ? $_POST['order'] : false;

		$query = "SELECT * FROM $tabel ";

		// jika ada request pencarian
		$qWhere = "";
		$i = 0;
		foreach($kolomCari as $cari){
			if($search){
				if($i === 0) $qWhere .= 'WHERE '.$cari.' LIKE "%'.$search.'%" ';
				else $qWhere .= 'OR '.$cari.' LIKE "%'.$search.'%"';
			}
			$i++;
		}

		// jika ada request order
		$qOrder = "";
		if($order) $qOrder = 'ORDER BY '.$kolomOrder[$order[0]['column']].' '.$order[0]['dir'].' ';
		else $qOrder = 'ORDER BY '.key($orderBy).' '.$orderBy[key($orderBy)]; // order default

		$query .= "$qWhere $qOrder ";

		return $query;	
	}

	// fungsi get datatable
	function get_dataTable($config_db){
		$query = setQuery($config_db['tabel'], $config_db['kolomOrder'], $config_db['kolomCari'], $config_db['orderBy']);
		
		$qLimit = "";
		if($_POST['length'] != -1) $qLimit .= 'LIMIT '.$_POST['start'].', '.$_POST['length'];
		
		$query .= "$qLimit";

		return $query;
	}

	function recordFilter($koneksi, $config_db){
		$query = setQuery($config_db['tabel'], $config_db['kolomOrder'], $config_db['kolomCari'], $config_db['orderBy']);
		$statement = $koneksi->prepare($query);
		$statement->execute();

		return $statement->rowCount();
	}

	function recordTotal($koneksi, $tabel){
		$statement = $koneksi->query("SELECT COUNT(*) FROM $tabel")->fetchColumn();

		return $statement;
	}

	// fungsi action add
	function actionAdd($koneksi){
		$id = isset($_POST['idProv']) ? $_POST['idProv'] : false;
		$name = isset($_POST['namaProv']) ? $_POST['namaProv'] : false;

		// validasi
			// inisialisasi
			$cek = true;
			$pesanError = $idProvError = $namaProvError = $set_value = "";
			// inisialisasi pemanggilan fungsi validasi
			$validIdProv = validAngka("ID Provinsi", $id, 1, 2, true);
			$validNamaProv = validString("Nama Provinsi", $name, 1, 225, true);

			// cek valid
			if(!$validIdProv['cek']){
				$cek = false;
				$idProvError = $validIdProv['error'];
			}

			if(!$validNamaProv['cek']){
				$cek = false;
				$namaProvError = $validNamaProv['error'];
			}
		// ==================================== //
		if($cek){
			$id = validInputan($id, false, false);
			$name = validInputan($name, false, false);

			$tabel = "provinces";
			$query = "INSERT INTO $tabel (id, name) VALUES (:id, :name)";

			// prepare
			$statement = $koneksi->prepare($query);
			// bind
			$statement->bindParam(':id', $id);
			$statement->bindParam(':name', $name);
			// execute
			$result = $statement->execute(
				array(
					':name' => $name,
					':id' => $id,
				)
			);
			
			// jika query berhasil
			if($result){
				$output = array(
					'status' => true,
					'errorDb' => false,
				);
			} 
			else{
				$output = array(
					'status' => false,
					'errorDb' => true,
				);
			}

			echo json_encode($output);
		}
		else{
			$pesanError = array(
				'idProvError' => $idProvError,
				'namaProvError' => $namaProvError, 
			);

			$set_value = array(
				'idProv' => $id,
				'namaProv' => $name,
			);

			$output = array(
				'status' => false,
				'errorDb' => false,
				'pesanError' => $pesanError,
				'set_value' => $set_value,
			);

			echo json_encode($output);
		}
	}

	// fungsi get data edit
	function getEdit($koneksi, $id){
		// $id = "11";
		$tabel = "provinces";
		// query
		$query = "SELECT id, name FROM $tabel WHERE id = :id";

		// prepare
		$statement = $koneksi->prepare($query);
		// bind
		$statement->bindParam(':id', $id);
		// execute
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		echo json_encode($result);
	}

	// fungsi action edit
	function actionEdit($koneksi){
		$id = isset($_POST['idProv']) ? $_POST['idProv'] : false;
		$name = isset($_POST['namaProv']) ? $_POST['namaProv'] : false;

		// validasi
			// inisialisasi
			$cek = true;
			$pesanError = $idProvError = $namaProvError = $set_value = "";
			// inisialisasi pemanggilan fungsi validasi
			$validIdProv = validAngka("ID Provinsi", $id, 1, 2, true);
			$validNamaProv = validString("Nama Provinsi", $name, 1, 225, true);

			// cek valid
			if(!$validIdProv['cek']){
				$cek = false;
				$idProvError = $validIdProv['error'];
			}

			if(!$validNamaProv['cek']){
				$cek = false;
				$namaProvError = $validNamaProv['error'];
			}
		// ==================================== //

		if($cek){
			$id = validInputan($id, false, false);
			$name = validInputan($name, false, false);

			$tabel = "provinces";
			$query = "UPDATE $tabel SET name = :name WHERE id = :id";

			// prepare
			$statement = $koneksi->prepare($query);
			// bind
			$statement->bindParam(':name', $name);
			$statement->bindParam(':id', $id);
			// execute
			$result = $statement->execute(
				array(
					':name' => $name,
					':id' => $id,
				)
			);
			
			// jika query berhasil
			if($result){
				$output = array(
					'status' => true,
					'errorDb' => false,
				);
			} 
			else{
				$output = array(
					'status' => false,
					'errorDb' => true,
				);
			}

			echo json_encode($output);
		}
		else{
			$pesanError = array(
				'idProvError' => $idProvError,
				'namaProvError' => $namaProvError, 
			);

			$set_value = array(
				'idProv' => $id,
				'namaProv' => $name,
			);

			$output = array(
				'status' => false,
				'errorDb' => false,
				'pesanError' => $pesanError,
				'set_value' => $set_value,
			);

			echo json_encode($output);
		}
	}