<?php
	/*
	* Core file of NeopBlog External RSS Generator
	* File Name: fetch.php
	* File Version: 0.6.7
	* File Staus: Alpha
	* Developer: Joy Neop
	*/
	if (isset($_GET['dir'])) {
		$path = $_GET['domain'] . '/' . $_GET['dir'];
	} else {
		$path = $_GET['domain'];
	}
	$meta = curl_init();
	$meta_url = 'http://' . $path . '/meta.json';
	curl_setopt($meta, CURLOPT_URL, $meta_url);
	curl_setopt($meta, CURLOPT_HEADER, 0);
	curl_setopt($meta, CURLOPT_RETURNTRANSFER, 1);
	$meta_info = curl_exec($meta);
	curl_close($meta);

	//Eval meta.json

	$meta_json = json_decode($meta_info, true);
	$total = $meta_json['totalPosts'];

	//If allowed to fetch

	if ($meta_json['rss'] == "off") {
		die("This blog does not allow fetching feed");
	}

	//Get list

	$list = curl_init();
	$list_url = 'http://' . $path . '/list.json';
	curl_setopt($list, CURLOPT_URL, $list_url);
	curl_setopt($list, CURLOPT_HEADER, 0);
	curl_setopt($list, CURLOPT_RETURNTRANSFER, 1);
	$list_info = curl_exec($list);
	curl_close($list);

	//Eval list.json

	$list_json = json_decode($list_info, true);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<?php
		if ($total > 50) {
			echo '<title>Latest 50 posts of ' . $meta_json['blogName'] . '</title>';
		} else {
			echo '<title>All ' . $total . ' posts of ' . $meta_json['blogName'] . '</title>';
		}
		echo '<base href="http://' . $path . '/"></base>';
	?>
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<link rel="stylesheet" type="text/css" href="css/theme_common.css">
	<link rel="stylesheet" type="text/css" href="css/theme_desktop.css">
	<link rel="stylesheet" type="text/css" href="css/theme_mobile.css">
	<style type="text/css">
	section.post {
		display: block;
	}
	</style>
	<link rel="favicon shortcut icon apple-touch-icon" href="favicon.png">
</head>
<body>
<header id="global-header" class="global">
	<h1><?php echo $meta_json['blogName']; ?></h1>
</header>
<div id="cont">
<?php
	if ($total > 50) {
		$total = 50;
	}
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	for ($i=$total-1; $i >= 0; $i--) { 
		
		$post_url = 'http://' . $path . '/db/' . $i . '.txt';
		curl_setopt($curl, CURLOPT_URL, $post_url);
		$data = curl_exec($curl);
		echo '<section class="post"><h2><a class="post-title" href="./?p=' . $i . '">' . $list_json['list'][$i]['postTitle'] . '</a></h2>';
		echo '<div class="post-text">' . $data . '</div>';
		echo '<footer><a href="./?p=' . $i . '">' . $list_json['list'][$i]['postDate'] . '</a></footer></section>';
	}
	curl_close($curl);
?>
</div>
<footer id="global-header" class="global">
	<?php
		echo '<a href="http://' . $path . '">&copy; 2013 All Rights Reserved by ' . $meta_json['blogName'] . '</a>';
	?>
</footer>
</body>
</html>