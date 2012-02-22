<html>
<head>
<title>My Form</title>
</head>
<body>

<!-- return form validator error if there is any -->
<!-- <?php echo validation_errors(); ?> -->


<?php echo form_open('scrape'); ?>
    <h2>Course Code</h2>
    <?php echo form_error('course_code'); ?>
    <input type="text" name="course_code" value="" size="10" maxlength="4" />
    
    <h2>Course Number</h2>
    <?php echo form_error('course_number'); ?>
    <input type="text" name="course_number" value="" size="10" maxlength="3" />
    <br>
 
    <select name="session">
        <option value="2" >Fall</option>
        <option value="4" >Winter</option>
    </select>
    
    <div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>
