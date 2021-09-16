<?php

require_once('function.php');

if (isset($_POST['back'])) {
	header("location: index.php?");	
	
}
if (isset($_POST['bills'])) {
	$in = 4;
	header("location: index.php?dash=".$in);	
	
}
if (isset($_POST['submit'])) {
	$input = isset($_POST['input'])? trim($_POST['input']): '';

	if($input == ""){
		$error = "All fields required line 9";
		header("location: index.php?error=".$error);

	}else{

		header("location: index.php?output=".$input);	
	}
	
}
if (isset($_POST['dash'])) {
	$input = isset($_POST['dashh'])? trim($_POST['dashh']): '';
     
	if($input == " "){
		$error = "All fields required line 24";
		header("location: index.php?error=".$error);

	}else{

		header("location: index.php?dash=".$input);	
	}
	
}



if (isset($_POST['reg'])) {
	$name = isset($_POST['name'])? trim($_POST['name']): '';
	$password = isset($_POST['password'])? trim($_POST['password']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';
	$accountnum = isset($_POST['accountnum'])? trim($_POST['accountnum']): '';


	if ($name == '' || $password == '' || $pin == '' || $accountnum == '') {
		$error = "All fields required line 31";
		header("location: index.php?errorreg=".$error);
	}else{
		$name = mysql_prep($connect, $name);
		$newpass = password_encrypt($password);
		$newpass = mysql_prep($connect, $newpass);
		$pin = mysql_prep($connect, $pin);

		$sql = "INSERT INTO users (user_name, user_password, user_pin, user_accnum) VALUES ('$name', '$newpass', '$pin', '$accountnum')";
		$result = mysqli_query($connect, $sql);
		if ($result) {
		 	$success = "registration succesfull";
			header("location: index.php?success=".$success);

		}else{
			$error = "error resgistering";
			header("location: index.php?error=".$error);
		} 

	}
	
}
if (isset($_POST['log'])) {
	$name = isset($_POST['name'])? trim($_POST['name']): '';
	$password = isset($_POST['password'])? trim($_POST['password']): '';

	if ($name == '' || $password == ''){
		$error = "All fields required";
		header("location: index.php?error=".$error);
	}else{

		$new_pass = password_encrypt($password);
		$name = mysql_prep($connect, $name);
		$new_pass = mysql_prep($connect, $new_pass);

		$sql1 = "SELECT * FROM users WHERE user_name = '$name' AND user_password = '$new_pass'";
		$result1 = mysqli_query($connect, $sql1);

		if(mysqli_num_rows($result1)){
			while ($row = mysqli_fetch_assoc($result1)) {
				session_start();
				$_SESSION['id'] = $row['user_id'];
				$_SESSION['name'] = $row['user_name'];
				
				if(isset($_SESSION['id'])){
					setcookie('bank', base64_encode(json_encode(['name'
						=> $_SESSION['name'], 'id' => $_SESSION['id']])),
					time() + (86400 * 120), "/");

				}else{
					$failed = "name or password is inccorect";
					header('location: index.php?error='.$failed);
				}
				$success = 'session started';
				header('location: index.php?session='.$success);
			}
		}else{
				$notfound = "name not found";
				header('location: index.php?error='.$notfound);
		}
	
	}

}

if (isset($_POST['dep'])) {
	
	$accnum = isset($_POST['accnum'])? trim($_POST['accnum']): '';
	$amount = isset($_POST['amount'])? trim($_POST['amount']): '';
	$user_id = isset($_POST['id'])? trim($_POST['id']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';


	if ($accnum == '' || $amount == '' || $pin == '') {
		$error = "All fields required";
		header("location: index.php?dep=".$error);
	}else{
		$accnum = mysql_prep($connect, $accnum);
		$amount = mysql_prep($connect, $amount);
		$user_id = mysql_prep($connect, $user_id);
		$pin = mysql_prep($connect, $pin);

		sqlselect($user_id, $pin, $accnum, $amount);

	}

}

if (isset($_POST['trans'])) {
	
	$accnum = isset($_POST['accnum'])? trim($_POST['accnum']): '';
	$desaccnum = isset($_POST['desaccnum'])? trim($_POST['desaccnum']): '';
	$amount = isset($_POST['amount'])? trim($_POST['amount']): '';
	$user_id = isset($_POST['id'])? trim($_POST['id']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';


	if ($accnum == '' ||$desaccnum == '' || $amount == '' || $pin == '') {
		$error = "All fields required";
		header("location: index.php?trans=".$error);
	}else{
		$accnum = mysql_prep($connect, $accnum);
		$desaccnum = mysql_prep($connect, $desaccnum);
		$amount = mysql_prep($connect, $amount);
		$user_id = mysql_prep($connect, $user_id);
		$pin = mysql_prep($connect, $pin);

		transfersql($user_id, $pin, $accnum, $desaccnum, $amount);

	}

}

if (isset($_POST['with'])) {
	
	$accnum = isset($_POST['accnum'])? trim($_POST['accnum']): '';
	$amount = isset($_POST['amount'])? trim($_POST['amount']): '';
	$user_id = isset($_POST['id'])? trim($_POST['id']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';


	if ($accnum == ''|| $amount == '' || $pin == '') {
		$error = "All fields required";
		header("location: index.php?with=".$error);
	}else{
		$accnum = mysql_prep($connect, $accnum);
		$amount = mysql_prep($connect, $amount);
		$user_id = mysql_prep($connect, $user_id);
		$pin = mysql_prep($connect, $pin);

		withsql($user_id, $pin, $accnum, $amount);
	}
}

if (isset($_POST['bill'])) {
	
	$accnum = isset($_POST['accnum'])? trim($_POST['accnum']): '';
	$amount = isset($_POST['amount'])? trim($_POST['amount']): '';
	$user_id = isset($_POST['id'])? trim($_POST['id']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';


	if ($accnum == ''|| $amount == '' || $pin == '') {
		$error = "All fields required";
		header("location: index.php?with=".$error);
	}else{
		$accnum = mysql_prep($connect, $accnum);
		$amount = mysql_prep($connect, $amount);
		$user_id = mysql_prep($connect, $user_id);
		$pin = mysql_prep($connect, $pin);

		withsql($user_id, $pin, $accnum, $amount);
	}
}
if (isset($_POST['nepa'])) {
	
	$accnum = isset($_POST['accnum'])? trim($_POST['accnum']): '';
	$amount = isset($_POST['amount'])? trim($_POST['amount']): '';
	$user_id = isset($_POST['id'])? trim($_POST['id']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';


	if ($accnum == ''|| $amount == '' || $pin == '') {
		$error = "All fields required";
		header("location: index.php?nepa=".$error);
	}else{
		$accnum = mysql_prep($connect, $accnum);
		$amount = mysql_prep($connect, $amount);
		$user_id = mysql_prep($connect, $user_id);
		$pin = mysql_prep($connect, $pin);
		$res = 'nepa';

		bill($user_id, $pin, $accnum, $amount, $res);
	}
}

if (isset($_POST['gotv'])) {
	
	$accnum = isset($_POST['accnum'])? trim($_POST['accnum']): '';
	$amount = isset($_POST['amount'])? trim($_POST['amount']): '';
	$user_id = isset($_POST['id'])? trim($_POST['id']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';


	if ($accnum == ''|| $amount == '' || $pin == '') {
		$error = "All fields required";
		header("location: index.php?nepa=".$error);
	}else{
		$accnum = mysql_prep($connect, $accnum);
		$amount = mysql_prep($connect, $amount);
		$user_id = mysql_prep($connect, $user_id);
		$pin = mysql_prep($connect, $pin);
		$res = 'gotv';

		bill($user_id, $pin, $accnum, $amount, $res);
	}
}
if (isset($_POST['phone'])) {
	
	$accnum = isset($_POST['accnum'])? trim($_POST['accnum']): '';
	$amount = isset($_POST['amount'])? trim($_POST['amount']): '';
	$user_id = isset($_POST['id'])? trim($_POST['id']): '';
	$pin = isset($_POST['pin'])? trim($_POST['pin']): '';


	if ($accnum == ''|| $amount == '' || $pin == '') {
		$error = "All fields required";
		header("location: index.php?nepa=".$error);
	}else{
		$accnum = mysql_prep($connect, $accnum);
		$amount = mysql_prep($connect, $amount);
		$user_id = mysql_prep($connect, $user_id);
		$pin = mysql_prep($connect, $pin);
		$res = 'phone';

		bill($user_id, $pin, $accnum, $amount, $res);
	}
}

if (isset($_POST['getbill'])) {
	$input = isset($_POST['billin'])? trim($_POST['billin']): '';

     
	if($input == " "){
		$error = "All fields required line 24";
		header("location: index.php?billin=".$error);
	}else{
		header("location: index.php?billin=".$input);	
	}
	
}


?>