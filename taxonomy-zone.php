<?php get_header(); ?>
<?php
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
	$thistitle = strip_tags($thistitle);
	$thistitle = str_replace("\"", "", $thistitle);
	$thistitle = substr($thistitle, 0, 100);

	$thisexcerpt = makeexcerpt($post->post_content, $post->post_excerpt, "default");

	$clickthru=get_permalink($thispostid);

	//outputs date in wacky format
	$thisdate = mysql2date('h|m|s|m|d|Y', $post->post_date);

	//explodes date by |
	$thisdatearr = explode("|", $thisdate);

	//converts pipe exploded array into unix ts
	$unixtimestamp =  mktime((int)$thisdatearr[0], (int)$thisdatearr[1], (int)$thisdatearr[2], (int)$thisdatearr[3], (int)$thisdatearr[4], (int)$thisdatearr[5]);

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
		$topstory120x120 = $thispost['topstory120x120'];
		$topstory500x250 = $thispost['topstory500x250'];
		$clickthru = $thispost['clickthru'];
		$thisexcerpt = $thispost['excerpt'];
		$thistitle = $thispost['title'];


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

				$topstory500x250 = str_replace("img src", "img class=\"on\" id=\"topstorythumb_$topstoryposition\" name=\"topstorythumb_$topstoryposition\" src", "$topstory500x250");

				$featuredthumbrow .= "
					<div class=\"topstory_scroll_cell\">
						<a href=\"$clickthru\">$topstory500x250</a>
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

				$topstory500x250 = str_replace("img src", "img id=\"topstorythumb_$topstoryposition\" name=\"topstorythumb_$topstoryposition\" src", "$topstory500x250");

				$featuredthumbrow .= "
					<div class=\"topstory_scroll_cell\">
						<a href=\"$clickthru\">$topstory500x250</a>
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



	<h3 class="icon2m bold" style="margin-top:2px;border-bottom:1px solid #dddddd;">Full Listing</span></h3>

<?php if (have_posts()) : ?>
<?php


while (have_posts()) : the_post();
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
	$thistitle = str_replace("\"", "", $thistitle);
	$thistitle = substr($thistitle, 0, 100);

	$thisexcerpt = makeexcerpt($post->post_content, $post->post_excerpt, "default");
	$clickthru=get_permalink($thispostid);
	$thisdate = mysql2date('m.d.y', $post->post_date);
	$author = get_the_author();

	echo listingcell($thistitle, $thisdate, $author, $clickthru, $thisexcerpt, $topstory120x120, $topstory500x250);
endwhile;
?>


<div class="pagelinks">
	<div class="pagelinks_left">
		<?php next_posts_link('&laquo; Previous') ?>
	</div>
	<div class="pagelinks_right">
		<?php previous_posts_link('Next &raquo;') ?>
	</div>
</div>


<?php endif; ?>

<?php include('sidebar.php'); ?>

<?php include('footer.php'); ?>