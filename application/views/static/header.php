<!DOCTYPE html>
<html lang="en">
<!-- P.A.S.T.A. header -->
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	
	<!-- style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />

	<!-- script -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>

	<!-- webfont -->
	<link href='http://fonts.googleapis.com/css?family=Seaweed+Script' rel='stylesheet' type='text/css'>
	
</head>
<body>
<div id="outter">
	<div id="header">
		<h1 id="top">Welcome to P.A.S.T.A.</h1>
		<h5 id="caption">Personal Academic Schedule Timetable Arranger</h5>
		<ul id="nav">
			<li><?php echo anchor(site_url("/login"), "login"); ?></li>
			<li><a href="">stats</a></li>
		</ul>
	</div>
