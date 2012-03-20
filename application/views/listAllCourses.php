<html>
<head>
<title>Choose Your Courses for this semester</title>
</head>
<body>

<?php echo form_open('ScheduleBuilder/generate_schedule'); ?>
    <?php foreach ($courseList as $course ): ?>
        <!-- course[] will keep an array of all values that are checked --!>
        <input type='checkbox' name='course[]' value=<?php echo $course["id"];?> /> <?php echo $course["code"]?> <br/>
    <?php endforeach; ?>
    <div><input type="submit" value="Submit" /></div>
</form>

</body>
</html>
