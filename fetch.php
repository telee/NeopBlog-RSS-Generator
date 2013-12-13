<?php
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
<!--?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	-->
<html>
<head>
	<meta charset="utf-8" />
	<?php
		echo '<title>RSS feed of ' . $meta_json['blogName'] . '</title>';
	?>
	<style type="text/css">
	body {
		background: #333;
	}
	article {
		background: #FEFEFD;
		width: 640px;
		padding: 45px;
		margin: 60px auto;
	}
	</style>
</head>
<body>
<?php
	for ($i=$total-1; $i >= 0; $i--) { 
		$curl = curl_init();
		$post_url = 'http://neop.me/blog/db/' . $i . '.txt';
		curl_setopt($curl, CURLOPT_URL, $post_url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		curl_close($curl);
		echo '<article><h2>' . $list_json['list'][$i] . '</h2>' . $data . '</article>';
	}
?>
</body>
</html>