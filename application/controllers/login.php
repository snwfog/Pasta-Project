<?
	if(!isset($_SESSION))
	{
		session_start();
	}
		
	$username = $_POST['username'];
	$pw = md5($_POST['password']);
	$auth = false;
	$errorMsg = "";
	
	if(empty($username) || empty($pw))
	{
		$errorMsg = "Please fill out both fields before trying to login";
		$_SESSION('errorMsg') = $errorMsg;
		header('Location: index.php');
	}
	else
	{
		$con = mysql_connect();
		if(!$con)
		{
			$errorMsg = "Could not connect to the Database";
			$_SESSION('errorMsg') = $errorMsg;
		)
		$db = "pasta";
		mysql_select_db($db, $con);
		
		$passW = mysql_query("SELECT Pass FROM Student WHERE Username = '$username'");
		if($passW === $pw)
		{
			$auth = true;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $pw;
			$_SESSION['auth'] = $auth;
			header('Location: main.php');
		}
		else
		{
			$auth = false;
			$errorMsg = "Authentication failed; username or password incorrect"
			$_SESSION('errorMsg') = $errorMsg;
		}
		header('Location: index.php');
	}
?>	