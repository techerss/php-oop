<!DOCTYPE html>
<html lang="en">

<head>

    

    <title>Don Bank</title>

   
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="boot5/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
    

</head>

<body>
<?php
	session_start();
	require_once('function.php');
	

	
	
	// class Dog{

	// 	 var $eye = 2;
	// 	 var $color = "blue";
	// 	 var $nose = 1;
	// 	 var $fur_color = "white";
		
	// 	function Showall(){
	// 		echo $this->eye."<br>";
	// 		echo $this->color."<br>";
	// 		echo $this->nose."<br>";
	// 		echo $this->fur_color;
	// 	}
		
	// }

	// /**
	//  * 
	//  */
	// class Lion extends Dog
	// {
		
	// 	function __construct()
	// 	{
	// 		echo $this->nose;
	// 		echo $this->fur_color;

	// 	}
	// }

	// $pitbull = new Dog();
	// $pitbull->Showall()."<br>";

	// $cub = new Lion();


	// my bank app

	
	
	class Welcome extends Dashboard{

		protected $welcome;
		protected $note;
		protected $output;
		protected $pass;
		protected $pin;
		protected $accountnum;

	
		function __construct(){
			
			
			if (isset($_SESSION['id'])) {

			}else{
				echo "";
				echo "";

				echo $inputt ='<div>
					<h2 class="text-center">Welcome to my bank App</h2>
				<form  class="form m-auto p-3" method="POST" action="process.php">
					<marquee>press 1 to Register and 2 to Login</marquee>
				<div class="form-group"><input name="input" class="form-control"> </div>
				<div class="text-center p-3"><button name="submit" class="btn btn-success ">Submit</button></div></form>';
			}
			$this->get();

			$this->regget();

			$this->sessionset();
					
		}
		function get(){
			if (isset($_GET['output'])) {
				$this->output = $_GET['output'];
			}

			if ($this->output == 1) {
				$this->register();
			}elseif ($this->output == 2) {
				$this->login();
				
			}
			
			
		} 
		function regget(){
			if (isset($_GET['success'])) {
				
				$this->login();	
			}
		

		}
		
		function sessionset(){
			if (isset($_SESSION['id'])){
				
				$dashboard = new Dashboard();
				$dashboard->sql();
			}
		}

		function register(){

			$accountnum = mt_rand(1234566, 9999999);
			
			echo "<form class='card m-auto p-3' action='process.php' method='POST'>
			<h3 class='text-center'>Register Here</h3>
			<div class='form-group'><label>Enter your Name</label class='form-label'><br><input name='name' class='form-control' placeholder='your name'></div><br>

			<div class='form-group'><label>Enter your password</label><br><input name='password' type='password' class='form-control' placeholder='your password'></div><br>

			<div class='form-group'><label>Enter a 4 Digit Transaction Pin</label><br><input name='pin' type='text' class='form-control' placeholder='your pin'></div><br>

			<input name='accountnum' type='hidden' value='$accountnum'>
			<div class='text-center'><button class='btn btn-success ' name='reg'>Register</button></div></form>";

			
		}

		function login(){
			echo "";
			echo "<form  class='card m-auto p-3'  action='process.php' method='POST'>
			<h3 class='text-center'>login Here</h3>
			<div class='form-group'><label>Enter your Name</label><br><input  class='form-control'  name='name' placeholder='your name'></div><br>

			<div class='form-group'><label>Enter your password</label><br><input  class='form-control'  name='password' type='password' placeholder='your password'></div><br>

			<div class='text-center'><button class='btn btn-success ' name='log'>Login</button></div></form>";
			
		}

		

	}





	
	class Dashboard{
		private $inputt;
		private $output;
		private $outputt;


		function __construct()
		{
			echo "<h1 class='text-center'>My Dashboard</h1>";
			if (isset($_SESSION['id'])) {
				echo "<form  method='POST'>
				<button class='btn btn-danger' name='logout'>Logout</button>
				</form>";
				if (array_key_exists('logout', $_POST)) {
					$this->sessiondestroy();
				}

				if (isset($_GET['dash']) || isset($_GET['dep']) || isset($_GET['trans']) || isset($_GET['with']) || isset($_GET['billin']) || isset($_GET['nepa']) || isset($_GET['gotv']) || isset($_GET['phone'])) {

					

					
				}else{

					echo "<div class='m-auto markdiv d-flex justify-content-center align-items-center '><marquee class='mark'><h3>Press 1 to deposit, press 2 to transfer, press 3 to withdraw, press 4 to pay bills, press 5 to logout</h3></marquee></div>";
					echo '<div class="d-flex justify-content-center align-items-center">
						<form class="card p-3 m-3" method="POST" action="process.php"><input class="form-control" name="dashh">
						<div class="text-center"> <button class="btn btn-success mt-3" name="dash">Submit</button></div></form>
					</div>';
				}

			}

			$this->dashinput();
			$this->dep();
			$this->trans();
			$this->with();
			$this->getbill();
			$this->nepaa();
			$this->gotvv();
			$this->phonee();






		}
		

		function sql(){
			$connect = connect();
			$id = $_SESSION['id'];
			$sql = "SELECT * FROM users WHERE user_id = '$id' AND user_status = 1";
				$result = mysqli_query($connect, $sql);
				$row = mysqli_fetch_assoc($result);
				$user_id = $row['user_id'];
				$user_name = $row['user_name'];
				$user_pin = $row['user_pin'];
				$user_accnum = $row['user_accnum'];

				$balance = $row['balance'];
				
			

		}

		function displaydetails(){
			$connect = connect();
			
			$id = $_SESSION['id'];
			$sql = "SELECT * FROM users WHERE user_id = '$id' AND user_status = 1";
				$result = mysqli_query($connect, $sql);
				$row = mysqli_fetch_assoc($result);
				$user_id = $row['user_id'];
				$user_name = $row['user_name'];
				$user_pin = $row['user_pin'];
				$user_accnum = $row['user_accnum'];
				$balance = $row['balance'];
		
			echo "<div class='text-center'><h3>These are your details</h3>(name: $user_name, pin: $user_pin, accnum: $user_accnum, acc_balance: $balance)</div>";
		}

		
		

		function dashinput(){

			if (isset($_GET['dash'])) {
				$this->output = $_GET['dash'];

			}
			switch ($this->output) {
				case 1:				
				$this->deposit();
					break;
				case 2:
					$this->transfer();
					break;
				case 3:
					$this->withdraw();
					break;
				case 4:
					$this->bill();
					break;
				case 5:
					$this->sessiondestroy();
					break;
				
			}
				
			
		}
		function dep(){
			if (isset($_GET['dep'])) {
				$this->deposit();
			}
		}
		function trans(){
			if (isset($_GET['trans'])) {
				$this->transfer();
			}
		}
		function with(){
			if (isset($_GET['with'])) {
				$this->withdraw();
			}
		}
		function nepaa(){
			if (isset($_GET['nepa'])) {
				$this->nepa();
			}
		}
		function gotvv(){
			if (isset($_GET['gotv'])) {
				$this->gotv();
			}
		}
		function phonee(){
			if (isset($_GET['phone'])) {
				$this->phone();
			}
		}
		function getbill(){
			if (isset($_GET['billin'])) {
				$this->outputt = $_GET['billin'];
			}


			switch ($this->outputt) {
				case 1:
					$this->nepa();
					break;
				
				case 2:
					$this->gotv();
					break;
				case 3:
					$this->phone();
					break;
			}
		}
		function deposit(){
			 $this->displaydetails();
			
			if (isset($_SESSION['id'])) {
				$user_id = $_SESSION['id'];
				
				
			}
			if (isset($_GET['dep'])) {
				$dep = $_GET['dep'];
			}else{
				$dep = '';
			}
			
			echo "<div class=''>
			<form class='card p-3 mt-2 m-auto' action='process.php' method='POST'>
				<h3 class='text-center'>Deposit Form</h3>

			<div class='form-group'><label>Enter your Account number</label><br><input class='form-control' name='accnum' placeholder='your Account Number'><div><br>

			<div><label>Enter your Amount</label><br><input class='form-control' name='amount' placeholder='Amount'><div><br>

			<div><label>Enter your Pin</label><br><input name='pin' class='form-control' placeholder='your pin'><div><br>

			<input type='hidden' name='id' value='$user_id'>
			
			<div class='alert-warning pb-2' role='alert'>$dep</div>
			
			<button class='btn btn-success' name='dep'>Deposit</button>
			<button class='btn btn-warning'  name='back'>back</button></form>
			</div>
			";
			
			
		}
		

		function transfer(){
			 $this->displaydetails();
			if (isset($_SESSION['id'])) {
				$user_id = $_SESSION['id'];
				
				
			}
			if (isset($_GET['trans'])) {
				$trans = $_GET['trans'];
			}else{
				$trans = '';
			}
			
			
			echo "<form class='card p-3 mt-2 m-auto' action='process.php' method='POST'>
			<h3 class='text-center'>Transfer Form</h3>
			<div>
			<label>Enter your Account Number</label><br><input name='accnum' class='form-control'  placeholder='your account'></div><br>

			<div><label>Enter Destination Account number</label><br><input name='desaccnum' class='form-control'   placeholder='destination account'><div><br>

			<div><label>Enter your Amount</label><br><input name='amount' class='form-control'   placeholder='amount'><div><br>

			<div><label>Enter your pin</label><br><input name='pin' class='form-control'   placeholder='your pin'><div><br>

			<input type='hidden' name='id' value='$user_id'>

			<div  class='alert-warning pb-2' role='alert'>$trans</div>


			<button class='btn btn-success' name='trans'>Transfer</button>
			<button class='btn btn-warning' name='back'>back</button></form>";
		}

		function withdraw(){
			 $this->displaydetails();
			 if (isset($_SESSION['id'])) {
				$user_id = $_SESSION['id'];
				
				
			}
			if (isset($_GET['with'])) {
				$with = $_GET['with'];
			}else{
				$with = '';
			}

			
			echo "<form class='card p-3 mt-2 m-auto'  action='process.php' method='POST'>
					<h3 class='text-center'>Withdraw Form</h3>
			<div><label>Enter your Account number</label><br><input name='accnum'  class='form-control' placeholder='your number'><div><br>

			<div><label>Enter Amount</label><br><input  class='form-control' name='amount' placeholder='Amount'><div><br>

			<div><label>Enter your pin</label><br><input name='pin'  class='form-control'  placeholder='your pin'><div><br>
			<input type='hidden' name='id' value='$user_id'>

			<div class='alert-warning pb-2' role='alert'>$with</div>

			<button class='btn btn-success' name='with'>Withdraw</button>
			<button class='btn btn-warning'  name='back'>back</button></form>";
		}

		function bill(){
			 $this->displaydetails();

			echo '<form class="card p-3 mt-2 m-auto" method="POST" action="process.php">
			<h2 class="text-center">Pay Your Bills<h2>
			<marquee>Press 1 to pay Nepa bill, press 2 to pay for GO TV, press 3 to Recharge your phone</marquee>
			<input class="form-control mb-2" name="billin">
			<button class="btn btn-success" name="getbill">Submit</button>
			<button class="btn btn-warning" name="back">back</button></form><br></form>';

		}
		function nepa(){
			$this->displaydetails();

			if (isset($_SESSION['id'])) {
				$user_id = $_SESSION['id'];	
			}
			if (isset($_GET['nepa'])) {
				$nepa = $_GET['nepa'];
			}else{
				$nepa = '';
			}
			echo '';

				echo "<form class='card p-3 mt-2 m-auto'  action='process.php' method='POST'>
				<h3 class='text-center'>Pay Your Nepa Bill</h3>
	
			<div><label>Enter your Account number</label><br><input class='form-control' name='accnum' placeholder='your number'><div><br>

			<div><label>Enter Amount</label><br><input class='form-control' name='amount' placeholder='Amount'><div><br>

			<div><label>Enter your pin</label><br><input class='form-control' name='pin'  placeholder='your pin'><div><br>
			<input type='hidden' name='id' value='$user_id'>

			<div class='alert-warning mb-2' role='alert'>$nepa</div>

			<button class='btn btn-success' name='nepa'>Pay bill</button>
			<button class='btn btn-warning'  name='bills'>back</button></form>";
		}
		function gotv(){
			$this->displaydetails();

			if (isset($_SESSION['id'])) {
				$user_id = $_SESSION['id'];
			}
			if (isset($_GET['gotv'])) {
				$gotv = $_GET['gotv'];
			}else{
				$gotv = '';
			}
			

				echo "<form class='card p-3 mt-2 m-auto' action='process.php' method='POST'>
				<h3>Pay Your Gotv Bill</h3>
	
			<div><label>Enter your Account number</label><br><input class='form-control' name='accnum' placeholder='your number'><div><br>

			<div><label>Enter Amount</label><br><input class='form-control' name='amount' placeholder='Amount'><div><br>

			<div><label>Enter your pin</label><br><input class='form-control' name='pin'  placeholder='your pin'><div><br>
			<input type='hidden' name='id' value='$user_id'>

			<div class='alert-warning mb-2' role='alert'>$gotv</div>

			<button class='btn btn-success' name='gotv'>Pay bill</button>
			<button class='btn btn-warning' name='bills'>back</button></form>";
		}
		function phone(){
			$this->displaydetails();

			if (isset($_SESSION['id'])) {
				$user_id = $_SESSION['id'];	
			}
			if (isset($_GET['phone'])) {
				$phone = $_GET['phone'];
			}else{
				$phone = '';
			}
			

			echo "<form class='card p-3 mt-2 m-auto'  action='process.php' method='POST'>
				<h3>Recharge Your Phone</h3>
			<div><label>Enter your Account number</label><br><input class='form-control'  name='accnum' placeholder='your number'><div><br>

			<div><label>Enter Amount</label><br><input class='form-control'  name='amount' placeholder='Amount'><div><br>

			<div><label>Enter Phone number</label><br><input class='form-control'  name='phone' placeholder='Phone Number'><div><br>

			<div><label>Enter your pin</label><br><input class='form-control'  name='pin'  placeholder='your pin'><div><br>
			<input type='hidden' name='id' value='$user_id'>

			<div class='alert-warning mb-2' role='alert'>$phone</div>

			<button class='btn btn-success'  name='phone'>Racharge</button>
			<button class='btn btn-warning' name='bills'>back</button></form>";
		}

		function sessiondestroy(){
			session_unset();
			session_destroy();
			header("location: my.php");
		}
	}

	$bank = new Welcome();
	


?>

</body>
