<html>
<head>
<title> P.A.S.T.A. </title>
</head>
<body>

<?php

	$sql = "SELECT * FROM Courses";
	$result = mysql_query($sql, $connection);
?>
<table>
<tr><td>Course Number</td><td>Course Name</td><td>Credits</td></tr>
<?php

	while($row = mysql_fetch_assoc($result)) {
?>
		<tr>
		<td><? echo $row["courseNum"]; ?></td>
		<td><? echo $row["courseName"]; ?></td>
		<td><? echo $row["credits"]; ?></td>
		<td><form><input type="checkbox" name="<? echo $row["courseNum"];?>" value="<? echo $row["courseNum"];?>" /></form></td>
		</tr>
<?php

};
?>
</table>		
	
					

</body>
</html>
	