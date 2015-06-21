<?php
add_filter( 'manage_posts_columns', 'govid_columns' ); //Filter out Post Columns with 2 custom columns
add_filter( 'publicize_checkbox_default', '__return_false' );
if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}


function extrastats_count($uid, $sortby){

	if($sortby=="month"){
		$dateformat1 = "%Y %m";
	}
	elseif($sortby=="day"){
		$dateformat1 = "%Y %m %d";
	}
	elseif($sortby=="year"){
		$dateformat1 = "%Y %m %d";
	}



	$sqladmin = "
	SELECT COUNT(*) as total, DATE_FORMAT(post_date,'$dateformat1') as date
	FROM wp_posts
	WHERE post_author = '$uid'
	GROUP BY date
	ORDER by date DESC
	";

	$resultadmin = mysql_query($sqladmin) or die($sqladmin);

	while($rowadmin = mysql_fetch_array($resultadmin)){
		$date = $rowadmin['date'];

		if($total){
			$oldtotal = $total;
		}
		$total = $rowadmin['total'];

		if($sortby=="month"){
			if($oldtotal){
				$percentchange = ($oldtotal-$total)/$oldtotal*100;
				$percentchange = round($percentchange, 2);
				$total2 = " ($percentchange % change)";


			}
		}


		//$content .= "$day - $total<br>";

		$content .= "
		<div class=\"highscores_row\">
		<div class=\"highscores_rank\">*</div>
		<div class=\"highscores_name\">$date</div>
		<div class=\"highscores_score\">$total</div>
		</div>
		";

	}


	return $content;

}



function stats_startdate($user_id){
	$sqladmin = "
	select post_date
	from wp_posts
	where post_author = '$user_id'
	order by post_date ASC
	limit 1
	";

	$resultadmin = mysql_query($sqladmin) or die($sqladmin);

	while($rowadmin = mysql_fetch_array($resultadmin)){
		$date = $rowadmin['post_date'];
	}

	return $date;
}

function stats_total($user_id){
	$sqladmin = "
	select count(*) as total
	from wp_posts
	where post_author = '$user_id'
	and post_status = 'publish'
	";

	$resultadmin = mysql_query($sqladmin) or die($sqladmin);

	while($rowadmin = mysql_fetch_array($resultadmin)){
		$total = $rowadmin['total'];
	}

	return $total;
}






function stats_author($user_id, $admin=false){

	$startdate = stats_startdate($user_id);
	$totalposts = stats_total($user_id);



}









function govid_columns($defaults) {
    //$defaults['language'] = __('Language'); //Language and Films is name of column
    $defaults['zone'] = __('Zones');
    return $defaults;
}

add_action('manage_posts_custom_column', 'govid_custom_column', 10, 2); //Just need a single function to add multiple columns

function govid_custom_column($column_name, $post_id) {
    global $wpdb;
    if( $column_name == 'zone' ) {
		$tags = get_the_terms($post->ID, 'zone'); //lang is the first custom taxonomy slug
		if ( !empty( $tags ) ) {
			$out = array();
			foreach ( $tags as $c )
				$out[] = "<a href='edit.php?zone=$c->slug'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'lang', 'display')) . "</a>";
			echo join( ', ', $out );
		} else {
			_e('No Zones??.');  //No Taxonomy term defined
		}
	}  else {
		echo '<i>'.__('None').'</i>'; //Only 2 columns, blank now.
	}
}





//register sidebars

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div  class="right_container">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="icon2m bold">					',
        'after_title' => '</h3>',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));



function defaultimage($type, $size){

	//make array
	$imageurl = array();

	if($type=="movies"){
		$imageurl['topstory120x120'] = "http://media.insidepulse.com/shared/images/v7/default120x120_.jpg";
		$imageurl['topstory500x250'] = "http://media.insidepulse.com/shared/images/v7/default500x250_.jpg";
	}
	elseif($type=="tv"){
		$imageurl['topstory120x120'] = "http://media.insidepulse.com/shared/images/v7/default120x120_.jpg";
		$imageurl['topstory500x250'] = "http://media.insidepulse.com/shared/images/v7/default500x250_.jpg";
	}
	elseif($type=="wrestling"){
		$imageurl['topstory120x120'] = "http://media.insidepulse.com/shared/images/v7/default120x120_.jpg";
		$imageurl['topstory500x250'] = "http://media.insidepulse.com/shared/images/v7/default500x250_.jpg";
	}
	elseif($type=="comics-nexus"){
		$imageurl['topstory120x120'] = "http://media.insidepulse.com/shared/images/v7/default120x120_.jpg";
		$imageurl['topstory500x250'] = "http://media.insidepulse.com/shared/images/v7/default500x250_comicsnexus.png";
	}
	elseif($type=="insidefights"){
		$imageurl['topstory120x120'] = "http://media.insidepulse.com/shared/images/v7/fightsdefault120.jpg";
		$imageurl['topstory500x250'] = "http://media.insidepulse.com/shared/images/v7/fightsdefault500.jpg";
	}
	else{
		$imageurl['topstory120x120'] = "http://media.insidepulse.com/shared/images/v7/default120x120_.jpg";
		$imageurl['topstory500x250'] = "http://media.insidepulse.com/shared/images/v7/default500x250_.jpg";
	}

	return $imageurl[$size];

}




function buildfilters($page, $activeid, $categoriesskiparray, $sidebar=false){


	if($sidebar){
		$authordd .= "Author: ";
	}

	$authordd .= "<select id=\"authorid\" name=\"authorid\">";
	$authordd .= "<option value=\"\">-- insider --</option>";
	$getallauthors = getinsiders('');

	foreach($getallauthors as $eachauthorarray){
		$thisuserid = $eachauthorarray['ID'];
		$thisdisplay_name = $eachauthorarray['display_name'];
		$authordd .= "
			<option value=$thisuserid>$thisdisplay_name</option>
		";
	}


	$authordd .= "</select>";

	if($sidebar){
		$authordd .= "<br><br>";
	}

	if($sidebar){
		$zonedd .= "Zone: ";
	}

	$zonedd .= "<select id=\"zone\" name=\"zone\">";
	$zonedd .= "<option value=\"\">-- zone --</option>";
	$getallzones = getzones('');

	foreach($getallzones as $eachzonearray){
		$thiszonename = $eachzonearray['name'];
		$thiszoneslug = $eachzonearray['slug'];
		$zonedd .= "
			<option value=$thiszoneslug>$thiszonename</option>
		";
	}


	$zonedd .= "</select>";

	if($sidebar){
		$zonedd .= "<br><br>";
	}

	if($sidebar){
		$sectiondd .= "Category:";
	}

	$sectiondd .= "<select id=\"cat\" name=\"cat\">";
	$sectiondd .= "<option value=\"\">-- section --</option>";
	$categories =  get_categories('');
	foreach ($categories as $category) {
			$thiscategory_nicename = $category->category_nicename;
			$thiscat_name = $category->cat_name;
			$thiscategory_count = $category->category_count;

			if (!in_array($thiscategory_nicename, $categoriesskiparray)) {
				$sectiondd .= "
					<option value=$thiscategory_nicename>$thiscat_name</option>
				";
			}
	}



	$sectiondd .= "</select>";

	if($sidebar){
		$sectiondd .= "<br><br>";
	}

	if($sidebar){
		//$output .= "Sort Articles!<br><br>";
	}
	else{
		$output .= "Filter:";

	}

	$output .= $authordd;
	$output .= $zonedd;
	$output .= $sectiondd;


	$output .= "<input type=\"submit\" value=\"Filter Articles\">";

	return $output;

}





function makesql($type, $slug){
	if($type=="zone"){
		$sqladd = "&zone=$slug";
	}
	elseif($type=="cat"){
		$sqladd = "&category_name=$slug";
	}
	elseif($type=="tag"){
		$sqladd = "&tag=$slug";
	}
	elseif($type=="author"){
		$sqladd = "&author=$slug";
	}
	elseif($type=="zonecat"){
		$slugarray = explode("|", $slug);
		$sqladd = "&zone=".  $slugarray[0] . "&category_name=" . $slugarray[1];
	}
	elseif($type=="zonetag"){
		$slugarray = explode("|", $slug);
		$sqladd = "&zone=".  $slugarray[0] . "&tag=" . $slugarray[1];
	}
	elseif($type=="zoneauthor"){
		$slugarray = explode("|", $slug);
		$sqladd = "&zone=".  $slugarray[0] . "&author=" . $slugarray[1];
	}

	return $sqladd;
}









function listingcell($thistitle, $thisdate, $author, $clickthru, $thisexcerpt, $topstory120x120, $topstory500x250, $grey = false){

	if($grey){
		$cssadd = "style=\"background:#eeeeee;\"";
	}

	if(!strstr($topstory120x120, "<img")){
		$topstory120x120 = "<img src='$topstory120x120'>";
	}

	if(!strstr($topstory500x250, "<img")){
		$topstory500x250 = "<img src='$topstory500x250'>";
	}

	$listing = "

	<div class=\"listing_cell\" $cssadd>
		<div class=\"listing_cell_left\">

			<a href=\"$clickthru\">$topstory120x120</a>

		</div>
		<div class=\"listing_cell_right\">
			<a class=\"color1\" href=\"$clickthru\">$thistitle</a>
			<p class=\"listing_cell_byline\">By $author <span class=\"date\">($thisdate)</span></p>
			<p>$thisexcerpt <a class=\"bold color1 author_cell_readmore\" href=\"$clickthru\">&raquo;&raquo;</a></p>
		</div>
	<div class=\"clear\"></div>
	</div>
	<div class=\"clear\"></div>
	";

	return $listing;
}




function in_zone( $zonetocheck, $_post = null ) {
	if ( empty( $zonetocheck ) )
		return false;

	if ( $_post ) {
		$_post = get_post( $_post );
	} else {
		$_post =& $GLOBALS['post'];
	}

	if ( !$_post )
		return false;

	$r = is_object_in_term( $_post->ID, 'zone', $zonetocheck );
	if ( is_wp_error( $r ) )
		return false;
	return $r;
}



// Custom Taxonomy Code
add_action( 'init', 'build_taxonomies', 0 );
function build_taxonomies() {
	$labels1 = array(
		'name' => _x( 'Zones', 'taxonomy general name' ),
		'singular_name' => _x( 'Zone', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Zones' ),
		'all_items' => __( 'All Zones' ),
		'parent_item' => __( 'Parent Zone' ),
		'parent_item_colon' => __( 'Parent Zone:' ),
		'edit_item' => __( 'Edit Zone' ),
		'update_item' => __( 'Update Zone' ),
		'add_new_item' => __( 'Add New Zone' ),
		'new_item_name' => __( 'New Zone Name' ),
	);

	register_taxonomy(
		'zone',
		'post',
		array(
			'hierarchical' => true,
			'labels' => $labels1,
			'public' => TRUE,
			'show_ui' => TRUE,
			'query_var' => 'zone',
			'rewrite' => true
		)
	);
}






































































function getusermetawidro($userid){

	$sqltemp = "
	SELECT meta_key, meta_value
	FROM wp_usermeta
	WHERE user_id = '$userid'
	";

	$resulttemp = mysql_query($sqltemp);
	$totalrows = mysql_num_rows($resulttemp);


	$thumbnailurl = $rowtemp['meta_value'];

	while($rowtemp = mysql_fetch_array($resulttemp)){
		$meta_key = $rowtemp['meta_key'];
		$content[$meta_key] = $rowtemp['meta_value'];
	}

	return $content;

}

function getpostmetawidro($post_id){

	$sqltemp = "
	SELECT meta_key, meta_value
	FROM wp_postmeta
	WHERE post_id = '$post_id'
	";

	$resulttemp = mysql_query($sqltemp);
	$totalrows = mysql_num_rows($resulttemp);


	$thumbnailurl = $rowtemp['meta_value'];

	while($rowtemp = mysql_fetch_array($resulttemp)){
		$meta_key = $rowtemp['meta_key'];
		$content[$meta_key] = $rowtemp['meta_value'];
	}

	return $content;

}
function getzones($zoneslug){

	$outputarray = array();

	//if no zone, then give full array
	if($zoneslug==""){
		$sqladd = "";
	}
	else{
		$sqladd = "where slug = '$zoneslug'";

	}

	$sqlzones = "
	select *
	from wp_zones
	$sqladd
	";

	$resultzones = mysql_query($sqlzones);

	while($rowzones = mysql_fetch_array($resultzones)){
		$thisslug = $rowzones['slug'];
		$outputarray[$thisslug]['name'] = $rowzones['name'];
		$outputarray[$thisslug]['slug'] = $rowzones['slug'];
		$outputarray[$thisslug]['term_id'] = $rowzones['term_id'];
		$outputarray[$thisslug]['term_taxonomy_id'] = $rowzones['term_taxonomy_id'];
		$outputarray[$thisslug]['oldurl'] = $rowzones['oldurl'];
		$outputarray[$thisslug]['homepage'] = $rowzones['homepage'];
		$outputarray[$thisslug]['facebook'] = $rowzones['facebook'];
		$outputarray[$thisslug]['twitter'] = $rowzones['twitter'];
		$outputarray[$thisslug]['feedburner'] = $rowzones['feedburner'];
		$outputarray[$thisslug]['type'] = $rowzones['type'];
		$outputarray[$thisslug]['insiders'] = $rowzones['insiders'];
		$outputarray[$thisslug]['categories'] = $rowzones['categories'];
	}

	return $outputarray;

}

















































function makeexcerpt($content, $excerpt, $type){
	$yo = 1;
	if(!$excerpt){
		$yo = 2;

		$content_exploded = explode("<!--more-->", $content);
		$excerpt = $content_exploded[0];

		if(!$content_exploded[1]){
			$yo = 3;
			$excerpt = substr(strip_tags($content), 0, 250);
		}
	}

	return $excerpt;

}






/**
 * Content of Dashboard-Widget
 */
function my_wp_dashboard_test() {
	echo '

	<a href=https://mail.google.com/a/insidepulse.com>https://mail.google.com/a/insidepulse.com</a>
	<br><br>
	Check your IP email! <a href=https://mail.google.com/a/insidepulse.com>https://mail.google.com/a/insidepulse.com</a>
	<br><br>
	IP Images (120s and 500s:<br>
	<a href=/images/>Images Viewer</a>
	<br><br>
	Free Conference Call<br>
	Conference Dial-in Number: (712) 775-7100<br>
	Host Access Code: 1000412*<br>
	Participant Access Code: 1000412#<br><br>


	';
}

function my_wp_dashboard_test2() {
	$getallzones = getzones('');

	foreach($getallzones as $eachzonearray){
		$thiszonename = $eachzonearray['name'];
		$thiszoneslug = $eachzonearray['slug'];
		$thiszonetermid = $eachzonearray['term_id'];

		$thiszonefacebook = $eachzonearray['facebook'];
		$thiszonetwitter = $eachzonearray['twitter'];

		//zone post listing
		$zonedashdd .= '<option value="/wp-admin/edit.php?zone='.$thiszoneslug.'&post_type=post">'.$thiszonename.'</option>';

		// zone twitters
		$zonetwittersdashdd .= '<option value="'.$thiszonetwitter.'&post_type=post">'.$thiszonename.'</option>';

		// zone facebooks
		$zonefacebooksdashdd .= '<option value="'.$thiszonefacebook.'&post_type=post">'.$thiszonename.'</option>';
	}

	echo 'Use this dropdown to sort the posts screen by zone!<br><br>';
	echo '<select onchange="javascript:window.location=this.value">';
	echo '<option value="">-- choose one --</option>';
	echo $zonedashdd;
	echo '</select><br><br>';

	echo 'Zone Twitters: ';
	echo '<select onchange="javascript:window.location=this.value">';
	echo '<option value="">-- choose one --</option>';
	echo $zonetwittersdashdd;
	echo '</select><br><br>';

	echo 'Zone Facebooks: ';
	echo '<select onchange="javascript:window.location=this.value">';
	echo '<option value="">-- choose one --</option>';
	echo $zonefacebooksdashdd;
	echo '</select><br><br>';

}

function my_wp_dashboard_test3() {
	echo '

	Check out these groups on Facebook:
	<ul>
		<li><a href="http://www.facebook.com/groups/185430111515400/" target=_blank>Inside Pulse Staff</a></li>
		<li><a href="http://www.facebook.com/groups/246316252064223/" target=_blank>Pulse Wrestling Staff</a></li>
		<li><a href="http://www.facebook.com/groups/195551063835699/" target=_blank>Inside Fights Staff</a></li>
		<li><a href="http://www.facebook.com/groups/219403814767726/" target=_blank>Comics Nexus Staff</a></li>

	</ul>


	';
}

function my_wp_dashboard_test4() {
	echo '

	Adding images to posts makes a huge difference! Here are some of our great image resources:


	';
}

function my_wp_dashboard_test5() {
	echo '

	Customize your Inside Pulse Profile page!
	<br><br>
	Check out the IP Staff FAQ
	<br><br>
	Generate Links (article related, article author box, sidebar author)
	<br><br>
	<li><a href="http://insidepulse.com/wp-content/themes/version7/generate.php" target=_blank>Inside Pulse</a></li>
	<li><a href="http://wrestling.insidepulse.com/wp-content/themes/version7/generate.php" target=_blank>Pulse Wrestling</a></li>
	<li><a href="http://insidefights.com/wp-content/themes/version7/generate.php" target=_blank>Inside Fights</a></li>
	<li><a href="http://diehardgamefan.com/wp-content/themes/version7/generate.php" target=_blank>Comics Nexus</a></li>


	';
}

function my_wp_dashboard_test6() {
	echo '

	partners


	';
}

/**
 * add Dashboard Widget via function wp_add_dashboard_widget()
 */
function my_wp_dashboard_setup() {
	wp_add_dashboard_widget( 'my_wp_dashboard_test', __( 'Staff Tools' ), 'my_wp_dashboard_test' );
	wp_add_dashboard_widget( 'my_wp_dashboard_test2', __( 'Posts by Zone' ), 'my_wp_dashboard_test2' );
	wp_add_dashboard_widget( 'my_wp_dashboard_test3', __( 'Facebook Staff Groups' ), 'my_wp_dashboard_test3' );
	wp_add_dashboard_widget( 'my_wp_dashboard_test4', __( 'Image Resources' ), 'my_wp_dashboard_test4' );
	wp_add_dashboard_widget( 'my_wp_dashboard_test5', __( 'Staff Resources' ), 'my_wp_dashboard_test5' );
	wp_add_dashboard_widget( 'my_wp_dashboard_test6', __( 'Partners/Links' ), 'my_wp_dashboard_test6' );
}

/**
 * use hook, to integrate new widget
 */
add_action('wp_dashboard_setup', 'my_wp_dashboard_setup');


// Create the function to use in the action hook

function example_remove_dashboard_widgets() {
	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes;

	// Remove the quickpress widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);

	// Remove the plugins widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);

	// Remove the powerpress_dashboard_news widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['powerpress_dashboard_news']);

	// Remove the recent drafts widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);

	// Remove the right now widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);

	// Remove the recent comments widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);

	// Remove the incoming links widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);

	// Remove the dashboard_primary (staff forum) widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);

	// Remove the dashboard_secondary (wp news) links widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

	// Remove the dashboard_secondary (wp news) links widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_stats']);
}

// Hoook into the 'wp_dashboard_setup' action to register our function
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );





if ( !class_exists('myCustomFields') ) {

    class myCustomFields {
        /**
        * @var  string  $prefix  The prefix for storing custom fields in the postmeta table
        */
        var $prefix = '';
        /**
        * @var  array  $customFields  Defines the custom fields available
        */
        var $customFields = array(
            array(
                "name"          => "topstory120x120",
                "title"         => "Thumbnail (topstory120x120)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "topstory500x250",
                "title"         => "Top Story Image (topstory500x250)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "creditlink",
                "title"         => "Credit Link (creditlink)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "credittext",
                "title"         => "Credit Text (credittext)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "amazon_link",
                "title"         => "amazon Link (amazon_link)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "review_poster",
                "title"         => "review_poster (review_poster)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "review_youtube",
                "title"         => "review_youtube (review_youtube)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "star_rating",
                "title"         => "star/overall rating (star_rating)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "content_rating",
                "title"         => "content rating (content_rating)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "extras_rating",
                "title"         => "extras rating (extras_rating)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "replay_rating",
                "title"         => "replay rating (replay_rating)",
                "description"   => "",
                "type"          =>   "text",
                "scope"         =>   array( "post", "page" ),
                "capability"    => "edit_posts"
            )
        );
        /**
        * PHP 4 Compatible Constructor
        */
        function myCustomFields() { $this->__construct(); }
        /**
        * PHP 5 Constructor
        */
        function __construct() {
            add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
            add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
            // Comment this line out if you want to keep default custom fields meta box
            add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
        }
        /**
        * Remove the default Custom Fields meta box
        */
        function removeDefaultCustomFields( $type, $context, $post ) {
            foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
                remove_meta_box( 'postcustom', 'post', $context );
                remove_meta_box( 'postcustom', 'page', $context );
                //Use the line below instead of the line above for WP versions older than 2.9.1
                //remove_meta_box( 'pagecustomdiv', 'page', $context );
            }
        }
        /**
        * Create the new Custom Fields meta box
        */
        function createCustomFields() {
            if ( function_exists( 'add_meta_box' ) ) {
                add_meta_box( 'my-custom-fields', 'Custom Fields', array( &$this, 'displayCustomFields' ), 'page', 'normal', 'high' );
                add_meta_box( 'my-custom-fields', 'Custom Fields', array( &$this, 'displayCustomFields' ), 'post', 'normal', 'high' );
            }
        }
        /**
        * Display the new Custom Fields meta box
        */
        function displayCustomFields() {
            global $post;
            ?>
            <div class="form-wrap">
                <?php
                wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
                foreach ( $this->customFields as $customField ) {
                    // Check scope
                    $scope = $customField[ 'scope' ];
                    $output = false;
                    foreach ( $scope as $scopeItem ) {
                        switch ( $scopeItem ) {
                            case "post": {
                                // Output on any post screen
                                if ( basename( $_SERVER['SCRIPT_FILENAME'] )=="post-new.php" || $post->post_type=="post" )
                                    $output = true;
                                break;
                            }
                            case "page": {
                                // Output on any page screen
                                if ( basename( $_SERVER['SCRIPT_FILENAME'] )=="page-new.php" || $post->post_type=="page" )
                                    $output = true;
                                break;
                            }
                        }
                        if ( $output ) break;
                    }
                    // Check capability
                    if ( !current_user_can( $customField['capability'], $post->ID ) )
                        $output = false;
                    // Output if allowed
                    if ( $output ) { ?>
                        <div class="form-field form-required">
                            <?php
                            switch ( $customField[ 'type' ] ) {
                                case "checkbox": {
                                    // Checkbox
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>&nbsp;&nbsp;';
                                    echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
                                    if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
                                        echo ' checked="checked"';
                                    echo '" style="width: auto;" />';
                                    break;
                                }
                                case "textarea": {
                                    // Text area
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
                                    echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
                                    break;
                                }
                                default: {
                                    // Plain text field
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
                                    echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
                                    break;
                                }
                            }
                            ?>
                            <?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
                        </div>
                    <?php
                    }
                } ?>
            </div>
            <?php
        }
        /**
        * Save the new Custom Fields values
        */
        function saveCustomFields( $post_id, $post ) {
            if ( !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
                return;
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
            if ( $post->post_type != 'page' && $post->post_type != 'post' )
                return;
            foreach ( $this->customFields as $customField ) {
                if ( current_user_can( $customField['capability'], $post_id ) ) {
                    if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
                        update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $_POST[ $this->prefix . $customField['name'] ] );
                    } else {
                        delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
                    }
                }
            }
        }

    } // End Class

} // End if class exists statement

// Instantiate the class
if ( class_exists('myCustomFields') ) {
    $myCustomFields_var = new myCustomFields();
}







//add meta to user profile page

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>
	<h3>Extra profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="authortitle">Author Title</label></th>

			<td>
				<input type="text" name="authortitle" id="authortitle" value="<?php echo esc_attr( get_the_author_meta( 'authortitle', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your title.</span>
			</td>
		</tr>

		<tr>
			<th><label for="twitter">Twitter</label></th>

			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your Twitter username.</span>
			</td>
		</tr>

		<tr>
			<th><label for="twitterrss">Twitter RSS</label></th>

			<td>
				<input type="text" name="twitterrss" id="twitterrss" value="<?php echo esc_attr( get_the_author_meta( 'twitterrss', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your Twitter RSS URL (on your twitter profile, right side).</span>
			</td>
		</tr>

		<tr>
			<th><label for="facebook">Facebook</label></th>

			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your Facebook url.</span>
			</td>
		</tr>

		<tr>
			<th><label for="youtube">You Tube</label></th>

			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your You Tube url.</span>
			</td>
		</tr>

		<tr>
			<th><label for="rss1">RSS 1</label></th>

			<td>
				<input type="text" name="rss1" id="rss1" value="<?php echo esc_attr( get_the_author_meta( 'rss1', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your rss1 url.</span>
			</td>
		</tr>

		<tr>
			<th><label for="rss2">RSS 2</label></th>

			<td>
				<input type="text" name="rss2" id="rss2" value="<?php echo esc_attr( get_the_author_meta( 'rss2', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your rss2 url.</span>
			</td>
		</tr>

		<tr>
			<th><label for="rss3">RSS 3</label></th>

			<td>
				<input type="text" name="rss3" id="rss3" value="<?php echo esc_attr( get_the_author_meta( 'rss3', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your rss3 url.</span>
			</td>
		</tr>

		<tr>
			<th><label for="avatar120">Avatar 120 URL</label></th>

			<td>
				<input type="text" name="avatar120" id="avatar120" value="<?php echo esc_attr( get_the_author_meta( 'avatar120', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your avatar 120 url.</span>
			</td>
		</tr>

		<tr>
			<th><label for="avatar500">Avatar 500 URL</label></th>

			<td>
				<input type="text" name="avatar500" id="avatar500" value="<?php echo esc_attr( get_the_author_meta( 'avatar500', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your avatar 500 url.</span>
			</td>
		</tr>

		<tr>
			<th><label for="avatar500">Cover Image URL (650x325)</label></th>

			<td>
				<input type="text" name="coverimage" id="coverimage" value="<?php echo esc_attr( get_the_author_meta( 'coverimage', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your Cover Image URL.</span>
			</td>
		</tr>

		<tr>
			<th><label for="ipemail">IP Email</label></th>

			<td>
				<input type="text" name="ipemail" id="ipemail" value="<?php echo esc_attr( get_the_author_meta( 'ipemail', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your IP email username.</span>
			</td>
		</tr>

		<tr>
			<th><label for="ipforum">IP Forum</label></th>

			<td>
				<input type="text" name="ipforum" id="ipforum" value="<?php echo esc_attr( get_the_author_meta( 'ipforum', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your IP Forum Name.</span>
			</td>
		</tr>

		<tr>
			<th><label for="quote">quote</label></th>

			<td>
				<input type="text" name="quote" id="quote" value="<?php echo esc_attr( get_the_author_meta( 'quote', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your quote.</span>
			</td>
		</tr>

		<tr>
			<th><label for="row1">row1</label></th>

			<td>
				<input type="text" name="row1" id="row1" value="<?php echo esc_attr( get_the_author_meta( 'row1', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your row1.</span>
			</td>
		</tr>

		<tr>
			<th><label for="row2">row2</label></th>

			<td>
				<input type="text" name="row2" id="row2" value="<?php echo esc_attr( get_the_author_meta( 'row2', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your row2.</span>
			</td>
		</tr>

		<tr>
			<th><label for="row3">row3</label></th>

			<td>
				<input type="text" name="row3" id="row3" value="<?php echo esc_attr( get_the_author_meta( 'row3', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your row3.</span>
			</td>
		</tr>

		<tr>
			<th><label for="row4">row4</label></th>

			<td>
				<input type="text" name="row4" id="row4" value="<?php echo esc_attr( get_the_author_meta( 'row4', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your row4.</span>
			</td>
		</tr>

		<tr>
			<th><label for="row5">row5</label></th>

			<td>
				<input type="text" name="row5" id="row5" value="<?php echo esc_attr( get_the_author_meta( 'row5', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your row5.</span>
			</td>
		</tr>

		<tr>
			<th><label for="zonesuser">zonesuser</label></th>

			<td>
				<input type="text" name="zonesuser" id="zonesuser" value="<?php echo esc_attr( get_the_author_meta( 'zonesuser', $user->ID ) ); ?>" class="regular-text" />
				<span class="description">Please enter your zonesuser.</span>
			</td>
		</tr>

	</table>
<?php }


add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
	update_usermeta( $user_id, 'twitterrss', $_POST['twitterrss'] );
	update_usermeta( $user_id, 'facebook', $_POST['facebook'] );
	update_usermeta( $user_id, 'youtube', $_POST['youtube'] );
	update_usermeta( $user_id, 'rss1', $_POST['rss1'] );
	update_usermeta( $user_id, 'rss2', $_POST['rss2'] );
	update_usermeta( $user_id, 'rss3', $_POST['rss3'] );
	update_usermeta( $user_id, 'avatar120', $_POST['avatar120'] );
	update_usermeta( $user_id, 'avatar500', $_POST['avatar500'] );
	update_usermeta( $user_id, 'coverimage', $_POST['coverimage'] );
	update_usermeta( $user_id, 'ipemail', $_POST['ipemail'] );
	update_usermeta( $user_id, 'ipforum', $_POST['ipforum'] );
	update_usermeta( $user_id, 'quote', $_POST['quote'] );
	update_usermeta( $user_id, 'row1', $_POST['row1'] );
	update_usermeta( $user_id, 'row2', $_POST['row2'] );
	update_usermeta( $user_id, 'row3', $_POST['row3'] );
	update_usermeta( $user_id, 'row4', $_POST['row4'] );
	update_usermeta( $user_id, 'row5', $_POST['row5'] );
	update_usermeta( $user_id, 'authortitle', $_POST['authortitle'] );
	update_usermeta( $user_id, 'zonesuser', $_POST['zonesuser'] );
}





function IPiframe_add_options_page() {
	add_options_page("Images 120/500", "Images 120/500", "manage_media", __FILE__, "IPiframe_options_page");
	//add_options_page("Staff XLS", "Staff XLS", "admin_users", __FILE__, "IPiframe_options_page_staffxls");
	//add_options_page("Staff XLS", "Staff XLS", "manage_media", __FILE__, "IPiframe_options_page_staffxls");

	//top level section
	//add_menu_page('Page title', 'Inside Pulse', 'manage_options', 'inside-pulse-iframes', 'IPiframe_options_page');

	//under other sections
	add_submenu_page( 'upload.php', 'Images 120/500', 'Images 120/500', 'upload_files', 'iframes?frame=images', 'IPiframe_options_page');
	add_submenu_page( 'users.php', 'Staff XLS', 'Staff XLS', 'upload_files', 'iframes?frame=staffxls', 'IPiframe_options_page_staffxls');
	add_submenu_page( 'options-general.php', 'Widro Admin', 'Widro Admin', 'upload_files', 'iframes?frame=admin', 'IPiframe_admin_page');
	add_submenu_page( 'index.php', 'IP Email', 'IP Email', 'upload_files', 'iframes?frame=email', 'IPiframe_email_page');
	add_submenu_page( 'index.php', 'Staff Forum', 'Staff Forum', 'upload_files', 'iframes?frame=staffforum', 'IPiframe_staffforum_page');

}

function IPiframe_options_page() {

echo "
<div class=\"wrap\">
	<div id=\"icon-index\" class=\"icon32\"></div>
	<h2>Inside Pulse 120x120 and 500x250 images
		<a href=http://insidepulse.com/images target=images_iframe>ALL</a> |
		<a href=http://diehardgamefan.com/images target=images_iframe>DHGF</a>
	</h2>
	<iframe name=images_iframe src=http://insidepulse.com/images width=1000 height=1500 frameborder=0 scrolling=no></iframe>
</div>
";

}

function IPiframe_options_page_staffxls() {

echo "
<div class=\"wrap\">
	<div id=\"icon-index\" class=\"icon32\"></div>
<h2>Inside Pulse staffxls

<a href=http://insidepulse.com/staffxls target=images_iframe>ALL</a> |

<a href=http://insidefights.com/staffxls target=images_iframe>I-F</a> |
<a href=http://wrestling.insidepulse.com/staffxls target=images_iframe>WRES</a> |
<a href=http://diehardgamefan.com/staffxls target=images_iframe>DHGF</a>

</h2>

<iframe name=images_iframe src=http://insidepulse.com/staffxls width=1000 height=1500 frameborder=0 scrolling=no></iframe>


</div>
";

}

function IPiframe_admin_page() {

echo "
<div class=\"wrap\">
	<div id=\"icon-index\" class=\"icon32\"></div>
<h2>Admin</h2>

<iframe name=images_iframe src=http://insidepulse.com/admin width=1000 height=1500 frameborder=0 scrolling=no></iframe>


</div>
";

}

function IPiframe_email_page() {

echo "
<div class=\"wrap\">
	<div id=\"icon-index\" class=\"icon32\"></div>
<h2>Inside Pulse Email</h2>

<iframe name=email_iframe src=http://mail.google.com/a/insidepulse.com/#inbox width=1000 height=700 frameborder=0 scrolling=no></iframe>


</div>
";

}



function IPiframe_staffforum_page() {

echo "
<div class=\"wrap\">
	<div id=\"icon-index\" class=\"icon32\"></div>
<h2>Staff Forum</h2>

<iframe name=staff_iframe src=http://forum.insidepulse.com/ubbthreads/ubbthreads.php?ubb=cfrm&c=10 width=1000 height=700 frameborder=0></iframe>


</div>
";

}


add_action('admin_menu', 'IPiframe_add_options_page');





function getrsslinks($rssurl, $overalltitle, $limit, $view){

	global $default120url;
	global $default500url;

	if(!$view){
		$view="subtop";
	}

	if(!$limit){
		$limit="5";
	}

	if($view=="array"){
		$output = array();
		$arraycounter=0;
	}
	$rss = fetch_feed($rssurl);

	//print_r($rss);
	//$overalltitle =  $rss->get_title();
	//$overalllink =  $rss->get_link();
	$topstorycheck = true;
	$subtopoutput = "";
	$rowcounter=0;
	$topstory500x250 = "";
	$topstory120x120 = "";
	foreach ( $rss->get_items(0, $items) as $item ) {
		if($rowcounter<$limit){
			$href = $item->get_link();
			$title = esc_attr(strip_tags($item->get_title()));
			$teaser = $item->get_description();
			$date = $item->get_date();

			$desc = str_replace( array("\n", "\r"), ' ', esc_attr( strip_tags( @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option('blog_charset') ) ) ) );

			$contentitem = $item->get_content();
			//echo $contentitem;
			// go thru and get 120 and 500
			$descriptiona = explode("topstory120x120-", $contentitem);
			if($descriptiona[1]){
				$reexplode = $descriptiona[1];
				$descriptionb = explode("|topstory120x120", $reexplode);
				if(strlen($descriptionb[1])>3){
					$topstory120x120 = str_replace("&#215;", "x", $descriptionb[0]);
				}
				else{
					$topstory120x120 = $default120url;
				}
			}

			$descriptiona2 = explode("topstory500x250-", $contentitem);

			if($descriptiona2[1]){
				$reexplode2 = $descriptiona2[1];
				$descriptionb2 = explode("|topstory500x250", $reexplode2);
				if(strlen($descriptionb2[1])>3){
					$topstory500x250 = str_replace("&#215;", "x", $descriptionb2[0]);
				}
				else{
					$topstory500x250 = $default500url;
				}
			}




				if($topstory500x250==""){
					$topstory500x250 = defaultimage("rss", "topstory500x250");
				}

				if($topstory120x120==""){
					$topstory120x120 = defaultimage("rss", "topstory120x120");
				}



				$rowcounter_minus = $rowcounter-1;
				$output[$rowcounter_minus]['clickthru'] = $href;
				$output[$rowcounter_minus]['title'] = $title;
				$output[$rowcounter_minus]['content'] = $desc;
				$output[$rowcounter_minus]['excerpt'] = $teaser;
				$output[$rowcounter_minus]['post_date'] = $date;
				$output[$rowcounter_minus]['topstory120x120'] = $topstory120x120;
				$output[$rowcounter_minus]['topstory500x250'] = $topstory500x250;

			$rowcounter++;
		}
	}



	return $output;
}




function agegateform(){

	for($i=2010;$i>1900;$i--){
		$yeardd .= "
				<option value=$i>$i</option>
		";
	}

	for($i=1;$i<12;$i++){
		$monthdd .= "
				<option value=$i>$i</option>
		";
	}

	for($i=1;$i<31;$i++){
		$daydd .= "
				<option value=$i>$i</option>
		";
	}

	$output .= "Month: <select name=ageform_month id=ageform_month>";
	$output .= "<option value=''>-- month -- </option>";
	$output .= $monthdd;
	$output .= "</select>";

	$output .= "Day: <select name=ageform_day id=ageform_day>";
	$output .= "<option value=''>-- day -- </option>";
	$output .= $daydd;
	$output .= "</select>";


	$output .= "Year: <select name=ageform_year id=ageform_year>";
	$output .= "<option value=''>-- year -- </option>";
	$output .= $yeardd;
	$output .= "</select>";

	$output .= "<input type=button onclick=\"age_check(); return false;\" value=\"enter birthday\" id=ageform_button name=ageform_button>";

	return $output;

}





function getinsiders($type){

	$outputarray = array();

	$sqlauthors = "
	SELECT DISTINCT wu.*
	FROM wp_usermeta wum, wp_users wu
	WHERE wum.meta_key = 'wp_capabilities'
	AND wu.ID = wum.user_id
	AND wum.meta_value NOT LIKE '%subscriber%'
	AND wum.meta_value NOT LIKE '%inactive%'
	ORDER by wu.display_name
	";

	$resultauthors = mysql_query($sqlauthors);

	while($rowauthors = mysql_fetch_array($resultauthors)){
		$thisuserid = $rowauthors['ID'];
		$allusermeta = getusermetawidro($thisuserid);

		$outputarray[$thisuserid]['ID'] = $rowauthors['ID'];
		$outputarray[$thisuserid]['user_login'] = $rowauthors['user_login'];
		$outputarray[$thisuserid]['user_nicename'] = $rowauthors['user_nicename'];
		$outputarray[$thisuserid]['user_email'] = $rowauthors['user_email'];
		$outputarray[$thisuserid]['display_name'] = $rowauthors['display_name'];
		$outputarray[$thisuserid]['user_status'] = $rowauthors['user_status'];
		$outputarray[$thisuserid]['avatar120'] = $allusermeta['avatar120'];
		$outputarray[$thisuserid]['avatar500'] = $allusermeta['avatar500'];
		$outputarray[$thisuserid]['rss1'] = $allusermeta['rss1'];
		$outputarray[$thisuserid]['rss2'] = $allusermeta['rss2'];
		$outputarray[$thisuserid]['rss3'] = $allusermeta['rss3'];
		$outputarray[$thisuserid]['description'] = $allusermeta['description'];
		$outputarray[$thisuserid]['facebook'] = $allusermeta['facebook'];
		$outputarray[$thisuserid]['twitter'] = $allusermeta['twitter'];
		$outputarray[$thisuserid]['quote'] = $allusermeta['quote'];
		$outputarray[$thisuserid]['row1'] = $allusermeta['row1'];
		$outputarray[$thisuserid]['row2'] = $allusermeta['row2'];
		$outputarray[$thisuserid]['row3'] = $allusermeta['row3'];

	}

	return $outputarray;

}




function createsection($values, $area){

	global $authorslug;

	if($area=="featuredhome"){
		$limit = 4;
	}
	elseif($area=="rightsidetabs"){
		$limit = 5;
	}
	elseif($area=="related"){
		$limit = 4;
	}
	elseif($area=="narrowlinks"){
		$limit = 3;
	}
	elseif($area=="featuredauthor"){
		$limit = 2;
	}
	elseif($area=="authbox"){
		$limit = 9;
	}

	$count = count($values);

	if($area=="related"){
		$count = 1;
	}
	$output_header = "";
	for($i=0;$i<$count;$i++){
		//grab zone
		$type = $values[$i][0];
		$slug = $values[$i][1];
		$name = $values[$i][2];
		$masterclickthru = $values[$i][3];

		$position = $i+1;

		//featured vars
		$showcheck = false;
		$featuredcells = "";

		// top story sql
		$sqladd = makesql($type, $slug);
		$pageposts = get_posts('&showposts='. $limit .$sqladd.'&orderby=post_date&order=desc');

		$zonecounter=0;


		//rightsidetabs
		if($area=="featuredhome"){
			//check for which cols to hide
			if($position>1){
				$classadd = " class=\"hide\"";
			}
			else{
				$classadd = "color1";
			}

			//tab divs
			$output_header .= "<div id=\"featured_$position\" class=\"tab featured_tab$position cp $classadd\">$name</div>";

			//new div
			$output_body .= "<div id=\"featured_content$position\" $classadd>";
		}
		elseif($area=="rightsidetabs"){
			//check for which cols to hide
			if($position>1){
				$classadd = " class=\"hide\"";
			}
			else{
				$classadd = "color1";
			}

			//tab divs
			$output_header .= "<div id=\"sidetabs_$position\" class=\"tab sidetabs_tab$position cp $classadd\">$name</div>";

			//new div
			$output_body .= "<div id=\"sidetabs_content$position\" $classadd>";
		}
		elseif($area=="related"){
			//check for which cols to hide
			if($position>1){
				$classadd = " class=\"hide\"";
			}
			else{
				$classadd = "tab_on";
			}

			//tab divs
			$output_header .= "
				<div class=\"article_box_header\">
					<div class=\"article_box_header_left\">
						<h3 class=\"icon1 font2\">Related $name Articles</h3>
					</div>
					<div class=\"article_box_header_right\">
						<a href=\"$masterclickthru\" class=\"color1\">more articles &raquo;</a>
					</div>
				</div>
				<div class=\"clear\"></div>
			";

			//new div
			$output_body .= "<div class=\"article_box_body\">";

		}
		elseif($area=="narrowlinks"){
			$output_header .= "<a href=\"$masterclickthru\" class=\"color1\">more $name &raquo;</a>";

		}
		elseif($area=="featuredauthor"){
			$output_header .= "
				<a href=\"#\" alt=\"$name's Profile\" title=\"$name's Profile\"><img src=\"$masterclickthru\" class=\"right_greybox_avatar120\"></a>
			";
			$output_body .= "
				<h3 class=\"font2 color2 normal\">$name</h3>
			";
		}
		elseif($area=="authbox"){
		}







		//loop
		$currentpostcount=0;
		foreach ($pageposts as $post):
		setup_postdata($post);
		$do_not_duplicate = $post->ID;

			$topstory120x120 = get_the_post_thumbnail( $post->ID, 'thumbnail' );

			$topstory500x250 = get_the_post_thumbnail( $post->ID, 'large' );

			if(!$topstory120x120){
				$topstory120x120 = get_post_meta($post->ID, 'topstory120x120', true);
				if(!$topstory120x120){
					$topstory120x120 = "http://media.insidepulse.com/shared/images/v7/default120x120_.jpg";
				}
				$topstory120x120 = "<img src='$topstory120x120'>";
			}
			if(!$topstory500x250){
				$topstory500x250 = get_post_meta($post->ID, 'topstory500x250', true);
				if(!$topstory500x250){
					$topstory500x250 = "http://media.insidepulse.com/shared/images/v7/default500x250_.jpg";
				}
				$topstory500x250 = "<img src='$topstory500x250'>";
			}
		$thispostid = $post->ID;
		$thistitle = $post->post_title;
		//$thistitle = strip_tags($thistitle);
		$thistitle = str_replace("\"", "", $thistitle);
		//$thistitle = substr($thistitle, 0, 100);

		$thisexcerpt = makeexcerpt($post->post_content, $post->post_excerpt, "default");

		$clickthru=get_permalink($thispostid);

		$thisdate = mysql2date('m.d.y', $post->post_date);

		$thisuserinfo = get_userdata($post->post_author);
		$thisuser = $thisuserinfo->display_name;
		$thisuserclick = "/" . $authorslug . "/" . $thisuserinfo->user_nicename . "/";

		if($area=="featuredhome"){
			$output_body .= "
						<div class=\"subtop_cell\">
							<div class=\"subtop_cell_left\">
								<a href=\"$clickthru\">$topstory120x120</a>
							</div>
							<div class=\"subtop_cell_right\">
								<a href=\"$clickthru\" class=\"headline\">$thistitle</a>
								<br>
								<span class=\"subtop_byline\">by <a href=\"$thisuserclick\" class=\"color1\">$thisuser</a> <img src=\"http://media.insidepulse.com/shared/images/v7/commentbubble.png\" class=\"hide\"> <a href=\"#\" class=\"color1 hide\">33</a></span>
							</div>
						</div>
			";

			if($currentpostcount>0&&($currentpostcount%2==1)){
				$output_body .= "
							<div class=\"clear\"></div>
				";
			}
		}

		elseif($area=="rightsidetabs"){
			$output_body .= "
					<div class=\"right_cell\">
						<div class=\"right_cell_left\">
							<a href=\"$clickthru\" alt=\"$thistitle\" title=\"$thistitle\">$topstory120x120</a>
						</div>
						<div class=\"right_cell_right\">
							<a href=\"$clickthru\" alt=\"$thistitle\" title=\"$thistitle\">$thistitle</a> <span class=\"date\">($thisdate)</span>
							<br><br>
							<span class=\"right_cell_byline\">by <a href=\"$thisuserclick\" class=\"color1\">$thisuser</a> <img src=\"http://media.insidepulse.com/shared/images/v7/commentbubble.png\" class=\"hide\"> <a href=\"#\" class=\"color1 hide\">33</a></span>
						</div>
					</div>
					<div class=\"clear\"></div>

			";
		}

		elseif($area=="related"){
			if($position>1){
				$classadd = "hide";
			}
			else{
				$classadd = "";
			}

			$output_body .= "
			<div class=\"article_box_cell $classadd\">
				<a href=\"$clickthru\" alt=\"$thistitle\" title=\"$thistitle\">$topstory500x250<br>$thistitle</a>
			</div>
			";
		}
		elseif($area=="narrowlinks"){
			$output_body .= "
				<div class=\"newsad_left_cell\">
					<a href=\"$clickthru\" alt=\"$thistitle\" title=\"$thistitle\">$topstory120x120</a>
					<a href=\"$clickthru\" alt=\"$thistitle\" title=\"$thistitle\">$thistitle <span class=\"color1\">&raquo;</span></a>
				</div>
			";
		}
		elseif($area=="featuredauthor"){
			//$thistitle = substr($thistitle, 0, 75);
			$output_body .= "
				<li><a href=\"$clickthru\" alt=\"$thistitle\" title=\"$thistitle\">&raquo; $thistitle</a></li>
			";
		}
		elseif($area=="authbox"){
			$output_body .= "
				<div class=\"article_authorbox_cell\">
					<a href=\"$clickthru\" alt=\"$thistitle\" title=\"$thistitle\">$topstory120x120</a>
				</div>
			";
		}

		$currentpostcount++;
		endforeach;

		if($area=="featuredhome"){
			$output_body .= "
				<div class=\"subtop_more\">
					<a href=\"$masterclickthru\" class=\"color1 bold\">&raquo; more $name</a>
				</div>
			</div>

			";

		}
		elseif($area=="rightsidetabs"){
			$output_body .= "
				<div class=\"right_cell_more\">
					<a href=\"$masterclickthru\" alt=\"$thistitle\" title=\"$thistitle\" class=\"color1 bold\">&raquo; more $name</a>
				</div>
			</div>

			";

		}

		elseif($area=="related"){
			$output_body .= "
			</div>
			";
		}
		elseif($area=="narrowlinks"){
		}
		elseif($area=="featuredauthor"){
		}
		elseif($area=="authbox"){
		}
	}

	$outputarray = array();
	$outputarray['header'] = $output_header;
	$outputarray['body'] = $output_body;
	return $outputarray;
}


function twitterlink($twitter){

	if(strstr("http", $twitter)){
		return $twitter;
	}
	else{
		return "http://twitter.com/".$twitter;
	}

}




function create_authbox($insider_userid, $area, $authorslug = "insider"){

	$sql_users = "
	SELECT user_login , user_pass , user_nicename , user_email , user_url , user_registered , user_activation_key , user_status , display_name
	FROM wp_users
	WHERE ID = '$insider_userid'
	";

	$result_users = mysql_query($sql_users) or die();

	while($row_users = mysql_fetch_array($result_users)){
		$insider_aim = $row_users['aim'];
		$insider_description = $row_users['description'];
		$insider_display_name = $row_users['display_name'];
		$insider_first_name = $row_users['first_name'];
		$insider_last_name = $row_users['last_name'];
		$insider_nickname = $row_users['nickname'];
		$insider_email = $row_users['user_email'];
		$insider_user_login = $row_users['user_login'];
		$insider_user_nicename = $row_users['user_nicename'];
	}


	$authorlink = "/" . $authorslug . "/" . $insider_user_nicename . "/";

	$allusermeta = getusermetawidro($insider_userid);
	$insider_avatar120 = $allusermeta['avatar120'];
	$insider_avatar500 = $allusermeta['avatar500'];
	$insider_rss1 = $allusermeta['rss1'];
	$insider_rss2 = $allusermeta['rss2'];
	$insider_rss3 = $allusermeta['rss3'];
	$insider_description = $allusermeta['description'];
	$insider_facebook = $allusermeta['facebook'];
	$insider_twitter = twitterlink($allusermeta['twitter']);
	$insider_twitterrss = $allusermeta['twitterrss'];
	$insider_quote = $allusermeta['quote'];
	$insider_row1 = $allusermeta['row1'];
	$insider_row2 = $allusermeta['row2'];
	$insider_row3 = $allusermeta['row3'];

	if(!$insider_avatar120){
		$insider_avatar120 = defaultimage("avatar", "topstory120x120");
	}

	//featuredauthor
	$authboxvalues = array();
	$authboxvalues[] = array('author', $insider_userid, $insider_display_name, $insider_avatar120);

	if($area=="singleauthbox"){
		$thisarea = "authbox";
	}
	elseif($area=="rightauthbox"){
		$thisarea = "featuredauthor";
	}
	$createsection = createsection($authboxvalues, $thisarea);
	$createsection_header = $createsection['header'];
	$createsection_body = $createsection['body'];

	if($area=="singleauthbox"){
		$output = "
			<div class=\"article_box_header\">
				<div class=\"article_box_header_left\">
					<h3 class=\"icon1 font2\">$insider_display_name</h3>

				</div>
				<div class=\"article_box_header_right\">
					<a href=\"$authorlink\" class=\"color1\">view profile &raquo;</a>
				</div>
			</div>
			<div class=\"clear\"></div>
			<div class=\"article_authorbox_body\">

				<div class=\"article_authorbox_bodyleft\">
					<a href=\"$authorlink\"><img class=\"article_authorbox_img avatar\" border=\"0\" src=$insider_avatar120></a>
				</div>


				<div class=\"article_authorbox_bodyright\">
					$insider_description
					<br><br>
		";
	if($insider_twitter){
		$output .= "
					<a class=\"color1 bold\" href=\"$insider_twitter\">Follow on Twitter</a> &middot;
		";
	}

	if($insider_facebook){
		$output .= "
					<a class=\"color1 bold\" href=\"$insider_facebook\">Follow on Facebook</a> &middot;
		";
	}
		$output .= "
					<a class=\"color1 bold\" href=\"mailto:$insider_email\">Email $insider_display_name</a>



				</div>
				<div class=\"clear\" style=\"height:10px;\"></div>

				<h3 class=\"icon1 font2\" style=\"color:#999999; margin-top:30px;float:left;font-weight:normal;\">Recent Posts &raquo; </h3>
				<div class=\"article_box_related\">
					$createsection_body
				</div>
				<div class=\"clear\"></div>

			</div>


		";
	}
	elseif($area=="rightauthbox"){

		$output = "
			<div class=\"right_greybox_author\">
				<div class=\"right_greybox_authorleft\">
					<a href=\"$authorlink\" alt=\"$insider_display_name's Profile\" title=\"$insider_display_name's Profile\"><img src=\"$insider_avatar120\" class=\"right_greybox_avatar120\"></a>
				</div>
				<div class=\"right_greybox_authorright\">
					$createsection_body
				</div>
			</div>
				<div class=\"clear\"></div>


		";
	}

	return $output;

}



function make_narrow($createsection){

	$narrowlinks_tabs = $createsection['header'];
	$narrowlinks = $createsection['body'];

	$output = "
		<div class=\"newsad_left\">
			<div class=\"newsad_left_cell ar\">
			$narrowlinks_tabs
			</div>
			$narrowlinks
		</div>
	";

	return $output;

}












?>
