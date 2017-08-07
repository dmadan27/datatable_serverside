<?php
	/*
		template fungsi validasi
		# format tempalte:
			=> cek require --> cek kosong --> cek pattern --> cek min-max
		# agar penulisan fungsi yg lainnnya lebih mudah
	*/
	function validTemplate($label, $value, $min, $max, $required, $cek, $error, $pattern){
		// cek required
		if($required){ // jika wajib
			// cek kosong
			if(empty($value)){ // jika kosong
				$setError = $error['empty'];
				$cek = false;
			}
			else{
				// cek pattern
				if(!preg_match($pattern, $value)){ // jika tidak sesuai
					$setError = $error['pattern'];
					$cek = false;
				}
				else{
					// cek min-max karakter
					if(strlen($value) >= $min && strlen($value) <= $max){ // jika sesuai
						$setError = "";
						$cek = true;
					}
					else{
						$setError = $error['length'];
						$cek = false;
					}
				}
			}
		}
		else{ // jika opsional
			// jika diisi cek pattern --> cek max
			if(!empty($value)){ // jika diisi
				// cek pattern
				if(!preg_match($pattern, $value)){ // jika tidak sesuai
					$setError = $error['pattern'];
					$cek = false;
				}
				else{
					// cek min-max karakter
					if(strlen($value) <= $max){ // jika sesuai
						$setError = "";
						$cek = true;
					}
					else{
						$setError = $error['length'];
						$cek = false;
					}
				}
			}
			else{ // jika kosong
				$setError = "";
				$cek = true;
			}
		}
			
		$output = array(
			'cek' => $cek,
			'error' => $setError,
		);
		
		return $output;
	}
	/*
		fungsi validasi untuk tipe data string/alphanumeric (hanya huruf, angka, dan spasi)
		# $label --> string yang ingin ditampilkan sebagai pesan
		# $value --> nilai dari $_POST
		# $min --> min karakter
		# $max --> max karakter
		# $required --> wajib diisi atau tidak (true - false)
	*/
	function validString($label, $value, $min, $max, $required){
		// inisialisasi
		$cekValid['cek'] = true;
		$cekValid['error'] = array(
			'empty' => $label." Harus Diisi",
			'pattern' => $label." Harus Berupa Huruf atau Angka",
			'length' => "Panjang $label Min. $min dan Maks. $max Karakter",
		);
		$cekValid['value'] = trim($value);
		$pattern = "/^[ \w#-]+$/";

		$output = validTemplate(
			$label, $cekValid['value'], $min, $max, 
			$required, $cekValid['cek'], $cekValid['error'], $pattern
		);

		return $output;
	}

	/*
		fungsi validasi untuk tipe data angka saja
		# $label --> string yang ingin ditampilkan sebagai pesan
		# $value --> nilai dari $_POST
		# $min --> min karakter
		# $max --> max karakter
		# $required --> wajib diisi atau tidak (true - false)
	*/
	function validAngka($label, $value, $min, $max, $required){
		// inisialisasi
		$cekValid['cek'] = true;
		$cekValid['error'] = array(
			'empty' => $label." Harus Diisi",
			'pattern' => $label." Harus Berupa Angka",
			'length' => "Panjang $label Min. $min dan Maks. $max Karakter",
		);
		$cekValid['value'] = trim($value);
		$pattern = "/^[0-9]*$/";

		$output = validTemplate(
			$label, $cekValid['value'], $min, $max, 
			$required, $cekValid['cek'], $cekValid['error'], $pattern
		);

		return $output;
	}

	/*
		fungsi validasi untuk tipe data huruf saja dan spasi
		# $label --> string yang ingin ditampilkan sebagai pesan
		# $value --> nilai dari $_POST
		# $min --> min karakter
		# $max --> max karakter
		# $required --> wajib diisi atau tidak (true - false)
	*/
	function validHuruf($label, $value, $min, $max, $required){
		// inisialisasi
		$cekValid['cek'] = true;
		$cekValid['error'] = array(
			'empty' => $label." Harus Diisi",
			'pattern' => $label." Harus Berupa Huruf",
			'length' => "Panjang $label Min. $min dan Maks. $max Karakter",
		);
		$cekValid['value'] = trim($value);
		$pattern = "/^[0-9]*$/";

		$output = validTemplate(
			$label, $cekValid['value'], $min, $max, 
			$required, $cekValid['cek'], $cekValid['error'], $pattern
		);

		return $output;
	}

	/*
		validasi inputan - untuk menghilangkan injeksi
		# $data --> data/inputan yang ingin di amankan
		# $cekArray --> jenis data apakah array atau bukan - true/false
		# $cekPassEmail --> jenis data email/pass - true/false
	*/
	function validInputan($data, $cekArray, $cekPassEmail){
		if(!$cekArray){ // jika false maka bukan array
			$data = trim($data);
			// hilangkan tag-tag dan jgn render jika mengandung tag-tag
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			// jika bukan email/pass maka uppercase
			if(!$cekPassEmail) $data = strtoupper($data);
		}
		else{
			foreach($data as $valueData){
				$valueData = trim($valueData);
				$valueData = stripslashes($valueData);
				$valueData = htmlspecialchars(strtoupper($valueData));
			}
		}

		return $data;
	}


	// // uji coba
	// $label = "Nama";
	// $value = "kimocai";
	// $min = 1;
	// $max = 20;
	// $required = false;

	// $validNamaProv = validString(
	// 			$label, 
	// 			validInputan($value, false, false), 
	// 			1, 225, true
	// 		);

	// var_dump($validNamaProv);