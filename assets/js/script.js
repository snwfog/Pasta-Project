/**
 * PASTA - SOEN341 Concordia 2012
 * JavaScript functions
 * 
 * Author: Charles Yang
 * Date:   Feburary 2012
 */
$(document).ready(function() {
	/**
	 * Load accordion effect for all accordions
	 * and prevent it from collapsing
	 */
	$('#accordion').accordion({ 
		autoHeight 	: false,
		collapsible	: true,
		active 		: false,
		multiple	: true
	});

	/**
	 * Function to color the check table row to green when selected
	 */
	$('input:checkbox').click(function() {
		if (!$(this).is(':checked')) {
			// must be checked previously, because checkbox state
			// went from checked to unchecked: unselect a course
			$(this).parents('tr').css({'background-color' : '#ffefea'}); // red
		} else {
			// selecting a course
			$(this).parents('tr').css({'background-color' : '#f0ffed'}); // green
		}
	});

	$('input:checkbox:checked').parents('tr').css({
		'background-color' : '#f0ffed' // green
	});

	/**
	 * Allow table row clicking based on input context
	 */
	$('input:checkbox').parents('tr').click(function() {
		if ($("input:checkbox", this).is(':checked')) {
			$("input:checkbox", this).removeAttr("checked");
			$(this).css({'background-color' : '#ffefea'}); // red
		} else {
			$("input:checkbox", this).attr("checked", "checked");
			$(this).css({'background-color' : '#f0ffed'}); // green
		}
	});


	/**
	 * Function to submit the form when clicked the submit button
	 */
	// $('#signup #submit').click(function() {
	// 	// prevent the defaulted `placeholder` text to be submitted from
	// 	// the placeholder jquery hack/fix by clearing the placeholder
	// 	// field before submitting
	// 	$(this).parents('form').submit(function() {
	// 		$(this).find('[placeholder]').each(function() {
	// 			var input = $(this);
	// 			if (input.val() == input.attr('placeholder'))
	// 				input.val('');
	// 		});
	// 	});
	// });


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

	/**
	 * Display warning when user click drop schedule button
	 * @view: profile
	 */
	$('#dummy-drop-schedule').click(function() {
		$.blockUI({
			message : $('#drop-schedule-confirm-box'),
			overlayCSS : { opacity: 0.2 },
			css: { cursor: 'default' },
		});

		// my dialog (unmodal)
		// $('#drop-schedule-confirm-box').css({ 
		// 	'z-index' : '9999',
		// 	'opacity' : '1'
		// });
		// 
		// a quick hack for my css dialog + jquery modal dialog
		// $('#modal-dummy').dialog({ 
		// 	modal 		: true,
		// 	height 		: 0,
		// 	width		: 300,
		// });
	});

	$('#drop-schedule-cancel').click(function() {
		$.unblockUI();
		return false;
		// $('#drop-schedule-confirm-box').css({ 
		// 	'opacity' : '0',
		// 	'z-index' : '-9999'
		// });

		// $('#modal-dummy').dialog('close');
	});

	/**
	 * Show the course preferences on loading the schedulebuilder controller
	 */
	if ($('#course-preferences-selection').length > 0
		&& $('#register-selected-courses').length == 0) {
		// if we are first at course registration page, load the preference first
		$.blockUI({
			message : $('#course-preferences-selection'),
			overlayCSS : { opacity: 0.2 },
			css: { cursor: 'default' },
		});
	}
	
	$('#course-preferences-accept').click(function() {
		$.unblockUI();
	});


	$('#course-preferences-reselect').click(function() {
		$.blockUI({
			message : $('#course-preferences-selection'),
			overlayCSS : { opacity: 0.2 },
			css: { cursor: 'default' },
		});
	});

	/**
	 * Restrict user to register at maximum 6 courses per semester
	 */
	var MAX_COURSES_ALLOWED = 6;
	$('#registrated-course-counter').html(MAX_COURSES_ALLOWED);

	$('#course-registration-selection-table input:checkbox').click(function() {
		if (!$(this).is(':checked'))
			MAX_COURSES_ALLOWED++;
		else
			MAX_COURSES_ALLOWED--;
		
		$('#registrated-course-counter').html(MAX_COURSES_ALLOWED).animate();

		if (MAX_COURSES_ALLOWED <= 0) {
			// get all unchecked checkboxes from form, and disable them
			$('#course-registration-selection-table input:checkbox:not(:checked)').attr('disabled', 'true');
			// disable form
		} else {
			// if still space to register course, allows more checkboxes
			$('#course-registration-selection-table input:checkbox:not(:checked)').removeAttr('disabled');
		}
	});

	/**
	 * Require user to register at least 1 course in order to continue
	 */
	// on load disable the register course
	if ($('#course-registration-selection-table input:checkbox:checked').length == 0)
		$('#register-selected-courses').attr('disabled', 'disabled');
	
	$('#course-registration-selection-table input:checkbox').click(function() {
		if ($('#course-registration-selection-table input:checkbox:checked').length == 0) {
			$('#register-selected-courses').attr('disabled', 'disabled');
		} else {
			$('#register-selected-courses').removeAttr('disabled');
		}
	});


});