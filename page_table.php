<?php get_header(); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<div class="content_left">




<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

		<div class="article_headline color1 bold">
			<?php the_title(); ?> <?php edit_post_link('(edit)','',' '); ?>
		</div>
		<div class="article_body">
				<!-- content -->
				<?php if(is_page('dvd-release-dates')){ echo "<img src='http://insidepulse.com/wp-content/uploads/2014/12/dvdrelease1600.jpg' style='padding:0px;width:660px;' />"; } ?>
				<?php if(is_page('upcoming-theatrical-movie-release-calendar')){ echo "<img src='http://insidepulse.com/wp-content/uploads/2014/12/template1600_movreleases.jpg' style='padding:0px;width:660px;' />"; } ?>
				<?php the_content(''); ?>
				<!-- content end -->

		</div>







<?php endwhile; else: ?>
	<p>Lost? Go back to the <a href="<?php echo get_option('home'); ?>/">home page</a>.</p>
<?php endif; ?>





<?php include('sidebar.php'); ?>
<?php include('footer.php'); ?>