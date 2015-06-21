<?php

//live ip.com db connect
$dbname = "db56814_insidepulse_wp";
$dbserver = "internal-db.s56814.gridserver.com";
$dbuser = "db56814";
$dbpass = "Hr6EMRb7";

//connect to db
$connection = mysql_connect($dbserver, $dbuser, $dbpass) or die("Couldn't connect.");
$db = mysql_select_db($dbname) or die("Couldn't select database");

//get vars
$action = $_GET['action'];


function tablestart(){
	return "<table>";
}

function tablerow($vals, $isheader = false){
	$output .= "<tr>";
	foreach($vals as $val){
		if($isheader){
			$output .="<th>" . strtoupper($val) . "</th>";
		}
		else{
			$output .="<td>" . $val . "</td>";
		}
	}
	$output .= "</tr>";
	return $output;
}

function tableend(){
	return "</table>";
}



if($action=="authors_time_period"){

	//action nicename
	$action_nicename = "Active Staff";

	$sql = "
	select count(p.ID) as posts, u.display_name, u.user_email
	from wp_users u, wp_posts p
	where p.post_author = u.ID
	and p.post_date > '2013-09-01'
	and post_status = 'publish'
	group by p.post_author;
	";
	
	$result = mysql_query($sql) or die($sql);
	
	$fields = array('posts', 'display_name', 'user_email');
	
	$output .= tablestart();
	$output .= tablerow($fields, true);
	while($row = mysql_fetch_array($result)){
		$vals = array();
		foreach($fields as $field){
			$vals[$field] = $row[$field];
		}

		$output .= tablerow($vals);
	}
	$output .= tableend();

}

echo "
<h3>Inside Pulse Version 10 Non-Dashboard Tools</h3>
<a href='/v10tools.php'>Home</a> | 
<a href='/v10tools.php?action=authors_time_period'>Active Authors</a> | 
<hr>
<h2>$action_nicename</h2>
";

//return the output
echo $output;

?>