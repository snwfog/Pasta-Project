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


	/**
	 * Function to submit the form when clicked the submit button
	 */
	$('#signup #submit').click(function() {
		// prevent the defaulted `placeholder` text to be submitted from
		// the placeholder jquery hack/fix by clearing the placeholder
		// field before submitting
		$(this).parents('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder'))
					input.val('');
			});
		});
	});


	/**
	 * Function to place visual placeholder for forms input text area and field
	 * from: http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
	 */
	// $('[placeholder]').focus(function() {
	// 	var input = $(this);
	// 	if (input.val() == input.attr('placeholder')) {
	// 		input.val('');
	// 		input.removeClass('placeholder');
	// 	}
	// }).blur(function() {
	// 	var input = $(this);
	// 	if (input.val() == '' || input.val() == input.attr('placeholder')) {
	// 		input.addClass('placeholder');
	// 		input.val(input.attr('placeholder'));
	// 	}
	// }).blur();

	/**
	 * Special handler for password field placeholder
	 */
	$('.dummy').focus(function() {
		$(this).hide();
		$(this).siblings().show().focus();
	});

	$('.dummy').siblings().blur(function() {
		if ($(this).val() == '') {
			$(this).hide();
			$(this).siblings().show();
		}
	});

});
