<?php
	/*
	* Core file of NeopBlog External RSS Generator
	* File Name: fetch-rss.php
	* File Version: 0.6.0
	* File Staus: Alpha
	* Developer: Joy Neop
	*/
	if (isset($_GET['dir'])) {
		$path = $_GET['domain'] . '/' . $_GET['dir'];
		$if_sub_dir = true;
	} else {
		$path = $_GET['domain'];
		$if_sub_dir = false;
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
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>
<rss>
<channel>
<?php
	if ($total > 99) {
		$total = 99;
	}
	//Channel
	echo '<title>' . $meta_json['blogName'] . '</title>';
	if ($if_sub_dir) {
		echo '<atom:link href="http://app.joyneop.com/nb-rss/index.php?domain=' . $_GET['domain'] . '&dir=' . $_GET['dir'] . '" rel="self" type="application/rss+xml" />';
	} else {
		echo '<atom:link href="http://app.joyneop.com/nb-rss/index.php?domain=' . $_GET['domain'] . '" rel="self" type="application/rss+xml" />';
	}
	echo '<link>http://' . $path . '/</link>';
	echo '<language>en-US</language><sy:updatePeriod>hourly</sy:updatePeriod><sy:updateFrequency>1</sy:updateFrequency>';
	echo '<generator>http://app.joyneop.com/nb-rss/?v=3.7.1</generator>';
	//Items
	for ($i=$total-1; $i >= 0; $i--) { 
		$curl = curl_init();
		$post_url = 'http://neop.me/blog/db/' . $i . '.txt';
		curl_setopt($curl, CURLOPT_URL, $post_url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		curl_close($curl);
		echo '<item>';
		echo '<title>' . $list_json['list'][$i]['postTitle'] . '</title>';
		echo '<link>http://' . $path . '/p=' . $i . '</link>';
		echo '<comments>http://' . $path . '/p=' . $i . '</comments>';
		echo '<pubDate>' . $list_json['list'][$i]['postDate'] . ' +0000</pubDate>';
		echo '<dc:creator><![CDATA[' . $meta_json['blogName'] . ']]></dc:creator>';
		echo '<category><![CDATA[' . $list_json['list'][$i]['postCate'] . ']]></category>';
		echo '<guid isPermaLink="true">http://' . $path . '/?p=' . $i . '</guid>';
		echo '<description></description>';
		echo '<content:encoded><![CDATA[' . $data . ']]</content:encoded>';
		echo '<slash:comments>0</slash:comments>';
		echo '</item>';
	}
?>
</channel>
</rss>