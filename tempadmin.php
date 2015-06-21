<?php
$thisurl =  $_SERVER['HTTP_HOST'];

if(($thisurl=="www.insidepulse.com")||($thisurl=="insidepulse.com")){
	$site = "insidepulse";
	$dbname = "insidepulsecom";
	$server = "localhost";
	$dbusername = "insidepulsecom";
	$dbpass = "v9L7rIf1ysG";
}
elseif(($thisurl=="www.insidepulse.net")||($thisurl=="insidepulse.net")){
	$site = "insidepulsedev";
	$dbname = "db145717_insidepulsenet_wp";
	$server = "internal-db.s145717.gridserver.com";
	$dbusername = "db145717";
	$dbpass = "8uhb8uhb";
}
elseif(($thisurl=="www.insidefights.com")||($thisurl=="insidefights.com")){
	$site = "insidefights";
	$dbname = "insidefightscom";
	$server = "localhost";
	$dbusername = "insidefightscom";
	$dbpass = "3mATJ2EqKsb";
}
elseif(($thisurl=="www.diehardgamefan.com")||($thisurl=="diehardgamefan.com")){
	$site = "diehardgamefan";
	$dbname = "diehardgamefanc";
	$server = "localhost";
	$dbusername = "diehardgamefanc";
	$dbpass = "98RbnRy2rWu";
}
elseif(($thisurl=="wrestling.insidepulse.com")||($thisurl=="wrestling.insidepulse.com")){
	$site = "wrestling";
	$dbname = "wrestlinginside";
	$server = "localhost";
	$dbusername = "wrestlinginside";
	$dbpass = "Fez0SgbAWnf";
}


/*db connection*/
$connection = mysql_connect($server, $dbusername, $dbpass) or die("Couldn't connect.");
$db = mysql_select_db($dbname) or die("Couldn't select database");


/*get vars*/
$action = $_GET['action'];




if($datef=="month"){
	$dateformat1 = "%Y %m";
}
elseif($datef=="day"){
	$dateformat1 = "%Y %m %d";
}
elseif($datef=="year"){
	$dateformat1 = "%Y";
}
else{
	$datef = "day";
	$dateformat1 = "%Y %m %d";
}


//functions
function autoimagesform($slug){

	$output .= "<form method='post' action='tempadmin.php?action=autoimages' style='width:400px;float:left;'>";
	if($slug){
		$output .= "<br><br>$slug<input id='slug' name='slug' type='hidden' value='$slug'>";
	}
	else{
		$output .= gettagdropdown();
	}
	$output .= "<br><br>120x120 - <input type='text' name='topstory120x120' id='topstory120x120'>";
	$output .= "<br><br>500x250 -<input type='text' name='topstory500x250' id='topstory500x250'>";
	$output .= "<input type='hidden' name='formsubmit' id='formsubmit' value='yes'>";
	$output .= "<br><br><input type='submit' value='Add AutoImg'>";
	$output .= "</form>";

	if($slug){
		$output .= "<iframe src='tempadmin.php?action=autoimages_log&slug=$slug' style='width:300px;float:left;height:200px;'></iframe>";
	}
	$output .= "<div style='clear:both;height:50px;'></div>";

	return $output;
}



function gettagdropdown(){
	$sql = "
	select wpt.term_id, wpt.name, wpt.slug, wtt.count
	from wp_terms wpt, wp_term_taxonomy wtt
	where wtt.taxonomy = 'post_tag'
	and wpt.term_id = wtt.term_id
	order by wpt.name
	";

	$result = mysql_query($sql) or die($sql);
	$output .= "<select name='slug' id='slug'>
	<option value=''>--- tag ---</option>
	";

	while($row=mysql_fetch_array($result)){
		$term_id = $row['term_id'];
		$name = $row['name'];
		$slug = $row['slug'];
		$count = $row['count'];

		$output .= "<option value='$slug'>$name ($count)</option>
		";
	}
	$output.="</select>";

	return $output;

}

function authordropdown(){
	$sql = "
	select *
	from wp_users
	order by display_name
	";

	$result = mysql_query($sql) or die($sql);


	$output.="<select id='author_id' name='author_id'>";
	$output .= "<option value=''>--- choose --- </option>";

	while($row=mysql_fetch_array($result)){
		$display_name = $row['display_name'];
		$ID = $row['ID'];

		$output .= "<option value='$ID'>$display_name</option>
		";
	}
	$output.="</select>";

	return $output;
}










if($action=="post_count"){

	if($_GET['author_id']){
		$author_id = $_GET['author_id'];
		$sqladd = "and post_author = $author_id";
	}


	$sql = "
	select count(id) as total, date_format(post_date,'$dateformat1') as date
	from wp_posts
	where post_status = 'publish'
	$sqladd
	group by date
	order by date desc
	";

	$result = mysql_query($sql) or die($sql);

	$headertext = "Posts by ";

	$output.= "<div class='filter_bar'>";
	$output.= "<form id='filterform' name='filterform' method='get'>";
	$output.= "Filter by:";
	$output.= authordropdown();
	$output.= "<input type='submit' class='filterbutton' value='Filter Submit!'>";
	$output.= "<input type='hidden' id='action' name='action' value='$action'>";
	$output.= "</form>";
	$output.= "</div>";

	$output.="<table>";
	$output .= "<tr>";
	$output .= "<th>Date</th>";
	$output .= "<th>Total</th>";
	$output .= "</tr>";

	$starttotal = 0;
	while($row=mysql_fetch_array($result)){
		$total = $row['total'];
		$date = $row['date'];

		$output .= "<tr>";
		$output .= "<td>$date</td>";
		$output .= "<td>$total</td>";
		$output .= "</tr>";
	}
	$output.="</table>";

}




if($action=="autoimages_log"){

	$getslug = $_GET['slug'];

	$sql = "
	select *
	from autoimages_log
	where tag_slug = '$getslug'
	order by tag_slug
	";

	$result = mysql_query($sql) or die($sql);

	$headertext = "Auto Images Log for $getslug";

	$output.="<table>";

	if(mysql_num_rows($result)>0){
		$output .= "<tr>";
		$output .= "<th colspan=2>Log of old entries</th>";
		$output .= "</tr>";
		$output .= "<tr>";
		$output .= "<th>120x120</th>";
		$output .= "<th>500x250</th>";
		$output .= "</tr>";
		while($row=mysql_fetch_array($result)){
			$tag_slug = $row['tag_slug'];
			$topstory120x120 = $row['topstory120x120'];
			$topstory500x250 = $row['topstory500x250'];

			$output .= "<tr>";
			$output .= "<td><img src='$topstory120x120' height=50></td>";
			$output .= "<td><img src='$topstory500x250' height=50></td>";
			$output .= "</tr>";
		}
	}
	else{
		$output .= "<tr>";
		$output .= "<th colspan=2>NONE</th>";
		$output .= "</tr>";
	}
	$output.="</table>";
	echo $output;
	exit();
}

if($action=="autoimages"){

	$getslug = $_GET['slug'];

	if($_POST['formsubmit']=='yes'){

		$postedslug = $_POST['slug'];
		$getslug = $_POST['slug'];
		$topstory120x120_new = $_POST['topstory120x120'];
		$topstory500x250_new = $_POST['topstory500x250'];

		$sql1 = "
		select *
		from autoimages
		where tag_slug = '$postedslug'
		order by tag_slug
		";

		$result1 = mysql_query($sql1) or die($sql1);

		while($row1=mysql_fetch_array($result1)){
			$topstory120x120_old = $row1['topstory120x120'];
			$topstory500x250_old = $row1['topstory500x250'];
		}

		if($topstory120x120_old){


			$sql2a1 = "
			insert into autoimages_log
			(tag_slug, topstory120x120, topstory500x250)
			VALUES
			('$postedslug', '$topstory120x120_old', '$topstory500x250_old')
			";

			$result2a1 = mysql_query($sql2a1) or die($sql2a1);

			$sql2a2 = "
			update autoimages
			set topstory120x120 = '$topstory120x120_new', topstory500x250 = '$topstory500x250_new'
			where tag_slug = '$postedslug'
			";

			$result2a2 = mysql_query($sql2a2) or die($sql2a2);


		}
		else{
			$sql2b = "
			insert into autoimages
			(tag_slug, topstory120x120, topstory500x250)
			VALUES
			('$postedslug', '$topstory120x120_new', '$topstory500x250_new')
			";

			$result2b = mysql_query($sql2b) or die($sql2b);
		}


	}

	$sql = "
	select *
	from autoimages
	order by tag_slug
	";

	$result = mysql_query($sql) or die($sql);

	$headertext = "Auto Images";

	$output .= autoimagesform($getslug);

	$output.="<table>";
	$output .= "<tr>";
	$output .= "<th>slug</th>";
	$output .= "<th>120x120</th>";
	$output .= "<th>500x250</th>";
	$output .= "<th>Edit</th>";
	$output .= "<th>View Log</th>";
	$output .= "</tr>";

	while($row=mysql_fetch_array($result)){
		$tag_slug = $row['tag_slug'];
		$topstory120x120 = $row['topstory120x120'];
		$topstory500x250 = $row['topstory500x250'];

		$output .= "<tr>";
		$output .= "<td>$tag_slug</td>";
		$output .= "<td><img src='$topstory120x120' height=50></td>";
		$output .= "<td><img src='$topstory500x250' height=50></td>";
		$output .= "<td><a href='tempadmin.php?action=autoimages&slug=$tag_slug'>Edit</a></td>";
		$output .= "<td><a href='tempadmin.php?action=autoimages_log&slug=$tag_slug'>View Log</a></td>";
		$output .= "</tr>";
	}
	$output.="</table>";

}



if($action=="socialmedialinks"){

	//hardcode change to only ip db
	$site = "insidepulse";
	$dbname = "insidepulsecom";
	$server = "localhost";
	$dbusername = "insidepulsecom";
	$dbpass = "v9L7rIf1ysG";

	/*db connection*/
	$connection = mysql_connect($server, $dbusername, $dbpass) or die("Couldn't connect.");
	$db = mysql_select_db($dbname) or die("Couldn't select database");

	$sql = "
	select *
	from socialmedialinks
	where 1 = 1
	order by name
	";

	$result = mysql_query($sql) or die($sql);

	$headertext = "Twitter and Instagram Links";

	$output.="<table>";
	$output .= "<tr>";
	$output .= "<th>zone</th>";
	$output .= "<th>zone2</th>";
	$output .= "<th>name</th>";
	$output .= "<th>twitter</th>";
	$output .= "<th>instagram</th>";
	$output .= "</tr>";

	while($row=mysql_fetch_array($result)){
		$zone = $row['zone'];
		$zone2 = $row['zone2'];
		$name = $row['name'];
		$twitter = $row['twitter'];
		$instagram = $row['instagram'];

		$output .= "<tr>";
		$output .= "<td>$zone</td>";
		$output .= "<td>$zone2</td>";
		$output .= "<td>$name</td>";
		$output .= "<td><a href='$twitter'>$twitter</a></td>";
		$output .= "<td><a href='$instagram'>$instagram</a></td>";
		$output .= "</tr>";

	}
	$output.="</table>";
}
?>




<html>
<head>
<title>Temp Admin</title>
<style>
body{
	margin:0;
	padding:0;
	font-family:arial;
	font-size:14px;
}

a{
	color:#0000ff;
	font-size:14px;
}

a:hover{
	color:#990000;
}

table{
	text-align:left;
	font-size:10px;
}

td{
	border:1px solid #777777;
}

th{
	background:#666666;
	border:1px solid #777777;
	color:#eeeeee;
}

.tablerow1{
	background:#dddddd;
}

.tablerow2{
	background:#dedede;
}


.output{
	width:98%;
	height:auto;
	border:2px solid #999999;
	overflow:scroll;
}


.content{
	width:100%;
	min-height:500px;
	background:#eeeeee;
	margin: 0 auto;
	text-align:center;
	border:2px solid #000000;
	box-shadow: 10px 10px 5px #888888;
}

.admin_top{
	width:100%;
	height:40px;
	padding:10px;
	font-size:36px;
	background:#333333;
	color:#ffffff;
	font-weight:bold;
	margin: 0 auto;
	text-align:center;

}

.admin_nav{
	width:100%;
	height:auto;
	padding-top:5px;
	padding-bottom:5px;
	font-size:14px;
	background:#eeeeee;
	margin: 0 auto;
	text-align:center;

}

.title_bar{
	width:100%;
	height:50px;
	font-size:24px;
	font-weight:bold;
	color:#6A22CC;
	background:#dddddd;
	border:1px #bbbbbb solid;
	padding:10px;
	margin: 0 auto;
	text-align:center;
}

.title_bar h4{
	color:#666666;
	margin:1px;
	font-size:16px;
}


.admin_nav div.cell{
	padding:5px;
	margin:2px;
	font-size:14px;
	color:#6A22CC;
	background:#ffffff;
	float:left;
	width:100px;
	height:20px;
	border:1px solid #000000;
	box-shadow: 4px 4px 4px #888888;
	text-transform:uppercase;
	cursor:pointer;
}

.admin_nav div.cell:hover{
	color:#ffffff;
	background:#6A22CC;
	cursor:pointer;
}

.admin_nav div.active{
	background:#000000;
	color:#ffffff;
}

.admin_nav div.cell a{
	color:#6A22CC;
	font-weight:bold;
	text-decoration:none;
}

.admin_nav div.cell:hover a{
	color:#ffffff;
}

.admin_nav div.active a{
	color:#ffffff;
}


.filter_bar{
	width:100%;
	height:30px;
	padding:5px;
	font-size:14px;
	background:#eeeeee;
	margin: 0 auto;
	text-align:center;
	font-size:11px;
}

.filter_bar select{
	font-size:11px;
}

.filterbutton{
	background:#ffffff;
	border: #6A22CC 1px solid;

}

.admin_body{
	width:100%;
	height:40px;
	padding:20px;
	font-size:14px;
	color:#333333;
	text-align:left;
	height:auto;
}

.clear{
	clear:both;
}


</style>

</head>

<body>
<div class="content">

	<div class="admin_top">
		Inside Pulse Non-Wordpress Admin Tools
	</div>
	<div class="admin_nav">
		<div class="cell<?php if($site=="insidepulse"){echo " active";} ?>"><a href="http://insidepulse.com/wp-content/themes/version7/tempadmin.php">Inside Pulse</a></div>
		<div class="cell<?php if($site=="insidefights"){echo " active";} ?>"><a href="http://insidefights.com/wp-content/themes/version7/tempadmin.php">Ins Fights</a></div>
		<div class="cell<?php if($site=="wrestling"){echo " active";} ?>"><a href="http://wrestling.insidepulse.com/wp-content/themes/version7/tempadmin.php">Wrestling</a></div>
		<div class="cell<?php if($site=="diehardgamefan"){echo " active";} ?>"><a href="http://diehardgamefan.com/wp-content/themes/version7/tempadmin.php">Diehard</a></div>
		<div class="cell<?php if($site=="dev"){echo " active";} ?>"><a href="http://insidepulse.net/wp-content/themes/version7/tempadmin.php">Dev .net</a></div>
		<div class="clear"></div>
	</div>
	<div class="admin_nav">
		<div class="cell<?php if($action==""){echo " active";} ?>"><a href="tempadmin.php">Home</a></div>
		<div class="cell<?php if($action=="post_count"){echo " active";} ?>"><a href="tempadmin.php?action=post_count"># of Posts</a></div>
		<div class="cell<?php if($action=="autoimages"){echo " active";} ?>"><a href="tempadmin.php?action=autoimages">AutoImg</a></div>
		<div class="cell<?php if($action=="socialmedialinks"){echo " active";} ?>"><a href="tempadmin.php?action=socialmedialinks">Social Media Link</a></div>
		<div class="clear"></div>
	</div>
<?php
if($headertext){
?>
	<div class="title_bar">
		<?php echo $headertext ?>
		<?php echo $headertext2 ?>
	</div>
<?php
}
?>
<?php if($showbottomlinks){
	$output.="<table>";
	$output .= "<tr>";
	$output .= "<td colspan=10 align=center>$prevlink | $nextlink</td>";
	$output .= "</tr>";
	$output.="</table>";
}
?>
<?php if($action==""){
?>
<div style="text-align:left;">

FAQ:
<ul>
<li><a href=#question1>What is TempAdmin?</a></li>
<li><a href=#question18>What is TempAdmin?</a></li>

</ul>

<div style="text-align:left;">
<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question1"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>

<a name="question18"></a><h3>What is TempAdmin?</h3>
<p>Art party leggings direct trade chambray. Echo Park cardigan cliche, Brooklyn normcore seitan cred single-origin coffee fashion axe. Mumblecore keffiyeh Portland wayfarers. Pour-over ugh shabby chic bespoke, literally Etsy wolf readymade narwhal keytar ethnic cliche. Pickled tofu Cosby sweater ethical art party mixtape, selvage roof party street art cornhole cardigan PBR hashtag meh mumblecore. Hoodie food truck Shoreditch cred, tattooed asymmetrical lomo hashtag vinyl scenester Godard before they sold out twee. Biodiesel ennui messenger bag, craft beer American Apparel fixie 3 wolf moon mlkshk Austin Godard.</p>
</div>

<?php
}
?>




<?php echo $output; ?>

</body>
</html>