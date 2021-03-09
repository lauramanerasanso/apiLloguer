<?php

	include 'apiRedsys.php';

	// Se crea Objeto
	$miObj = new RedsysAPI;


	if (!empty( $_POST ) ) {//URL DE RESP. ONLINE
					
					$version = $_POST["Ds_SignatureVersion"];
					$datos = $_POST["Ds_MerchantParameters"];
					$signatureRecibida = $_POST["Ds_Signature"];
					

					$decodec = $miObj->decodeMerchantParameters($datos);	
					$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
					$firma = $miObj->createMerchantSignatureNotif($kc,$datos);	


					//echo $firma."<br/>";
					//echo $signatureRecibida."<br/>";
					if ($firma === $signatureRecibida){
						$dadesPagament = json_encode([
							"success" => true,
							"version" => $version,
							"params" => $datos,
							"signature" => $signatureRecibida
						]);
						echo $dadesPagament;
					} else {
						$dadesPagament = json_encode([
							"success" => false
						]);
						echo $dadesPagament;
					}
	}
	else{
		if (!empty( $_GET ) ) {//URL DE RESP. ONLINE
				
			$version = $_GET["Ds_SignatureVersion"];
			$datos = $_GET["Ds_MerchantParameters"];
			$signatureRecibida = $_GET["Ds_Signature"];
				
		
			$decodec = $miObj->decodeMerchantParameters($datos);
			$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
			$firma = $miObj->createMerchantSignatureNotif($kc,$datos);
		
			if ($firma === $signatureRecibida){
				$dadesPagament = json_encode([
					"success" => true,
					"version" => $version,
					"params" => $datos,
					"signature" => $signatureRecibida
				]);
				echo $dadesPagament;
			} else {
				$dadesPagament = json_encode([
					"success" => false
				]);
				echo $dadesPagament;
			}
		}
		else{
			die("No se recibió respuesta");
		}
	}

?>