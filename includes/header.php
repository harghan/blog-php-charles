<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Blog de Godin Charles</title>
    <meta name="description" content="Blog de Godi Charles">
    <meta name="author" content="Jean-philippe Lannoy et Godin Charles">
	<script  type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
	<script type="text/javascript"  src="jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
  </head>

  <body>
  <?php	include('includes/connexion.inc.php');
	include('includes/fonctions.inc.php');
?>
    <div class="container">

      <div class="content">
      
        <div class="page-header well">
          <h1>Le blog de Godin Charles <small>afin de m'ameliorer en PHP !</small></h1>
        </div>
			
	<div class="row">
        
          <div class="span8">
          	<!-- notifications -->
          	
          	<!-- contenu -->
	<?php

		include('includes/notifications.inc.php'); 

	?>