<!DOCTYPE html>
<html lang="en">
<!-- P.A.S.T.A. header -->
<head>
	<meta charset="utf-8">
	<!-- meta -->
	<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<title><?php echo $title; ?></title>
	
	<!-- style -->
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/reset.css' />
	
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/jquery-ui/jquery-ui-1.8.18.custom.css' />
	
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/style.css' />



	<!-- script -->
	<script type="text/javascript" src="<?=base_url();?>assets/js/library/jquery-1.7.2.min.js"></script>

	<script type="text/javascript" src="<?=base_url();?>assets/js/library/jquery-ui-1.8.18.custom.min.js"></script>

	<script type="text/javascript" src="<?=base_url();?>assets/js/library/jquery.blockUI.js"></script>

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
					echo anchor(site_url("pasta/logout"), "Logout");
			?>
		</li>
		<!-- <li><a href="">stats</a></li> -->
	</ul>
</div><!-- #header -->

<div id="outter">
	
