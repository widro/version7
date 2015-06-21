<?php get_header(); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">



<div class="content_left" style="width:1050px;">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

		<div class="article_headline color1 bold" style="width:100%;">
			<?php the_title(); ?> <?php edit_post_link('(edit)','',' '); ?>
		</div>
				<!-- content -->
				<?php if(is_page('dvd-review-archive')){ echo "<img src='http://insidepulse.com/wp-content/uploads/2014/12/dvdreviews.jpg' style='padding:0px;width:1050px;' />"; } ?>

<p style="text-align:center; padding:20px;font-size:14px;font-style:italic;">Inside Pulse launched on August 9, 2004, and have been reviewing movies on DVD and Blu-ray for over a decade! Now you can search through our full DVD/Blu-ray review archive, searchable by a large number of parameters. And of course, every week there are new reviews being added to the archive, so be sure to check it out regularly!
</p>

<table class="table table-striped" style="height:2000px;">
<tr>
<td>date</td>
<td>image</td>
<td>title</td>
<td>author</td>
<td>score</td>
</tr>

<?php
//build wordpress query

$sqladd = "";
$sqladd .= "&category_name=dvd-reviews,blu-ray-reviews";
$sqladd .= "&zone=movies";

$the_query = new WP_Query('post_status=publish&limit=40'. $sqladd);
$tempi = 0;
while ($the_query->have_posts()) : $the_query->the_post();
$do_not_duplicate = $post->ID;

//query_posts($sqladd);

$default120url = "http://media.insidepulse.com/shared/images/logos/default120_insidepulse.jpg";
$default500url = "http://media.insidepulse.com/shared/images/logos/default500_insidepulse.jpg";

$topstory120x120 = get_post_meta($post->ID, 'topstory120x120', true);
$topstory500x250 = get_post_meta($post->ID, 'topstory500x250', true);
if($topstory500x250==""){
	$topstory500x250 = defaultimage("loader", "topstory500x250");
}

if($topstory120x120==""){
	$topstory120x120 = defaultimage("loader", "topstory120x120");
}
$thistitle = $post->post_title;
$thisdate = mysql2date('M j, Y', $post->post_date);
$thisdate = mysql2date('M j, Y', $post->post_date);
$clickthru=get_permalink($thispostid);

//$author = $post->post_author;
$author = get_the_author();
$author = "<a class=\"color1\" href=\"" . get_author_posts_url($post->post_author) . "\">" . get_the_author() . "</a>";


$star_rating = get_post_meta($post->ID, 'star_rating', true);
if($star_rating==""){
	$star_rating = "X";
}
if(!$topstory500x250){
	$topstory500x250 =  $default500avatarurl;
}

if(!$topstory120x120){
	$topstory120x120 = $default120avatarurl;
}


if($tempi%2==0){
	$loaderoutput .=  listingcell($thistitle, $thisdate, $author, $clickthru, $thisexcerpt, $topstory120x120, $topstory500x250);
}
else{
	$loaderoutput .=  listingcell($thistitle, $thisdate, $author, $clickthru, $thisexcerpt, $topstory120x120, $topstory500x250, true);
}

$tempi++;

echo "
<tr>
<td>$thisdate</td>
<td><img src=\"$topstory120x120\" width=50></td>
<td><a class=\"color1\" href=\"$clickthru\">$thistitle</a></td>
<td>$author</td>
<td>$star_rating</td>
</tr>

";

endwhile;



?>


</table>
				<!-- content end -->

	<div class="clear"></div>

</div>

<?php endwhile; else: ?>
	<p>Lost? Go back to the <a href="<?php echo get_option('home'); ?>/">home page</a>.</p>
<?php endif; ?>



<?php include('footer.php'); ?>