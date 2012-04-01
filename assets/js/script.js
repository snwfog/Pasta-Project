/**
 * PASTA - SOEN341 Concordia 2012
 * JavaScript functions
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
		&& $('#continue').length == 0) {
		// if we are first at course registration page, load the preference first
		$.blockUI({
			message : $('#course-preferences-selection'),
			overlayCSS : { opacity: 0.2 },
		});
	}
	
	$('#course-preferences-accept').click(function() {
		$.unblockUI();
	});


	$('#course-preferences-reselect').click(function() {
		$.blockUI({
			message : $('#course-preferences-selection'),
			overlayCSS : { opacity: 0.2 },
		});
	});

	/**
	 * Restrict user to register at maximum 6 courses per semester
	 */
	var MAX_COURSES_ALLOWED = 2;
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

});

// // extend jquery ui accordion to allow multiple
// // sections at once if the multiple option is true
// // from http://forum.jquery.com/topic/accordion-multiple-sections-open-at-once
// $.extend($.ui.accordion.prototype.options,{multiple: false});
// var _toggle = $.ui.accordion.prototype._toggle;
// var _clickHandler = $.ui.accordion.prototype._clickHandler;
// $.extend($.ui.accordion.prototype,{
// 	_toggle: function(toShow, toHide, data, clickedIsActive, down){
// 		if (this.options.collapsible && this.options.multiple && toShow.is(':visible')) {
// 			arguments[1] = arguments[0];
// 			arguments[3] = true;
// 		}
// 		else if (this.options.collapsible && this.options.multiple) {
// 			arguments[1] = $([]);			
// 		}
// 		_toggle.apply(this,arguments);
// 		this.active
// 			.removeClass( "ui-state-active ui-corner-top" )
// 			.addClass( "ui-state-default ui-corner-all" )
// 	},
// 	_clickHandler: function(event, target){
// 		if ($(target).next().is(':visible:not(:animated)')) {
// 			this.active = $(target);
// 		}
// 		_clickHandler.apply(this,arguments)
// 	}
// });
