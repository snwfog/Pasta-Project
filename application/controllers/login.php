<?
//Author: Steve
//Purpose: Login Script, will check the login form to authenticate the user
//Last Modified: Feb 12th 2012

	//Check if a session has already been opened, if not, create one.
	if(!isset($_SESSION))
	{
		session_start();
	}
		
	//Variables to be stored.	
	$username = $_POST['username']; //Username fetched from the POST (from the Form field)
	$pw = md5($_POST['password']); //Password is stored in MD5 hash format from the POST (from the Form field)
	$auth = false; //Default value for authentication is false.
	$errorMsg = ""; //Error message to be displayed if needed. 
	
	//Check to see if any of the required fields are empty
	if(empty($username) || empty($pw))
	{
		$errorMsg = "Please fill out both fields before trying to login"; //Empty fields message
		$_SESSION('errorMsg') = $errorMsg; //Store the message into a SESSION Variable
		header('Location: index.php'); //Reload the index page.
	}
	else //Fields are filled properly, proceed with SQL Connection
	{
		$con = mysql_connect(); //Connection to SQL
		if(!$con) //If connection is impossible
		{
			$errorMsg = "Could not connect to the Database"; //SQL Fail message
			$_SESSION('errorMsg') = $errorMsg; //Store the message into a SESSION Variable
		)
		$db = "pasta"; //Name of database we want
		mysql_select_db($db, $con); //Select the database specified
		
		$passW = mysql_query("SELECT Pass FROM Student WHERE Username = '$username'"); //Check password SQL Query
		if($passW === $pw) // Check if password entered and password from database (Stored in md5hash)
		{
			$auth = true; //Set authenticated boolean variable to True;
			$_SESSION['username'] = $username; //Store the username in SESSION Variable
			$_SESSION['password'] = $pw; //Store the md5 password in SESSION Variable
			$_SESSION['auth'] = $auth; //Store the authenticated boolean variable in SESSION Variable
			header('Location: main.php'); //Access the next page
		}
		else // Authentication was unsuccessful
		{
			$auth = false; //Keep authenticated variable to FALSE
			$errorMsg = "Authentication failed; username or password incorrect" //Incorrect credentials message
			$_SESSION('errorMsg') = $errorMsg; //Store message to SESSION Variable
		}
		header('Location: index.php'); //Reload the page if all else fails.
	}//end else
?>	