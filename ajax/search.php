<?php

if(isset($_POST['query']))
{
	$query = $_POST['query'];
	
	$results = array(
		"<a href='#'>SOEN 341</a><br />SOFTWARE PROCESS ",
		"<a href='#'>SOEN 287</a><br />WEB PROGRAMMING ",
		"<a href='#'>SOEN 341</a><br />SOFTWARE PROCESS ",
		"<a href='#'>SOEN 331</a><br />INTRO TO FML MTHDS FOR SOEN ",
		"<a href='#'>SOEN 343</a><br />S.W. ARCHITECURE & DESIGN I ",
		"<a href='#'>SOEN 344</a><br />S.W. ARCHITECURE & DESIGN II ",
		"<a href='#'>SOEN 345</a><br />S.W. TESTING, VERIF & QA ",
		"<a href='#'>SOEN 357</a><br />USER INTERFACE DESIGN ",
		"<a href='#'>SOEN 384</a><br />MGMT+QUALITY CTRL./SW DEV. ",
		"<a href='#'>SOEN 385</a><br />CONTROL SYSTEMS+APPLICATIONS ",
		"<a href='#'>SOEN 390</a><br />SOFTWARE ENGR. TEAM PROJECT "
	);
	
	$res_match = "";
	
	if($query != "")
	{
		foreach($results as $value)
		{
			// Check for a match
			if(stristr($value,$query) == true)
			{
				$res_match .= $value . "<br /><hr />";
			}
		}
	}
	
	print $res_match;
}

?>