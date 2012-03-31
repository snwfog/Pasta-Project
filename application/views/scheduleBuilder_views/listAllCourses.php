<html>
<head>
<title>Choose Your Courses for this semester</title>
</head>
<body>

<?php echo form_open('ScheduleBuilder/generate_schedule/'.$season); ?>
    <?php foreach ($courseList as $course ): ?>
        <!-- course[] will keep an array of all values that are checked --!>
        <input type='checkbox' name='course[]' value=<?php echo $course["id"];?> /> <?php echo $course["code"]." ".$course["number"]?> <br/>
    <?php endforeach; ?>
    <div><input type="submit" value="Submit" /></div>
</form>

<?php echo $this->benchmark->memory_usage();  ?>

</body>
</html>
