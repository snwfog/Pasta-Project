<?php

/*
* Natural course sequence of a first year software engineer student
* beginning his semester in September.
*/
	
$config['SOFT_ENG_COURSES'] = array(
	// Year 1
	"1" => array(
		// Fall
		"Fall" => array(
			array('COMP', '232'),
			array('COMP', '248'),
			array('ENGR', '201'),
			array('ENGR', '213'),
		),

		// Winter
		"Winter" => array(
			array('COMP', '249'),
			array('ENGR', '233'),
			array('SOEN', '228'),
			array('SOEN', '287'),
		),
	),

	// Year 2
	"2" => array(
		// Fall
		"Fall" => array(
			array('COMP', '348'),
			array('COMP', '352'),
			array('ENCS', '282'),
			array('ENGR', '202'),
		),

		// Winter
		"Winter" => array(
			array('COMP', '346'),
			array('ELEC', '275'),
			array('ENGR', '371'),
			array('SOEN', '331'),
			array('SOEN', '341'),
		),
	),

	// Year 3
	"3" => array(
		// Fall
		"Fall" => array(
			array('COMP', '335'),
			array('SOEN', '342'),
			array('SOEN', '343'),
			array('SOEN', '384'),	
		),

		// Winter
		"Winter" => array(
			array('SOEN', '344'),
			array('SOEN', '345'),
			array('SOEN', '357'),
			array('SOEN', '390'),
			array('SOEN', '385'),
		),
	),

	// Year 4
	"4" => array(
		// Fall
		"Fall" => array(
			array('ENGR', '301'),
			array('ENGR', '391'),
			array('SOEN', '490'),
		),

		// Winter
		"Winter" => array(
			array('SOEN', '385'),
			array('ENGR', '392'),
			array('SOEN', '490'),
		),
	),
);




?>