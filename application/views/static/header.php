<!DOCTYPE html>
<html lang="en">
<!-- P.A.S.T.A. header -->
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	
	<!-- style -->
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/reset.css' />
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/style.css' />

	<!-- script -->
	<script type="text/javascript" src="<?=base_url();?>assets/js/library/jquery-1.7.2.min.js "></script>
	<script type="text/javascript" src="<?=base_url();?>assets/js/script.js"></script>
	
</head>
<body>

<div id="header">
	<h1 id="top">P.A.S.T.A.</h1>
	<h5 id="caption">Personal Academic Schedule Timetable Arranger</h5>
	<ul id="nav">
		<li>
			<?php 
				if ($this->session->userdata('logged_in'))
					echo anchor(site_url("login/logout"), "logout");
			?>
		</li>
		<!-- <li><a href="">stats</a></li> -->
	</ul>
</div><!-- #header -->

<div id="outter">
	
