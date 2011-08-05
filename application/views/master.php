<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <title>Simpleform Test</title>

  <meta name="robots" content="index,follow" />
  <meta name="author" content="Starfish Web Consulting" />


<style type="text/css" media="screen">

body { background-color: #fff; margin: 40px; font: 13px/20px normal Helvetica, Arial, sans-serif; color: #4F5155; text-align: center; }
a { color: #003399; background-color: transparent; font-weight: normal; }

h1 { color: #444; font-size: 3em; font-weight: normal; margin: 0 0 1em 0; padding: 0.5em 0; text-align: center; text-shadow: 1px 2px rgba(0,0,0,0.1); }

#wrap { display: block; text-align: left; margin: 0 auto; width: 600px; }
#nav { position: fixed; top: 5px; right: 5px; text-align: left; }
#nav li { list-style: none; }
#nav li a { display: inline-block;width: 10em; background: #000; padding: 5px; color: #fff; border-bottom: 1px solid #444; text-decoration: none; }
#nav li a:hover { background: #222; color: #69a; }

#footer { display: block; margin: 10em 0; clear: left; text-align: center; font-size: .9em; }

</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/simpleform.css" />

</head>

<body>

<ul id="nav">
  <li><?php echo anchor('simpleform', 'Form Demo'); ?></li>
  <li><?php echo anchor('simpleform/db_form', 'Generate from database table'); ?></li>
  <li><?php echo anchor('https://github.com/eoinmcg/simpleform/blob/master/README.md', 'Docs'); ?></li>
</ul


<div id="wrap">
  <?php $this->load->view($form); ?>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/simpleform.js"></script>


<div id="footer">

  <p>&copy; <a href="http://www.starfishwebconsulting.co.uk">Starfish Web Consulting</a></p>

</div>

</body>

</html>

