<?php get_header(); ?>
	<div class="content_left">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

		<div class="article_headline color1 bold">
			<?php the_title(); ?>
		</div>
		<div class="article_body">
<?php
if(is_page('new-video')){
?>

<iframe name=" insidepulse_visanfl_p1" src=" http://cdn.alphabird.com/assets/iframes/insidepulse_p1/frame_insidepulse_visanfl_p1.htm" width = "640" height="880" frameborder="0" scrolling="no"></iframe>

<?php
}
elseif(is_page('the-ride-season-3-the-game-ifeadi-odenigbo')){
?>

<iframe name=" insidepulse_hss_p1" src="http://cdn.alphabird.com/assets/iframes/insidepulse_hss_p1/frame_insidepulse_hss_p1.htm" width = "640" height="880" frameborder="0" scrolling="no"></iframe>

<?php
}
elseif(is_page('dell2')){
?>

<iframe name="insidepulse_p2_dell" src="http://cdn.alphabird.com/assets/iframes/insidepulse_p2/frame_insidepulse_p2.htm" width = "640" height="880" frameborder="0" scrolling="no"></iframe>

<?php
} else{
?>


<?php the_content(); ?>
<?php
}
?>




<h3 class="icon1 font2 color1">Inside Pulse Latest Updates:</h3>



<?php

	$i=0;
	$sqladd = "";
	$the_query = new WP_Query('&showposts=10' . $sqladd . '&orderby=post_date&order=desc');

	//top story loop
	while ($the_query->have_posts()) : $the_query->the_post();

	$topstory120x120 = get_post_meta($post->ID, 'topstory120x120', true);
	$topstory500x250 = get_post_meta($post->ID, 'topstory500x250', true);
	if($topstory500x250==""){
		$topstory500x250 = defaultimage($thiscat_name, "topstory500x250");
	}

	if($topstory120x120==""){
		$topstory120x120 = defaultimage($thiscat_name, "topstory120x120");
	}

	$thistitle = $post->post_title;
	$thistitle = str_replace("\"", "", $thistitle);
	$thistitle = substr($thistitle, 0, 100);

	$thisexcerpt = makeexcerpt($post->post_content, $post->post_excerpt, "default");

	$clickthru=get_permalink($thispostid);
	$thisdate = mysql2date('m.d.y', $post->post_date);
	$author = get_the_author();
	$grey=false;
	if($i%2==1){
		$grey=true;
	}

	echo listingcell($thistitle, $thisdate, $author, $clickthru, $thisexcerpt, $topstory120x120, $topstory500x250, $grey);
$i++;
endwhile;
?>












		</div>
		<div class="clear"></div>

		<?php
		$relatedfile = $overallpath.'generate/category/l-cat-top-story.html';
		include($relatedfile);
		$relatedfile = $overallpath.'generate/category/l-cat-news.html';
		include($relatedfile);
		$relatedfile = $overallpath.'generate/category/l-cat-reviews.html';
		include($relatedfile);
		?>

		<div class="clear"></div>



<?php endwhile; else: ?>
	<p>Lost? Go back to the <a href="<?php echo get_option('home'); ?>/">home page</a>.</p>
<?php endif; ?>


<?php include('sidebar.php'); ?>




<?php include('footer.php'); ?>