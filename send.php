<?php  
	$host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'icstroy_db';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $conn->exec("set names utf8mb4");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        global $conn;

    } 
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

	if ($_POST && !empty($_POST)) {

		$date = $_POST['date'];
		$fullname = $_POST['fullname'];
		$phone = $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);

		$telegram = $_POST['telegram'];
		$add = '';
		$meter = '';
		$for = '';
		if (isset($_POST['radio-add'])) {
			$add = $_POST['radio-add'];
		}

		if (isset($_POST['radio-meter'])) {
			$meter = $_POST['radio-meter'];
		}

		if (isset($_POST['radio-for'])) {
			$for = $_POST['radio-for'];
		}

		$description = $_POST['description'];
		$manager_id = (int)$_POST['manager'];

		if (strlen($phone) == 9) {
          $phone2 = '998'.preg_replace('/[^0-9]/', '', $phone);
        }
        else if(strlen($phone) == 12){
          $phone2 = preg_replace('/[^0-9]/', '', $phone);
          $phone2 = substr($phone2, 3);
        }
        else{
          $phone2 = preg_replace('/[^0-9]/', '', $phone);
        }

        $stmt = $conn->prepare("SELECT * FROM clients where status = ? AND (phone = ? OR phone = ?)");
	    $stmt->execute([1, $phone, $phone2]);
	    $client = $stmt->fetch();

	    if ($client && !empty($client)) {
	    	echo 'client_exist';
	    }
	    else{

	    	$arr = [
	    		'date' => $date,
	    		'name' => $fullname,
	    		'phone' => $phone,
	    		'telegram' => $telegram,
	    		'add' => $add,
	    		'meter' => $meter,
	    		'for' => $for,
	    		'description' => $description,
	    		'manager_id' => $manager_id,
	    	];

	    	$url = "http://127.0.0.1:8000/api/reception";
		    $data = array(
		        "token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
		        "arr" => $arr
		    );

		    $options = array(
		        CURLOPT_URL => $url,
		        CURLOPT_POST => true,
		        CURLOPT_POSTFIELDS => http_build_query($data),
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_HTTPHEADER => array(
		            'Content-Type: application/x-www-form-urlencoded'
		        )
		    );

		    $ch = curl_init();
		    curl_setopt_array($ch, $options);
		    $response = curl_exec($ch);
		    $response = json_decode($response);

		    // echo "<pre>";
		    // print_r($response);
		    // die();


		    if ($response->status == 'client_not_saved' || $response->status == 'fail') {
		        $error = curl_error($ch);
		        echo 'client_not_saved';
		        die();
		    } 
		    else {
		        if (!empty($response) && $response->status == 'success') {
		            echo 'success';
		            die();
		            
		        }
		    }

		    curl_close($ch);
	    }
	}

?>