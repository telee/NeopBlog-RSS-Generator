<?php
	if (!isset($_GET['site'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>NeopBlog RSS Generator</title>
	<link rel="shortcut icon favicon" href="http://joyneop.github.io/joyneop.png">
	<link rel="apple-touch-icon" href="http://joyneop.github.io/joyneop.png">
</head>
<body>
	<header>
		<h1>NeopBlog RSS Generator</h1>
	</header>
	<div id="cont">
		<form action="index.php" method="GET">
			<input type="text" name="site" id="site" />
			<input type="submit" />
		</form>
	</div>
	<footer>
	</footer>
</body>
</html>
<?php
	} else {
		$site = $_GET['site'];
		rtrim($site, '/');
		ltrim($site, 'http://');
		ltrim($site, 'https://');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo '<meta http-equiv="refresh" content="0;url=http://app.joyneop.com/' . $url . '">'; ?>
</head>
<body>
</body>
</html>
<?php
	}
?>