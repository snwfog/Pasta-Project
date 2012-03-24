<?php

/*
* Natural course sequence of a first year software engineer student
* beginning his semester in September.
*/
	
$config['soft_eng_courses'] = array(
	// Year 1
	"1" => array(
		// Fall
		"2" => array(
			array('COMP', '232'),
			array('COMP', '248'),
			array('ENGR', '201'),
			array('ENGR', '213'),
		),

		// Winter
		"4" => array(
			array('COMP', '249'),
			array('ENGR', '233'),
			array('SOEN', '228'),
			array('SOEN', '287'),
		),
	),

	// Year 2
	"1" => array(
		// Fall
		"2" => array(
			array('COMP', '348'),
			array('COMP', '352'),
			array('ENCS', '282'),
			array('ENGR', '202'),
		),

		// Winter
		"4" => array(
			array('COMP', '346'),
			array('ELEC', '275'),
			array('ENGR', '371'),
			array('SOEN', '331'),
			array('SOEN', '341'),
		),
	),

	// Year 3
	"1" => array(
		// Fall
		"2" => array(
			array('COMP', '335'),
			array('SOEN', '342'),
			array('SOEN', '343'),
			array('SOEN', '384'),	
		),

		// Winter
		"4" => array(
			array('SOEN', '344'),
			array('SOEN', '345'),
			array('SOEN', '357'),
			array('SOEN', '390'),
			array('SOEN', '385'),
		),
	),

	// Year 4
	"1" => array(
		// Fall
		"2" => array(
			array('ENGR', '301'),
			array('ENGR', '391'),
			array('SOEN', '490'),
		),

		// Winter
		"4" => array(
			array('SOEN', '385'),
			array('ENGR', '392'),
			array('SOEN', '490'),
		),
	),

	"Basic Science" => array(
		array('BIOL', '206'),
		array('BIOL', '208'),	
		array('BIOL', '226'),	
		array('BIOL', '261'),	
		array('CHEM', '209'),	
		array('CHEM', '217'),	
		array('CHEM', '221'),	
		array('CHEM', '234'),	
		array('GEOL', '206'),	
		array('GEOL', '208'),	
		array('PHYS', '252'),	
		array('PHYS', '253'),	
		array('PHYS', '273'),	
		array('PHYS', '334'),	
		array('PHYS', '354'),	
		array('PHYS', '384'),	
		array('PHYS', '385'),	
	),

	// General Elective
	"General Electives" => array(

		"Social Sciences" =>  array(
			array('AHSC', '241'),
			array('ANTH', '202'),
			array('ECON', '201'),
			array('ECON', '203'),
			array('EDUC', '230'),
			array('ENCS', '283'),
			array('GEOG', '203'),
			array('GEOG', '204'),
			array('GEOG', '210'),
			array('GEOG', '220'),
			array('INST', '250'),
			array('LING', '222'),
			array('LING', '300'),
			array('POLI', '202'),
			array('POLI', '213'),
			array('POLI', '390'),
			array('RELI', '214'),
			array('RELI', '215'),
			array('RELI', '216'),
			array('RELI', '218'),
			array('RELI', '310'),
			array('RELI', '312'),
			array('RELI', '374'),
			array('SCPA', '201'),
			array('SCPA', '215'),
			array('SOCI', '203'),
			array('WSDB', '290'),
			array('WSDB', '291'),
		),
			 
		"Humanities" => array(
			array('ARTH', '353'),
			array('ARTH', '354'),
			array('CLAS', '266'),
			array('COMS', '360'),
			array('ENGL', '224'),
			array('ENGL', '233'),
			array('FLIT', '230'),
			array('FLIT', '240'),
			array('FMST', '214'),
			array('FMST', '215'),
			array('HIST', '201'),
			array('HIST', '202'),
			array('HIST', '205'),
			array('HIST', '281'),
			array('HIST', '283'),
			array('LBCL', '201'),
			array('LBCL', '202'),
			array('LBCL', '203'),
			array('LBCL', '204'),
			array('PHIL', '201'),
			array('PHIL', '210'),
			array('PHIL', '232'),
			array('PHIL', '233'),
			array('PHIL', '235'),
			array('PHIL', '275'),
			array('PHIL', '330'),
			array('THEO', '202'),
			array('THEO', '204'),
			array('THEO', '233'),
		),
			 
		"Others" => array(
			array('ADMI', '201'),
			array('ADMI', '202'),
			array('MANA', '213'),
			array('MANA', '266'),
			array('MANA', '300'),
			array('MARK', '201'),
			array('URBS', '230'),
		),
	),

	"Technical Electives" => array(
		"Computer Games (CG)" => array( 
			array('COMP', '345'),
			array('COMP', '371'),
			array('COMP', '376'),	
			array('COMP', '472'),	
			array('COMP', '476'),	
			array('COMP', '477'),	
		), 
		// Web Services and Applications (WSA)
		"Web Services and Applications" => array(
			array('COMP', '353'),	
			array('COMP', '445'),	
			array('COMP', '479'),	
			array('SOEN', '321'),	
			array('SOEN', '387'),	
			array('SOEN', '487'),
		),	

		"Real-Time, Embedded, and Avionics Software (REA)" => array(
			array('COEN', '317'),	
			array('COEN', '320'),	
			array('COMP', '345'),	
			array('COMP', '444'),	
			array('SOEN', '422'),	
			array('SOEN', '423'),	
			array('MECH', '480'),	
			array('MECH', '482'),	
		),
		
		"Others" => array(	
			array('COMP', '426'),	
			array('COMP', '428'),	
			array('COMP', '442'),	
			array('COMP', '444'),	
			array('COMP', '451'),	
			array('COMP', '465'),	
			array('COMP', '473'),	
			array('COMP', '474'),	
			array('COMP', '478'),	
			array('SOEN', '423'),	
			array('SOEN', '431'),	
			array('SOEN', '448'),	
			array('ENGR', '411'),
		),	
	),
);




?>