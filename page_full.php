<?php get_header(); ?>
	<div class="content_left" style="width:1050px;">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

		<div class="article_headline color1 bold" style="width:1050px;">
			<?php the_title(); ?>
		</div>
		<div class="article_body" style="width:1050px;">
				<!-- content -->
<?
if(is_page('tv-show-madness')){
	// main loop sql
	$sqladd = "&tag=tv-show-madness-2012";

	$the_query = new WP_Query('&showposts=5' . $sqladd . '&orderby=post_date&order=desc');

	//top story loop
	while ($the_query->have_posts()) : $the_query->the_post();

	$thistitle = $post->post_title;
	$thisexcerpt = $post->post_excerpt;

	if(!$thisexcerpt){
		$thisexcerpt = $post->post_content;

	}
	$thisexcerpt = strip_tags($thisexcerpt);
	$thisexcerpt = substr($thisexcerpt, 0, 180);

	$clickthru=get_permalink($thispostid);

	//outputs date in wacky format
	$thisdate = mysql2date('M j, Y', $post->post_date);
?>

<li><a href="<?php echo $clickthru; ?>"><?php echo $thistitle; ?></a></li>

<?php
	endwhile;
}
?>


				<?php the_content(''); ?>



				<!-- content end -->
		</div>


<?php endwhile; else: ?>
	<p>Lost? Go back to the <a href="<?php echo get_option('home'); ?>/">home page</a>.</p>
<?php endif; ?>
<?php include('footer.php'); ?>