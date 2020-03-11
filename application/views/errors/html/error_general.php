<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
<style type="text/css">
html {
	background: #eee;
}
body {
	background: #fff;
	color: #333;
	font-family: "Open Sans", sans-serif;
	margin: 2em auto;
	padding: 1em 2em;
	border-top:7px solid #4372a6;
	max-width: 700px;
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.13);
	box-shadow: 0 1px 3px rgba(0,0,0,0.13);
}
h1 {
	border-bottom: 1px solid #dadada;
	clear: both;
	color: #666;
	font: 24px "Open Sans", sans-serif;
	margin: 30px 0 0 0;
	padding: 0;
	padding-bottom: 7px;
}
hr {
	border-top: 1px solid #ccc;
	border-bottom:none;
	margin-top: 15px;
	margin-bottom: 15px;
}
#error-page {
	margin-top: 50px;
}
#error-page p {
	font-size: 14px;
	line-height: 1.5;
	margin: 25px 0 20px;
}
#error-page code {
	font-family: Consolas, Monaco, monospace;
}
ul li {
	margin-bottom: 10px;
	font-size: 14px ;
}
a {
	color: #21759B;
	text-decoration: none;
}
a:hover {
	color: #D54E21;
}
.button {
	background: #f7f7f7;
	border: 1px solid #cccccc;
	color: #555;
	display: inline-block;
	text-decoration: none;
	font-size: 13px;
	line-height: 26px;
	height: 28px;
	margin: 0;
	padding: 0 10px 1px;
	cursor: pointer;
	-webkit-border-radius: 3px;
	-webkit-appearance: none;
	border-radius: 3px;
	white-space: nowrap;
	-webkit-box-sizing: border-box;
	-moz-box-sizing:    border-box;
	box-sizing:         border-box;

	-webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0,0,0,.08);
	box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0,0,0,.08);
 	vertical-align: top;
}

.button.button-large {
	height: 29px;
	line-height: 28px;
	padding: 0 12px;
}

.button:hover,
.button:focus {
	background: #fafafa;
	border-color: #999;
	color: #222;
}

.button:focus  {
	-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.2);
	box-shadow: 1px 1px 1px rgba(0,0,0,.2);
}

.button:active {
	background: #eee;
	border-color: #999;
	color: #333;
	-webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
 	box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
}
</style>
</head>

<body id="error-page">
	<h1><?php echo $heading; ?></h1>
	<?php echo $message; ?>
</body>
</html>