<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<?php
/*
Template Name: Images
*/

if($_GET['limit']){
	$limit = $_GET['limit'];
}
else{
	$limit = 60;
}


if($_GET['offset']){
	$offset = $_GET['offset'];
}
else{
	$offset = 0;
}

if($_GET['pagepage']){
	$currentpage = $_GET['pagepage'];
}
else{
	$currentpage = 1;
}

if($_GET['filter']){
	$filter = $_GET['filter'];
	$filtersql = "AND meta_value LIKE '%" . $filter . "%'";
}
else{
	$filter = "";
}

$formzone = "wrestling";
$formimagetype = "topstory120x120";
$imageclass = "img90";
$offset = $limit * ($currentpage-1);


$sqlimages1 = "
SELECT DISTINCT meta_value, post_id
FROM wp_postmeta
WHERE meta_key = '$formimagetype'
$filtersql
ORDER by post_id DESC
LIMIT $limit OFFSET $offset
";


$resultimages1 = mysql_query($sqlimages1) or die($sqlimages1);

$totalimages = mysql_num_rows($resultimages1);

$totalpages = ceil($totalimages/$limit);
for($i=0;$i<$totalimages;$i++){
	$rowimages1 = mysql_fetch_array($resultimages1);
	$meta_value = $rowimages1['meta_value'];
	$post_id = $rowimages1['post_id'];


	$sqlimages2 = "
	SELECT meta_value, post_id
	FROM wp_postmeta
	WHERE meta_key = 'topstory500x250'
	AND post_id = '$post_id'
	LIMIT 1
	";

	$meta_value2 = "";
	$resultimages2 = mysql_query($sqlimages2) or die($sqlimages2);
	while($rowimages2 = mysql_fetch_array($resultimages2)){
		$meta_value2 = $rowimages2['meta_value'];
	}



	$name = $rowimages1['meta_value'];
	$name = str_replace("http://tv.insidepulse.com/", "", $name);
	$name = str_replace("http://movies.insidepulse.com/", "", $name);
	$name = str_replace("http://sports.insidepulse.com/", "", $name);
	$name = str_replace("http://music.insidepulse.com/", "", $name);
	$name = str_replace("http://games.insidepulse.com/", "", $name);
	$name = str_replace("http://commercials.insidepulse.com/", "", $name);
	$name = str_replace("http://figures.insidepulse.com/", "", $name);
	$name = str_replace("http://celebrities.insidepulse.com/", "", $name);
	$name = str_replace("http://comicsnexus.insidepulse.com/", "", $name);
	$name = str_replace("http://insidefights.com/", "", $name);
	$name = str_replace("http://diehardgamefan.com/", "", $name);
	$name = str_replace("http://radioexile.com/", "", $name);
	$name = str_replace("http://machinegunfunk.com/", "", $name);
	$name = str_replace("http://justeyeballit.com/", "", $name);
	$name = str_replace("http://thosebeersnobs.com/", "", $name);
	$name = str_replace("http://moodspins.com/", "", $name);
	$name = str_replace("http://ihatejonconway.com/", "", $name);
	$name = str_replace("http://wrestling.insidepulse.com/", "", $name);
	$name = str_replace("http://media.insidepulse.com/", "", $name);

	$name = str_replace("wordpress/wp-content/uploads/", "", $name);
	$name = str_replace("zones/", "", $name);
	$name = str_replace("2008/", "", $name);
	$name = str_replace("2009/", "", $name);
	$name = str_replace("2010/", "", $name);
	$name = str_replace("2011/", "", $name);
	$name = str_replace("2012/", "", $name);
	$name = str_replace("2013/", "", $name);
	$name = str_replace("2014/", "", $name);
	$name = str_replace("2015/", "", $name);
	$name = str_replace("01/", "", $name);
	$name = str_replace("02/", "", $name);
	$name = str_replace("03/", "", $name);
	$name = str_replace("04/", "", $name);
	$name = str_replace("05/", "", $name);
	$name = str_replace("06/", "", $name);
	$name = str_replace("07/", "", $name);
	$name = str_replace("08/", "", $name);
	$name = str_replace("09/", "", $name);
	$name = str_replace("10/", "", $name);
	$name = str_replace("11/", "", $name);
	$name = str_replace("12/", "", $name);
	$name = str_replace(".jpg", "", $name);
	$name = str_replace(".gif", "", $name);
	$name = str_replace(".png", "", $name);
	$name = str_replace(".bmp", "", $name);
	$name = str_replace("120x120", "", $name);

	$meta_value = trim($meta_value);
	$meta_value2 = trim($meta_value2);

	$build = "
	<div style=\"width:96px; font-size:9px; height:200px;background:#ffffff;float:left;\">
		<a href=$meta_value target=_blank><img src=$meta_value border=0 style=\"width:90px; height:90px;\"></a>
		<br>
		<b>$name</b>
		<br>
		120: <input onclick=\"this.select()\" type=text size=4 value='$meta_value'>
		<br>
		500: <input onclick=\"this.select()\" type=text size=4 value='$meta_value2'>

	</div>
	";

	if($filter){
		if(strstr($name, $filter)){
			$content .= $build;

		}
	}
	else{
		$content .= $build;
	}

}

//$totalpages = ceil((int)$totalarticlescount/(int)$limit);
//build nav
for($i=0;$i<$totalpages; $i++){
	$thispage = $i+1;

	if($currentpage==$thispage){
		$numberlinks .= "<b>$thispage</b> | ";
	}
	else{
		$numberlinks .= "<a href=?page=$thispage>$thispage</a> | ";
	}
}

if($currentpage==1){
	$nextpage = $currentpage+1;
	$nextlink = "<a href=?formsubmit=formsubmit&formzone=$formzone&formimagetype=$formimagetype&pagepage=$nextpage>Next</a>";
}

elseif($currentpage==$totalpages){
	$prevpage = $currentpage-1;
	$prevlink = "<a href=?formsubmit=formsubmit&formzone=$formzone&formimagetype=$formimagetype&pagepage=$prevpage>Previous</a>";
}
else{
	$nextpage = $currentpage+1;
	$prevpage = $currentpage-1;
	$nextlink = "<a href=?formsubmit=formsubmit&formzone=$formzone&formimagetype=$formimagetype&pagepage=$nextpage>Next</a>";
	$prevlink = "<a href=?formsubmit=formsubmit&formzone=$formzone&formimagetype=$formimagetype&pagepage=$prevpage>Previous</a>";
}

?>


<div class=container_basic>
	<form method=get><div class="top_story_headline">
	Filter: <input type=text name=filter id=filter> <input type=submit>
	</div></form>

	<?php echo $content ?>

</div>

<div class=container_basic>
	<div class=container_left_listing_navlinks>
		<div class=navlink_left>
			<?php echo $prevlink ?>
		</div>
		<div class=navlink_right>
			<?php echo $nextlink ?>
		</div>
	</div>
</div>