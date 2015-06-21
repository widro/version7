<?php get_header(); ?>
<style>


/*** this is on the slide tab_on, figure out something better later **/
.tab_on{
	background:#cccccc;
}
</style>



<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<!--
<?php the_title(); ?>
-->

<!-- content -->
<!--
<?php the_content(''); ?>
-->
<!-- content end -->


<?php if(is_page('advertising')){ ?>
<div class="inner" id="slides" name="slides5">
		<div id="slide_content1" name="slides_content1" class="slide_container">

			<div class="slide_container_narrow fl slide_border" style="padding-top:150px;padding-bottom:100px;">
				<h3 class="color1 font2">Advertise on Inside Pulse</h3>
				<h4>Inside Pulse provides a variety of advertising and integration options for advertisers of all sizes and types.</h4>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>

			</div>
			<div class="slide_container_wide fr" style="padding-top:200px;">
				<img src="http://media.insidepulse.com/shared/images/v7/logo_blacktext.png" height=70  style="padding-left:50px;">
			</div>

		</div>

		<div id="slide_content2" name="slide_content2" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Audience/Demographics</h3>
				<h4>By advertising on Inside Pulse, your brand can reach a dedicated readership of pop culture junkies.</h4>

			</div>
			<div class="slide_container_wide fr">
				<h2 class="font2">Primary Demographics</h2>
				<p>Male 18-34</p>
				<p>Male 18-49</p>
				<h2 class="font2">Primary Regions</h2>
				<p>United States: 75%</p>
			</div>

		</div>

		<div id="slide_content3" name="slide_content3" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Display Ad Units</h3>
				<h4>Inside Pulse uses a variety of IAB-compliant display ad units in fixed locations above and below the fold.</h4>
				<p>Banner ad (728x90)
				Rectangle ad (300x250)
				Tower/Skyscraper ad (160x600)
				</p>

			</div>
			<div class="slide_container_wide fr">
				<div style="width:550px; height:120px;">
					<img src="http://media.insidepulse.com/shared/images/v7/ad728.png" width=550>
					<h4>728x90 Leaderboard Banner</h4>

					<img src="http://media.insidepulse.com/shared/images/v7/ad300.png">
					<h4>300x250 Rectangle</h4>
				</div>
				<div style="width:300px; height:350px;float:right;z-index:5;">
					<img src="http://media.insidepulse.com/shared/images/v7/ad160.png" width=120>
					<h4>160x600 Skyscraper/Tower</h4>
				</div>

			</div>

		</div>

		<div id="slide_content4" name="slide_content4" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Integrated Opportunities</h3>
				<h4>In addition to typical ad units that run across the site, Inside Pulse offers a variety of deeper integrated opportunities for premium advertisers.</h4>
				<p>Site wraps
				Sponsored blogs/content
				In-media adveritisng (audio, video)
				</p>

			</div>
			<div class="slide_container_wide fr">
				<img src="http://media.insidepulse.com/shared/images/v7/screengrab_homev7.jpg" width=550>
			</div>

		</div>

		<div id="slide_content5" name="slide_content5" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Contact Us</h3>
				<h4>Talk or message any of our sales representatives to work out a package that fits your needs!</h4>

			</div>
			<div class="slide_container_wide fr">
				<h2 class="font2">General Sales Inquiries</h2>
				<p>Jonathan Widro - <a href="mailto:jwidro@insidepulse.com">jwidro@insidepulse.com</a></p>

				<h2 class="font2">Integrated Sales Inquiries</h2>
				<p>Shawn M. Smith - <a href="mailto:sms@insidepulse.com">sms@insidepulse.com</a></p>


			</div>

		</div>



		<div class="slide_footer">
			<div class="slide_footer_left">
				&copy; <?php echo date("Y"); ?> Inside Pulse
			</div>
			<div id="slide" name="slide5" class="slide_tabs">
				<div id="slide_n" class="tab font2 slidetab fl cp">&laquo; </div>
				<div id="slide_1" class="tab font2 slidetab fl cp tab_on">1</div>
				<div id="slide_2" class="tab font2 slidetab fl cp">2</div>
				<div id="slide_3" class="tab font2 slidetab fl cp">3</div>
				<div id="slide_4" class="tab font2 slidetab fl cp">4</div>
				<div id="slide_5" class="tab font2 slidetab fl cp">5</div>
				<div id="slide_p" class="tab font2 slidetab fl cp">&raquo; </div>
			</div>
			<div class="slide_footer_right">
				Inside Pulse Advertising Guide &middot; (<a href="#" class="color1">pdf</a>)
			</div>
		</div>

<?php } ?>







<?php if(is_page('media-kit')){ ?>
<div class="inner" id="slides" name="slides6">
		<div id="slide_content1" name="slides_content1" class="slide_container">

			<div class="slide_container_narrow fl slide_border" style="padding-top:150px;">
				<h3 class="color1 font2">Inside Pulse Media Kit</h3>
				<h4>Inside Pulse is a pop culture and entertainment platform with exclusive content, strong brand engagement and limitless partnership opportunities</h4>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>

			</div>
			<div class="slide_container_wide fr" style="padding-top:200px;">
				<img src="http://media.insidepulse.com/shared/images/v7/logo_blacktext.png" height=70  style="padding-left:50px;">
			</div>

		</div>

		<div id="slide_content2" name="slide_content2" class="slide_container hide">

			<div class="slide_container_wide fl slide_border">
				<h2 class="font2">Logo</h2>
				<img src="http://media.insidepulse.com/shared/images/v7/logo_blacktext.png" height=50>
				<h2 class="font2">Logo (on Black)</h2>
				<img style="background:#000000;" src="http://media.insidepulse.com/shared/images/v7/logo_whitetext.png" height=50>

				<h2 class="font2">Branding Icons</h2>
				<img src="http://media.insidepulse.com/shared/images/v7/icon1.png" height=100>
				<img src="http://media.insidepulse.com/shared/images/v7/icon2.png" height=100>

			</div>
			<div class="slide_container_narrow fr" style="padding-top:50px; padding-bottom:200px;">
				<h3 class="color1 font2" fr>Logos</h3>
				<h4>The Inside Pulse logo is striking and bold, and needs to be used in a prescribed manner</h4>
				<p>yaddar</p>

			</div>

		</div>

		<div id="slide_content3" name="slide_content3" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border" style="padding-top:150px;">
				<h3 class="color1 font2">Partners</h3>
				<h4>Inside Pulse has a variety of content, marketing and advertising partnerships.</h4>
				<p>Branding to remain consistent throughout text, audio and video content</p>
				<p>Branding to remain consistent throughout text, audio and video content</p>

			</div>
			<div class="slide_container_wide fr">
				<h2 class="font2">Content Partners:<h2>
				Fox Sports

				<h2 class="font2">Advertising Partners:<h2>
				Google SportsfanLive

				<h2 class="font2">Technology Partners:<h2>
				Wordpress Gravity


			</div>

		</div>

		<div id="slide_content4" name="slide_content4" class="slide_container hide">

			<div class="slide_container_wide fl slide_border">
				dinkerssssssss
			</div>

			<div class="slide_container_narrow fr">
				<h3 class="color1 font2">Integrated Opportunities</h3>
				<h4>In addition to typical ad units that run across the site, Inside Pulse offers a variety of deeper integrated opportunities for premium advertisers.</h4>
				<p>Site wraps
				Sponsored blogs/content
				In-media adveritisng (audio, video)
				</p>

			</div>
		</div>

		<div id="slide_content5" name="slide_content5" class="slide_container hide">


			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Brand in Text</h3>
				<h4>Inside Pulse uses a guideline for how to refer to the brand and various subbrands and zones.</h4>
				<p>Branding to remain consistent throughout text, audio and video content</p>
				<p>Branding to remain consistent throughout text, audio and video content</p>

			</div>
			<div class="slide_container_wide fr">
				<h2>Correct:<h2>
				Inside Pulse
				<h2>Incorrect:<h2>
				InsidePulse

			</div>
		</div>

		<div id="slide_content6" name="slide_content6" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Contact Us</h3>
				<h4>Talk or message any of our editors or PR representatives to work out barter agreements, product reviews, press junkets or any other opportunities</h4>

			</div>
			<div class="slide_container_wide fr">
				<h2 class="font2">General Inquiries</h2>
				<p>Murtz Jaffer - <a href="mailto:jwidro@insidepulse.com">jwidro@insidepulse.com</a></p>

				<h2 class="font2">Movies/DVD Inquiries</h2>
				<p>Travis Leamons - <a href="mailto:jwidro@insidepulse.com">jwidro@insidepulse.com</a></p>

				<h2 class="font2">Comics Inquiries</h2>
				<p>Grey Scherl - <a href="mailto:jwidro@insidepulse.com">jwidro@insidepulse.com</a></p>

				<h2 class="font2">Video Games Inquiries</h2>
				<p>DJ Tjuistin - <a href="mailto:jwidro@insidepulse.com">jwidro@insidepulse.com</a></p>


			</div>

		</div>



		<div class="slide_footer">
			<div class="slide_footer_left">
				&copy; <?php echo date("Y"); ?> Inside Pulse
			</div>
			<div id="slide" name="slide6" class="slide_tabs">
				<div id="slide_n" class="tab font2 slidetab fl cp">&laquo; </div>
				<div id="slide_1" class="tab font2 slidetab fl cp tab_on">1</div>
				<div id="slide_2" class="tab font2 slidetab fl cp">2</div>
				<div id="slide_3" class="tab font2 slidetab fl cp">3</div>
				<div id="slide_4" class="tab font2 slidetab fl cp">4</div>
				<div id="slide_5" class="tab font2 slidetab fl cp">5</div>
				<div id="slide_6" class="tab font2 slidetab fl cp">6</div>
				<div id="slide_p" class="tab font2 slidetab fl cp">&raquo; </div>
			</div>
			<div class="slide_footer_right">
				Inside Pulse Media Kit &middot; (<a href="#" class="color1">pdf</a>)
			</div>
		</div>

<?php } ?>







<?php if(is_page('about')){ ?>
<div class="inner" id="slides" name="slides6">
		<div id="slide_content1" name="slides_content1" class="slide_container">

			<div class="slide_container_wide fl slide_border" style="padding-top:180px; padding-bottom:200px;">
				<img src="http://media.insidepulse.com/shared/images/v7/logo_blacktext.png" height=70  style="padding-left:50px;">
				<h2 class="font2" style="padding-left:80px;">Pop Culture & Entertainment Platform</h2>
			</div>

			<div class="slide_container_narrow fr" style="padding-top:200px;">
				<h3 class="color1 font2">Welcome to Inside Pulse!</h3>
				<h4>Inside Pulse is one the world's largest independent publisher, with 100s of original, exclusive articles published each week</h4>
				<p>Check out what makes Inside Pulse worth your time to read each and every day!</p>

			</div>
		</div>

		<div id="slide_content2" name="slide_content2" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border" style="padding-top:100px; padding-bottom:200px;">
				<h3 class="color1 font2">What Sets Us Apart</h3>
				<h4>Inside Pulse is one the world's largest independent publisher, with 100s of original, exclusive articles published each week</h4>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>

			</div>
			<div class="slide_container_wide fr">
				<h2 class="font2">Tons of content</h2>
				<p>Inside Pulse and its zones produces 100s of original articles per week and 1000s per year</p>
				<h2 class="font2">A Variety of Voices</h2>
				<p>With over 150 unique contributes, Inside Pulse provides a full spectrum of opinions on every subject</p>
				<h2 class="font2">Tons of content</h2>
				<p>Inside Pulse and its zones produces 100s of original articles per week and 1000s per year</p>

			</div>

		</div>

		<div id="slide_content3" name="slide_content4" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Inside Pulse Network</h3>
				<h4>In addition to typical ad units that run across the site, Inside Pulse offers a variety of deeper integrated opportunities for premium advertisers.</h4>
				<p>Site wraps
				Sponsored blogs/content
				In-media adveritisng (audio, video)
				</p>

			</div>
			<div class="slide_container_wide fr">
				dinkerssssssss
			</div>

		</div>

		<div id="slide_content4" name="slide_content3" class="slide_container hide">

			<div class="slide_container_wide fl slide_border">

				<h2 class="font2">Brands</h4>
				<img src="http://media.insidepulse.com/shared/images/v6/templogov6if.jpg" width=120>
				<img src="http://media.insidepulse.com/shared/images/v6/templogov6dhgf.jpg" width=120>
				<img src="http://media.insidepulse.com/shared/images/v6/templogov6_com.png" width=120>

				<h2 class="font2">Zones</h4>
				<img src="" width=120>
			</div>
			<div class="slide_container_narrow fr">
				<h3 class="color1 font2">Zones & Brands</h3>
				<h4>By advertising on Inside Pulse, your brand can reach a dedicated readership of pop culture junkies.</h4>
				<p>Core demographics:
				Male 18-34
				Male 18-49
				</p>

			</div>

		</div>

		<div id="slide_content5" name="slide_content5" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Inside Pulse Portal</h3>


			</div>
			<div class="slide_container_wide fr">
				dinkerssssssss
			</div>

		</div>

		<div id="slide_content6" name="slide_content5" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Contact Us</h3>
				<h4>Reach a high demographic rating of males and 18 and 23 and greatness</h4>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>

			</div>
			<div class="slide_container_wide fr">
				dinkerssssssss
			</div>

		</div>



		<div class="slide_footer">
			<div class="slide_footer_left">
				&copy; <?php echo date("Y"); ?> Inside Pulse
			</div>
			<div id="slide" name="slide6" class="slide_tabs">
				<div id="slide_n" class="tab font2 slidetab fl cp">&laquo; </div>
				<div id="slide_1" class="tab font2 slidetab fl cp tab_on">1</div>
				<div id="slide_2" class="tab font2 slidetab fl cp">2</div>
				<div id="slide_3" class="tab font2 slidetab fl cp">3</div>
				<div id="slide_4" class="tab font2 slidetab fl cp">4</div>
				<div id="slide_5" class="tab font2 slidetab fl cp">5</div>
				<div id="slide_6" class="tab font2 slidetab fl cp">6</div>
				<div id="slide_p" class="tab font2 slidetab fl cp">&raquo; </div>
			</div>
			<div class="slide_footer_right">
				Inside Pulse Advertising Guide &middot; (<a href="#" class="color1">pdf</a>)
			</div>
		</div>

<?php } ?>







<?php if(is_page('contribute')){ ?>
<div class="inner" id="slides" name="slides5">
		<div id="slide_content1" name="slides_content1" class="slide_container">

			<div class="slide_container_narrow fl slide_border" style="padding-top:20px;padding-bottom:360px;">
				<h3 class="color1 font2">Contribute To Inside Pulse</h3>
				<h4>Join our thriving community of writers and readers</h4>

			</div>
			<div class="slide_container_wide fr" style="text-align:center;padding-top:50px;">
				<img src="http://media.insidepulse.com/shared/images/v7/work-office-fun.jpg">
				<h3 class="font2">Anyone can contribute to Inside Pulse from anywhere around the world!</h3>
			</div>

		</div>

		<div id="slide_content2" name="slide_content2" class="slide_container hide">

			<div class="slide_container_wide fl slide_border">
				<img src="http://media.insidepulse.com/shared/images/v7/worldmap.png" style="width:550px;">
			</div>
			<div class="slide_container_narrow fr" style="padding-top:200px;">
				<h3 class="color1 font2">Worldwide Platform</h3>
				<h4>Inside Pulse readers reside primarily in the United States, but contributors and readers come from all over the world!.</h4>
				<p>US accounts for 75% of readers</p>
				<p>Other strong readerships in Canada, UK, Australia, India, Phillipines and Germany</p>

			</div>

		</div>

		<div id="slide_content3" name="slide_content3" class="slide_container hide">
			<div class="slide_container_wide fl slide_border">

				<img src="http://media.insidepulse.com/shared/images/v7/redcarpet.jpg" width=250 style="">
				<h4 class="font2">Press Passes</h4>

				<img src="http://media.insidepulse.com/shared/images/v7/bon-jovi-tickets.jpg" width=250 class="fr" style="">
				<h4 class="font2 fr">Tickets</h4>

				<img src="http://media.insidepulse.com/shared/images/v7/freebies.png" width=250 style="">
				<h4 class="font2">Press Passes</h4>

			</div>
			<div class="slide_container_narrow fr">
				<h3 class="color1 font2">Perks & Freebies!</h3>
				<h4>While Inside Pulse contributors are largely unpaid, there are many opportunities for perks and bonuses.</h4>
				<p>Reviewable media</p>
				<p>Press Screenings</p>
				<p>Free & advanced tickets</p>

			</div>

		</div>

		<div id="slide_content4" name="slide_content4" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Easy & Fun</h3>
				<h4>With a variety of posting tools and editors, Inside Pulse has a low barrier to entry.</h4>
				<p>Banner ad (728x90)
				Rectangle ad (300x250)
				Tower/Skyscraper ad (160x600)
				</p>

			</div>
			<div class="slide_container_wide fr">
				dinkerssssssss
			</div>


		</div>

		<div id="slide_content5" name="slide_content5" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">opportunities</h3>
				<h4>Reach a high demographic rating of males and 18 and 23 and greatness</h4>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>
				<p>yadda yadda dinkers in the advertising stinkers up in that dinkers with the right about of stinkers</p>

			</div>
			<div class="slide_container_wide fr" style="padding-top:50px;">
				<img src="http://media.insidepulse.com/shared/images/v7/chartrising.jpg" style="padding-left:150px;">
				<h3 class="color1 font2" style="padding-left:250px;text-align:right;">Reach a large, diverse audience that continues to grow!</h3>
			</div>

		</div>

		<div id="slide_content6" name="slide_content6" class="slide_container hide">

			<div class="slide_container_narrow fl slide_border">
				<h3 class="color1 font2">Apply Today!</h3>
				<h4>Have a blog? Done some writing in the past? Or want to try it out? Send us an application!</h4>
				<p>Complete the form to the left, or email us directly at contribute@insidepulse.com</p>
				<p>An Inside Pulse editor will response promptly with next steps!</p>


			</div>
			<div class="slide_container_wide fr" style="padding-top:50px;">
				<h2 class="">Join the Inside Pulse Team!</h2>

				Name: <input type="text">
				<br><br>
				Email: <input type="text">
				<br><br>
				Subject Interested in: <input type="text">
				<br><br>





			</div>

		</div>



		<div class="slide_footer">
			<div class="slide_footer_left">
				&copy; <?php echo date("Y"); ?> Inside Pulse
			</div>
			<div id="slide" name="slide6" class="slide_tabs">
				<div id="slide_n" class="tab font2 slidetab fl cp">&laquo; </div>
				<div id="slide_1" class="tab font2 slidetab fl cp tab_on">1</div>
				<div id="slide_2" class="tab font2 slidetab fl cp">2</div>
				<div id="slide_3" class="tab font2 slidetab fl cp">3</div>
				<div id="slide_4" class="tab font2 slidetab fl cp">4</div>
				<div id="slide_5" class="tab font2 slidetab fl cp">5</div>
				<div id="slide_6" class="tab font2 slidetab fl cp">6</div>
				<div id="slide_p" class="tab font2 slidetab fl cp">&raquo; </div>
			</div>
			<div class="slide_footer_right">
				Inside Pulse Contributor &middot; (<a href="#" class="color1">pdf</a>)
			</div>
		</div>

<?php } ?>








<?php endwhile; else: ?>
	<p>Lost? Go back to the <a href="<?php echo get_option('home'); ?>/">home page</a>.</p>
<?php endif; ?>


</div>


<?php include('footer.php'); ?>