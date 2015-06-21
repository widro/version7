<?php // You can start editing here -- including this comment! ?>

		<div class="article_authorbox_header" style="border-bottom:2px solid #999999;">
			<div class="article_box_header_left">
				<h3 class="icon1 font2">Comments (<?php echo get_comments_number(); ?>)</h3>

			</div>
			<div class="article_box_header_right">
'			</div>
		</div>
		<div class="clear"></div>

<?php
	$insider_avatar120 = "http://insidepulse.com/wp-content/uploads/2011/10/thenewgirl-120x120.jpg";
?>

<?php if ( have_comments() ) : ?>
	<?php foreach ($comments as $comment) : ?>

		<div class="comments_cell" id="comment-<?php comment_ID() ?>">
			<div class="comments_cell_left">
				<a href=<?php echo $authorlink ?>><img class="avatar" border="0" src=<?php echo $insider_avatar120 ?>></a>

			</div>
			<div class="comments_cell_right">
				<?php if ($comment->comment_approved == '0') : ?>
					<em>Your comment is awaiting moderation.</em>
				<?php endif; ?>
				<?php comment_text() ?>
				<p>Posted by <span class="commentauthor"><?php comment_author_link() ?></span> | <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F j, Y') ?>, <?php comment_time() ?></a> <?php edit_comment_link('edit','| ',''); ?></p>
			</div>
		</div>
		<div class="clear"></div>


	<?php endforeach; /* end for each comment */ ?>
<?php endif; // end have_comments() ?>







<?php if ('open' == $post->comment_status) : ?>

<div id="comment-form">


<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>

</div>
<?php else : ?>
			<div class=single_section_header>
				Add Your Comment

			</div>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>

(Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>)

<?php else : ?>

<div class="commentform_row">

	<div class="commentform_label">
		Name <?php if ($req) echo "*"; ?>
	</div>
	<div class="commentform_input">
		<input type="text" class="commentform_inputfield" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
	</div>

</div>

<div class="commentform_row">

	<div class="commentform_label">
		E-mail <?php if ($req) echo "*"; ?>
	</div>
	<div class="commentform_input">
		<input type="text" class="commentform_inputfield" name="email" id="email" value="<?php echo $comment_email; ?>" tabindex="1" />
	</div>

</div>



<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<div class="commentform_row">

	<div class="commentform_label">
		Comment
	</div>
	<div class="commentform_input">
		<textarea name="comment" id="comment" tabindex="4"></textarea>
	</div>

</div>
<div class="commentform_row">

	<div class="commentform_label">


	</div>
	<div class="commentform_input">
		<input name="submit" type="submit" id="submit" tabindex="5" class="commentform_inputbutton" value="Submit Comment" />
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	</div>

</div>


<?php do_action('comment_form', $post->ID); ?>

</fieldset>

</form>


<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
