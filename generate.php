<?php


// include wordpress crap
//require_once(getenv("DOCUMENT_ROOT")."/wp-load.php");
//$currentpath = $_SERVER['DOCUMENT_ROOT'];

$currentpath = $_SERVER['DOCUMENT_ROOT'];
$thisurl =  $_SERVER['HTTP_HOST'];
if($thisurl=="insidepulse.com"){
	require_once($currentpath.'/wp-load.php');
}
elseif($thisurl=="insidepulse.net"){
	require_once($currentpath.'/wp-load.php');
}
else{
	require_once($currentpath.'/wp-load.php');
}









$currentpath_generatepath = $currentpath . "/generate/";

//general folders
$buildfilename_cat = $currentpath_generatepath . "category/";
$buildfilename_zone = $currentpath_generatepath . "zone/";
$buildfilename_author = $currentpath_generatepath . "author/";


//build sidebar category
$categories =  get_categories('');

foreach ($categories as $category) {

	//grab vars
	$thiscatslug = $category->category_nicename;
	$thiscatname = $category->cat_name;

	if($thiscatslug){
		//related filename
		$buildfilename_cat_ind = $buildfilename_cat . "l-cat-" . $thiscatslug . ".html";

		//narrow filename
		$buildfilename_cat_ind2 = $buildfilename_cat . "r-cat-narrow-" . $thiscatslug . ".html";

		//build array for each
		$values = array();
		$values[] = array('cat', $thiscatslug, $thiscatname, '/category/'.$thiscatslug);

		//related content
		$create_related = createsection($values, "related");
		$relatedoutput = $create_related['header'];
		$relatedoutput .= $create_related['body'];

		//narrow content
		$rightnarrowvalues = createsection($values, "narrowlinks");
		$make_narrow = make_narrow($rightnarrowvalues);

		// fopen file thing etc
		$f = fopen ($buildfilename_cat_ind, 'w');
		fputs ($f, $relatedoutput);
		fclose ($f);

		echo "success - $buildfilename_cat_ind <br>";


		// fopen file thing etc
		$f = fopen ($buildfilename_cat_ind2, 'w');
		fputs ($f, $make_narrow);
		fclose ($f);

		echo "success - $buildfilename_cat_ind2 <br>";
	}
}



$getallauthors = getinsiders('');

foreach($getallauthors as $eachauthorarray){
	$thisdisplay_name = $eachauthorarray['display_name'];
	$thisuser_nicename = $eachauthorarray['user_nicename'];
	$thisuser_ID = $eachauthorarray['ID'];

	$create_singleauthbox = create_authbox($thisuser_ID, "singleauthbox");
	$create_right = create_authbox($thisuser_ID, "rightauthbox");

	$buildfilename_author_indl = $buildfilename_author . "l-author-" . $thisuser_ID . ".html";
	$buildfilename_author_indr = $buildfilename_author . "r-author-" . $thisuser_ID . ".html";






	// fopen file thing etc
	$f = fopen ($buildfilename_author_indl, 'w');
	fputs ($f, $create_singleauthbox);
	fclose ($f);

	echo "success - $buildfilename_author_indl <br>";


	// fopen file thing etc
	$f = fopen ($buildfilename_author_indr, 'w');
	fputs ($f, $create_right);
	fclose ($f);

	echo "success - $buildfilename_author_indr <br>";

}

//generate filters

//copied from elsewhere
$categoriesskiparray = array('digest','age-gate','digest','authordigest', 'categorydigest', 'special', 'live-coverage', 'zonedigest', 'tagdigest');
$thisurl =  $_SERVER['HTTP_HOST'];


$regular_filters = buildfilters("latest", $thisurl, $categoriesskiparray);
$right_filters = buildfilters("latest", $thisurl, $categoriesskiparray, true);

$buildfilename_right_filters = $currentpath_generatepath . "right_filters.html";
$buildfilename_regular_filters = $currentpath_generatepath . "regular_filters.html";

// fopen file thing etc
$f = fopen ($buildfilename_right_filters, 'w');
fputs ($f, $right_filters);
fclose ($f);

echo "success - $buildfilename_right_filters <br>";

// fopen file thing etc
$f = fopen ($buildfilename_regular_filters, 'w');
fputs ($f, $regular_filters);
fclose ($f);

echo "success - $buildfilename_regular_filters <br>";





// if file exists, content is hooray
//$content = "new file of $type for id #$activeid has been created";


?>