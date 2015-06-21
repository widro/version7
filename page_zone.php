<?php get_header();

	$featuredhome = createsection($featuredvalues, "featuredhome");
	$featuredtabs = $featuredhome['header'];
	$featuredcells = $featuredhome['body'];

	//top story vars
	$showcheck = false;
	$topstoryposition = 1;

	// top story sql
	$the_query = new WP_Query('&showposts=4' . $topstorysqladd . '&category_name=top-story&orderby=post_date&order=desc');

	//top story loop
	while ($the_query->have_posts()) : $the_query->the_post();
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

	$thistitle = $post->post_title;
	//$thistitle = strip_tags($thistitle);
	$thistitle = str_replace("\"", "", $thistitle);

	$thisexcerpt = makeexcerpt($post->post_content, $post->post_excerpt, "default");

	$clickthru=get_permalink($thispostid);

	//outputs date in wacky format
	$thisdate = mysql2date('h|m|s|m|d|Y', $post->post_date);

	//explodes date by |
	$thisdatearr = explode("|", $thisdate);

	//converts pipe exploded array into unix ts
	$unixtimestamp =  mktime((int)$thisdatearr[0], (int)$thisdatearr[1], (int)$thisdatearr[2], (int)$thisdatearr[3], (int)$thisdatearr[4], (int)$thisdatearr[5]);
	$unixtimestamp = (int)$unixtimestamp;
	$postarray[$unixtimestamp]['title'] = $thistitle;
	$postarray[$unixtimestamp]['clickthru'] = $clickthru;
	$postarray[$unixtimestamp]['excerpt'] = $thisexcerpt;
	$postarray[$unixtimestamp]['content'] = $thiscontent;
	$postarray[$unixtimestamp]['post_date'] = $post->post_date;
	$postarray[$unixtimestamp]['topstory500x250'] = $topstory500x250;
	$postarray[$unixtimestamp]['topstory120x120'] = $topstory120x120;

	endwhile;


	$postarray3 = $postarray;

$topstoryposition=1;
foreach($postarray3 as $thispost){

	if($topstoryposition<5){
		//vars

		$clickthru = $thispost['clickthru'];
		$thisexcerpt = $thispost['excerpt'];
		$thistitle = $thispost['title'];
		$thisexcerpt = substr($thisexcerpt, 0, 150);
		//$thistitle = substr($thistitle, 0, 100);
		$topstory120x120 = $thispost['topstory120x120'];
		$topstory500x250 = $thispost['topstory500x250'];


		//build top story rotator
		if($topstory120x120&&$topstory500x250){
			if($topstoryposition==1){
				$rotatorimages .= "
					<li class=\"show\"><a href=\"$clickthru\">$topstory500x250</a></li>
				";
				$rotatorclicks .= "
					<li class=\"show\">
						<a href=\"$clickthru\" class=\"topstory_headline color1 bold\">$thistitle</a>
						<br><br>
						$thisexcerpt
						<br><br>
						<a href=\"$clickthru\" class=\"fr bold\">read more &raquo;</a>
					</li>
				";

				$featuredthumbrow .= "
					<div class=\"topstory_scroll_cell\">
						<a href=\"$clickthru\"><img id=\"topstorythumb_$topstoryposition\" name=\"topstorythumb_$topstoryposition\" src=\"$topstory500x250\" class=\"on\"></a>
					</div>
				";
			}
			else{
				$rotatorimages .= "
					<li><a href=\"$clickthru\">$topstory500x250</a></li>
				";
				$rotatorclicks .= "
					<li>
						<a href=\"$clickthru\" class=\"topstory_headline color1 bold\">$thistitle</a>
						<br><br>
						$thisexcerpt
						<br><br>
						<a href=\"$clickthru\" class=\"fr bold\">read more &raquo;</a>
					</li>
				";

				$featuredthumbrow .= "
					<div class=\"topstory_scroll_cell \">
						<a href=\"$clickthru\"><img id=\"topstorythumb_$topstoryposition\" name=\"topstorythumb_$topstoryposition\" src=\"$topstory500x250\"></a>
					</div>
				";
			}

			$topstoryposition++;
		}
	}
}

?>


	<div class="content_left">

		<div class="topstory">
			<div class="topstory_left">
				<?php echo $rotatorimages; ?>
			</div>
			<div class="topstory_right">
				<?php echo $rotatorclicks; ?>
			</div>
		</div>


		<div class="clear"></div>


		<div class="topstory_scroll">
			<div id="topstoryarrowleft" class="topstory_scroll_arrow">
				<a href="#"><img src="http://media.insidepulse.com/shared/images/v7/topstoryscrollarrow_left.png"></a>
			</div>
			<?php echo $featuredthumbrow; ?>

			<div id="topstoryarrowright" class="topstory_scroll_arrow">
				<a href="#"><img src="http://media.insidepulse.com/shared/images/v7/topstoryscrollarrow_right.png"></a>
			</div>


		</div>

		<div class="clear"></div>


		<div id="featured" name="featured3" class="featured_tabs">
			<?php echo $featuredtabs; ?>
		</div>
		<div class="clear"></div>
			<?php echo $featuredcells; ?>

		<div class="clear" style="height:20px;"></div>





		<div class="left4x2">

<?php

$left4x2count = count($left4x2values);
for($i=0;$i<$left4x2count;$i++){
	//grab zone
	$type = $left4x2values[$i][0];
	$slug = $left4x2values[$i][1];
	$name = $left4x2values[$i][2];
	$masterclickthru = $left4x2values[$i][3];

	$zonecounter=0;
	$otherlinks = "";
	$post = "";

	$sqladd = makesql($type, $slug);
	//top story loop

	if($type=="rss"){

	//	$left4x2values[] = array('rss', 'http://wrestling.insidepulse.com/feed/', 'Wrestling', 'http://wrestling.insidepulse.com/');

		$postsarrayall = getrsslinks($slug, $name, 4, "array");
		foreach($postsarrayall as $postsarray){
			$topstory120x120 = $postsarray['topstory120x120'];
			$topstory500x250 = $postsarray['topstory500x250'];
			$thistitle = $postsarray['title'];
			//$thistitle = strip_tags($thistitle);
			$thisexcerpt = $postsarray['excerpt'];
			$clickthru = $postsarray['clickthru'];
			$post_date = $postsarray['post_date'];

			if($zonecounter==0){
				$toplink = "
						<a href=\"$clickthru\">$topstory500x250</a>
						<a href=\"$clickthru\" class=\"left4x2_headline\">$thistitle</a>
				";

			}
			else{
				$otherlinks .= "
							<li><a href=\"$clickthru\">$thistitle</a></li>
				";
			}

			$zonecounter++;
		}
	}
	else{
		// zone sql
		$the_query = new WP_Query('&showposts=4'.$sqladd.'&orderby=post_date&order=desc');

		while ($the_query->have_posts()) : $the_query->the_post();
			$do_not_duplicate = $post->ID;
			$thispostid = $post->ID;

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
			$thistitle = $post->post_title;
			//$thistitle = strip_tags($thistitle);
			$thistitle = str_replace("\"", "", $thistitle);
			//$thistitle = substr($thistitle, 0, 100);

			$thisexcerpt = makeexcerpt($post->post_content, $post->post_excerpt, "default");

			$clickthru=get_permalink($thispostid);

			if($zonecounter==0){
				$toplink = "
						<a href=\"$clickthru\">$topstory500x250</a>
						<a href=\"$clickthru\" class=\"left4x2_headline\">$thistitle</a>
				";

			}
			else{
				$otherlinks .= "
							<li><a href=\"$clickthru\">$thistitle</a></li>
				";
			}

			$zonecounter++;
		endwhile;
	}
?>


			<div class="left4x2_column">
				<a href="<?php echo $masterclickthru; ?>"><h3 class="icon1 font2 color1"><?php echo $name; ?></h3></a>
				<div class="greyline150"></div>
				<?php echo $toplink ?>
				<ul>
				<?php echo $otherlinks ?>
				</ul>
				<div class="left4x2_more ar">
					<a href="<?php echo $masterclickthru; ?>" class="left4x2_more color1">more &raquo;</a>
				</div>
			</div>

<?php

		//check for every four for clear
		if(($i==3)||($i==7)||($i==11)){
			echo "<div class=\"clear\"></div>";
		}
}
?>

		</div>

		<div class="clear" style="height:20px;"></div>
<?php
if($thisurl==$insidefightsurl){
?>

<!-- begin player embed code -->
<style type="text/css">
<!--
.poweredby {
	font-size: 13px;
	color: #FFFFFF;
	text-decoration: none;
	font-family: trebuchet ms;
}
.bellator {
	font-size: 20px;
	color: #ffffff;
	font-weight: bold;
	text-decoration: none;
	font-family: trebuchet ms;
}
-->
</style>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="400" height="24"bgcolor="#000000" align="right"><a href="http://www.bellator.com/" target="_blank"><span class="poweredby">Powered by </span><span class="bellator">Bellator.com</span></a>&nbsp;</td>
  </tr>
<tr><td>
<object width="400" height="374" id="iptvsyndicated" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
	<param name="movie" value="http://www.bellator.com/mediaPortal/inline.swf" />
	<param name="flashVars" value="playerId=33707&server=http://www.bellator.com/XML/titanv3/&pageurl=http://www.bellator.com/mediaPortal/&sitename=aff.bellator.insidefights&locimage=http://image.cdnl3.xosnetwork.com/mediaPortal/&jtv=23600&skin=23600&gaa=UA-851411-5&companion=true&htmlid=iptvsyndicated&brandTextColor=0xCCCCCC&brandTextSelectedColor=0xFFFFFF&autostart=true&mute=true" />
	<param name="quality" value="high" />
	<param name="allowFullScreen" value="true" />
	<param name="allowScriptAccess" value="always" />
	<embed name="iptvsyndicated" pluginspage="http://www.adobe.com/go/getflashplayer" src="http://www.bellator.com/mediaPortal/inline.swf" type="application/x-shockwave-flash" width="400" height="374" quality="high" allowFullScreen="true" allowScriptAccess="always" flashVars="playerId=33707&server=http://www.bellator.com/XML/titanv3/&pageurl=http://www.bellator.com/mediaPortal/&sitename=aff.bellator.insidefights&locimage=http://image.cdnl3.xosnetwork.com/mediaPortal/&jtv=23600&skin=23600&gaa=UA-851411-5&companion=true&htmlid=iptvsyndicated&brandTextColor=0xCCCCCC&brandTextSelectedColor=0xFFFFFF&autostart=true&mute=true"></embed>
</object>
</td>
</tr>
</table>
<!-- end player embed code -->





<?php
}
?>






<?php

	if(($active_zone!="home")&&(!is_home())){
		include('sidebar.php');
	}
	else{
		include('sidebar.php');
	}

?>


<?php include('footer.php'); ?>
