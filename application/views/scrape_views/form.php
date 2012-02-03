<html>
<head>
<title>My Form</title>
</head>
<body>

<?php echo validation_errors(); ?>

<?php echo form_open('scrape'); ?>

<h5>Course Code</h5>
<input type="text" name="course_code" value="" size="50" />

<h5>Course Number</h5>
<input type="text" name="course_number" value="" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>
