/**
 * PASTA - SOEN341 Concordia 2012
 * JavaScript functions
 * 
 * Author: Charles Yang
 * Date:   Feburary 2012
 */
$(document).ready(function () {
    /**
     * Load accordion effect for all accordions
     * and prevent it from collapsing
     */
    $('#accordion').accordion({
        autoHeight: false,
        collapsible: true,
        active: false,
        multiple: true
    });

    /**
     * Function to color the check table row to green when selected
     */
    $('input:checkbox').click(function () {
        if (!$(this).is(':checked')) {
            // must be checked previously, because checkbox state
            // went from checked to unchecked: unselect a course
            $(this).parents('tr').css({
                'background-color': '#ff9fa2'
            }); // red
        } else {
            // selecting a course
            $(this).parents('tr').css({
                'background-color': '#a9ffa4'
            }); // green
        }
    });

    $('input:checkbox:checked').parents('tr').css({
        'background-color': '#a9ffa4' // green
    });

    /**
     * Allow table row clicking based on input context course completed
     */
    $('#course_selection_table input:checkbox').parents('tr').click(function () {
        if ($("input:checkbox", this).is(':checked')) {
            $("input:checkbox", this).removeAttr("checked");
            $(this).css({
                'background-color': '#ff9fa2'
            }); // red
        } else {
            $("input:checkbox", this).attr("checked", "checked");
            $(this).css({
                'background-color': '#a9ffa4'
            }); // green
        }
    });

    /**
     * Special handler for password field placeholder
     */
    $('.dummy').focus(function () {
        $(this).hide();
        $(this).siblings().show().focus();
    });

    $('.dummy').siblings().blur(function () {
        if ($(this).val() == '') {
            $(this).hide();
            $(this).siblings().show();
        }
    });

    /**
     * Display warning when user click drop schedule button
     * @view: profile
     */
    $('#dummy-drop-schedule').click(function () {
        $.blockUI({
            message: $('#drop-schedule-confirm-box'),
            overlayCSS: {
                opacity: 0.2
            },
            css: {
                cursor: 'default'
            },
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

    $('#drop-schedule-cancel').click(function () {
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
    if ($('#course-preferences-selection').length > 0 && $('#register-selected-courses').length == 0) {
        // if we are first at course registration page, load the preference first
        $.blockUI({
            message: $('#course-preferences-selection'),
            overlayCSS: {
                opacity: 0.2
            },
            css: {
                cursor: 'default'
            },
        });
    }

    $('#course-preferences-accept').click(function () {
        $.unblockUI();
    });


    $('#course-preferences-reselect').click(function () {
        $.blockUI({
            message: $('#course-preferences-selection'),
            overlayCSS: {
                opacity: 0.2
            },
            css: {
                cursor: 'default'
            },
        });
    });

    /**
     * Restrict user to register at maximum 6 courses per semester
     */
    var MAX_COURSES_ALLOWED = 6;
    $('#registrated-course-counter').html(MAX_COURSES_ALLOWED);

    $('#course-registration-selection-table input:checkbox').parents('tr').click(function () {
        // if checkbox is checked
        if ($('input:checkbox', this).is(":checked")) {
            // uncheck the checkbox
            $('input:checkbox', this).removeAttr("checked");
            // change color indicator
            $(this).css({
                'background-color': '#ff9fa2'
            }); // red
            // increment the MAX_COURSES_ALLOWED
            MAX_COURSES_ALLOWED++;
            // enable all form
            $('#course-registration-selection-table input:checkbox:not(:checked)').removeAttr('disabled');
            // if the checkbox is unchecked
        } else {
            // check if we are still allowed to check more boxes
            if (MAX_COURSES_ALLOWED > 0) {
                $('input:checkbox', this).attr("checked", "checked");
                // change color indicator
                $(this).css({
                    'background-color': '#a9ffa4'
                }); // green
                MAX_COURSES_ALLOWED--;
                // if MAX_COURSES_ALLOWED reached zero
                // disable all unchecked elements
                if (MAX_COURSES_ALLOWED == 0) $('#course-registration-selection-table input:checkbox:not(:checked)').attr('disabled', 'true');
            }
        }

        // update course allowed counter
        $('#registrated-course-counter').html(MAX_COURSES_ALLOWED).animate();
    });

    /**
     * Require user to register at least 1 course in order to continue
     */
    // on load disable the register course
    if ($('#course-registration-selection-table input:checkbox:checked').length == 0) $('#register-selected-courses').attr('disabled', 'disabled');

    $('#course-registration-selection-table').click(function () {
        if ($('#course-registration-selection-table input:checkbox:checked').length == 0) {
            $('#register-selected-courses').attr('disabled', 'disabled');
        } else {
            $('#register-selected-courses').removeAttr('disabled');
        }
    });

    /**
     * View Scheduled-Table Submit Button
     */
    $('#dummy-view-schedule-table').click(function () {
        $(this).parents('form').submit();
    });

    /**
     * Alternating Time Table Schedule Coloring
     */
    $('table#time_column tr:odd td').css({
        'background-color': 'rgba(154, 23, 41, 0.1)',
    });
});