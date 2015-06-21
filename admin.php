<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<?php
/*
Template Name: Admin
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

if($_GET['action']){
	$action = $_GET['action'];
}
else{
	$action = 0;
}

if($_GET['page']){
	$currentpage = $_GET['page'];
}
else{
	$currentpage = 1;
}




//action xxxxxxxxxx
if($action=="XXXXXXXXX"){



}


//action partners
elseif($action=="partners"){

	$output = "
	Sports Fan Live<br>
	Type: Ads<br>
	Contact: Eric Herd<br>

	<br>
	";
}


//action stafffaq
elseif($action=="stafffaq"){

	$output = "
	<b>Q: How do I dinkers</b><br>
	<i>great question stinkers!</i>

	<br><br>
	";
}

//action stafflist
elseif($action=="stafflist"){

	$output = "
	dynamic xls copy thing here
	";
}


//action logins
elseif($action=="logins"){

	$output = "
	@insidepulse twitter<br>
	p: pulseword<br>
	<br>
	";
}

















?>


<div style="text-align:left;">

<h1>Widro Admin & Testing</h1>
<a href="/admin?action=partners">partners</a> |
<a href="/admin?action=stafffaq">staff faq</a> |
<a href="/admin?action=stafflist">staff list</a> |
<a href="/admin?action=logins">logins</a> |
<a href="/admin?action=xxxxxxxxxx">XXXXXXXXXXXXXXXXX</a> |
<a href="/admin?action=xxxxxxxxxx">XXXXXXXXXXXXXXXXX</a> |
<a href="/admin?action=xxxxxxxxxx">XXXXXXXXXXXXXXXXX</a> |
<a href="/admin?action=xxxxxxxxxx">XXXXXXXXXXXXXXXXX</a> |
<a href="/admin?action=xxxxxxxxxx">XXXXXXXXXXXXXXXXX</a> |
<a href="/admin?action=xxxxxxxxxx">XXXXXXXXXXXXXXXXX</a> |




<hr>

<?php echo $output; ?>





</div>

