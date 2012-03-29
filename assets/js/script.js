/**
 * JavaScript functions
 */
$(document).ready(function() {


	/**
	 * Function to color the check table row to green when selected
	 */
	$('#course_selection_table input:checkbox').click(function() {
		if (!$(this).is(':checked')) {
			// must be checked previously, because checkbox state
			// went from checked to unchecked: unselect a course
			$(this).parents('tr').css({'background-color' : '#ffefea'}); // red
		} else {
			// selecting a course
			$(this).parents('tr').css({'background-color' : '#f0ffed'}); // green
		}
	});

	$('#course_selection_table input:checkbox:checked').parents('tr').css({
		'background-color' : '#f0ffed' // green
	});
});
