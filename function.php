<?php
 
 require_once('process.php');



 	function connect(){
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "bank";

			$connect = mysqli_connect($servername, $username, $password, $dbname);

			return $connect;
	}
	
	function trimData($data){
		$data = htmlspecialchars($data);
		$data = trim($data);
		$data = stripcslashes($data);

		return $data;
	}

	function password_encrypt($pass){
		$new_pass = sha1(md5(sha1(md5($pass))));

		return $new_pass;
	}


	function mysql_prep($connect, $string){
		$connect = connect();
		$escape_string = mysqli_real_escape_string($connect, $string);

		return $escape_string;
	}
	function compressImage($source, $destination, $quality){
		// get image info

		$imageinfo = getimagesize($source);
		$mime = $imageinfo['mime'];

		//creata a new image from file

		switch ($mime) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg($source);
				break;
			
			case 'image/png':
				$image = imagecreatefrompng($source);
				break;

			case 'image/gif':
				$image = imagecreatefromgif($source);
				break;
			default:
				$image = imagecreatefromjpeg($source);


		}

		// save image

		imagejpeg($image, $destination, $quality);

		// return compressed image
		return $destination;
	}


	function sqlselect($user_id, $pin, $accnum, $amount){
		$connect = connect();


		$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
		$result = mysqli_query($connect, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$balance = $row['balance'];
			 	if($pin != $row['user_pin']){
			 		$error = 'incorrect pin';
					header("location: my.php?dep=".$error);

			 	}elseif($accnum != $row['user_accnum']){
			 		$error = 'incorrect Account number';
					header("location: my.php?dep=".$error);
			 	}else{
				$balance += $amount;
				sqlinsert($balance, $user_id);

			 	}
			}
		 	

		 	
		} 
			

		
		
	}
	function transfersql($user_id, $pin, $accnum, $desaccnum, $amount){
		$connect = connect();


			$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
		$result = mysqli_query($connect, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$balance = $row['balance'];
			 	if($pin != $row['user_pin']){
			 		$error = 'incorrect pin';
					header("location: my.php?trans=".$error);

			 	}elseif($accnum != $row['user_accnum']){
			 		$error = 'incorrect Account number';
					header("location: my.php?trans=".$error);
			 	}else{
				$balance -= $amount;
				sqlinsert($balance, $user_id);

			 	}
			}
	
		} 
		$sql2 = "SELECT * FROM users WHERE user_accnum = '$desaccnum'";
		$result2 = mysqli_query($connect, $sql2);
		if (mysqli_num_rows($result2)) {
			while ($row2 = mysqli_fetch_assoc($result2)) {
				$balance = $row2['balance'];
			 	if($desaccnum != $row2['user_accnum']){
			 		$error = 'Destination acount not found';
					header("location: my.php?trans=".$error);

			 	}else{
				
				transinsert($amount, $desaccnum, $balance);

			 	}
			}
	
		} 
			

		
		
	}
	function transinsert($amount, $desaccnum, $balance){
		$connect = connect();


		$balance += $amount;
		
		$sql = "UPDATE `users` SET `balance` = '$balance' WHERE `user_accnum` = '$desaccnum'";

		$result = mysqli_query($connect, $sql);
		if ($result) {
			$success = 'transfer succesfull';
			header("location: my.php?trans=".$success);
		}else {
			$error = 'error error transfering';
			header("location: my.php?trans=".$error);
		}
	}
	function sqlinsert($balance, $user_id){
		$connect = connect();

		
		$sql = "UPDATE `users` SET `balance` = '$balance' WHERE `user_id` = '$user_id'";

		$result = mysqli_query($connect, $sql);
		if ($result) {
			$success = 'amount deposited';
			header("location: my.php?dep=".$success);
		}else {
			$error = 'error depositing';
			header("location: my.php?dep=".$error);
		}
	}


function withsql($user_id, $pin, $accnum, $amount){
	$connect = connect();

	$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
	$result = mysqli_query($connect, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$balance = $row['balance'];
		 	if($pin != $row['user_pin']){
		 		$error = 'incorrect pin';
				header("location: my.php?with=".$error);

		 	}elseif($accnum != $row['user_accnum']){
		 		$error = 'incorrect Account number';
				header("location: my.php?with=".$error);
		 	}else{
				$balance -= $amount;
				$sql2 = "UPDATE `users` SET `balance` = '$balance' WHERE `user_id` = '$user_id'";

				$result2 = mysqli_query($connect, $sql2);
				if ($result2) {
					$success = 'money withdrawn';
					header("location: my.php?with=".$success);
				}else {
					$error = 'error withdrawing';
					header("location: my.php?with=".$error);
				}

			 	
			} 
			
		}
	}		
}
function bill($user_id, $pin, $accnum, $amount, $res){
	$connect = connect();


	$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
	$result = mysqli_query($connect, $sql);
	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$balance = $row['balance'];
		 	if($pin != $row['user_pin']){
		 		$error = 'incorrect pin';
				header("location: my.php?with=".$error);

		 	}elseif($accnum != $row['user_accnum']){
		 		$error = 'incorrect Account number';
				header("location: my.php?$res=".$error);
		 	}else{
				$balance -= $amount;
				$sql2 = "UPDATE `users` SET `balance` = '$balance' WHERE `user_id` = '$user_id'";

				$result2 = mysqli_query($connect, $sql2);
				if ($result2) {
					$success = 'transaction succesfull';
					header("location: my.php?$res=".$success);
				}else {
					$error = 'error paying bill';
					header("location: my.php?$res=".$error);
				}

			 	
			} 
			
		}
	}		
}







?>