<?php get_header(); ?>
	<div class="content_left">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

		<div class="article_headline color1 bold">
			<?php the_title(); ?>
		</div>
		<div class="article_body">
				<!-- content -->
				<?php the_content(''); ?>
				<!-- content end -->


<?php
if(is_page('staff')){

	$getallauthors = getinsiders('');

	foreach($getallauthors as $eachauthorarray){
		$thisdisplay_name = $eachauthorarray['display_name'];
		$thisuser_nicename = $eachauthorarray['user_nicename'];
		$thisavatar120 = $eachauthorarray['avatar120'];

		if($thisavatar120==""){
			$thisavatar120 = defaultimage("avatar", "topstory120x120");
		}
		echo "
			<div style=\"width:130px; float:left;margin-bottom:20px; overflow:hidden;\">
			<a href=\"/insider/$thisuser_nicename/\" title=\"Widro\"><img src=\"$thisavatar120\" style=\"width:120px;height:120px;\" align=left></a>
			<br>
			<a href=\"/insider/$thisuser_nicename/\" title=\"Widro\">$thisdisplay_name</a>
			</div>

		";
	}
?>






<?php
}
elseif(is_page('title-history')){
	$titlecode = $_GET['titlecode'];

	if($titlecode){
		/* first query  */
		$sql= "
		SELECT DATE_FORMAT(date, '%m.%d.%y') as date2, winner, loser, title
		FROM titles, titlecode
		WHERE titlecode.titlecode = titles.titlecode
		AND titles.titlecode = $titlecode
		ORDER BY date ASC
		";

		$result = mysql_query($sql) or die("Error displaying titles article.");

		while ($row = mysql_fetch_array($result)){
			$title= $row['title'];
			$winner= $row['winner'];
			$winner = stripslashes ($winner);
			$loser= $row['loser'];
			$loser = stripslashes ($loser);
			$date= $row['date2'];
			$display_block .= "<tr><td class=article align=center>$date</td><td class=article align=center>$winner</td><td class=article align=center>$loser</td></tr>
			";
		}

		$yup = "
			<span class=headline>$title</span><br>
			<table border=1 cellspacing=1 bordercolor=white cellpadding=5 width=400>
			<tr><td class=article align=center><b>Date</b></td><td class=article align=center><b>Champion</b></td><td class=article align=center><b>Defeated</b></td></tr>
			$display_block
			</table><br><br>
			";
		$displayText .= $yup;
	}









	$displayText .= "
<h2>Active Titles</h2>
<p>Titles that are still actively defended</p>

<h3>WWE</h3>
<a class=wrestling href=/title-history/?titlecode=1>WWE Title</a> |
<a class=wrestling href=/title-history/?titlecode=7>World Title</a> |
<a class=wrestling href=/title-history/?titlecode=8>WWE United States Title</a> |
<a class=wrestling href=/title-history/?titlecode=2>WWE Intercontinental Title</a> |
<a class=wrestling href=/title-history/?titlecode=4>World Tag Team Titles</a> |
<a class=wrestling href=/title-history/?titlecode=16>WWE Woman's Title</a> |
<a class=wrestling href=/title-history/?titlecode=17>WWE Tag Team Titles</a> |
<a class=wrestling href=/title-history/?titlecode=26>WWE Diva's Championship</a> |

<h3>TNA</h3>
<a class=wrestling href=/title-history/?titlecode=18>TNA World Title</a> |
<a class=wrestling href=/title-history/?titlecode=19>TNA X Division Title</a> |
<a class=wrestling href=/title-history/?titlecode=20>TNA Tag Team Titles</a> |
<a class=wrestling href=/title-history/?titlecode=21>TNA Knockout Title</a> |
<a class=wrestling href=/title-history/?titlecode=27>TNA Global Title</a> |
<a class=wrestling href=/title-history/?titlecode=28>TNA Knockout Tag Team Titles</a> |


<h3>NWA</h3>
<a class=wrestling href=/title-history/?titlecode=24>NWA World Title</a> |
<a class=wrestling href=/title-history/?titlecode=33>NWA Tag Team</a> |


<h3>ROH</h3>
<a class=wrestling href=/title-history/?titlecode=22>ROH World Title</a> |
<a class=wrestling href=/title-history/?titlecode=23>ROH Tag Team Titles</a> |
<a class=wrestling href=/title-history/?titlecode=29>ROH Television Title</a> |

<h3>Dragons Gate</h3>
<a class=wrestling href=/title-history/?titlecode=30>Open the Freedom Gate</a> |
<a class=wrestling href=/title-history/?titlecode=31>Open the United Gate</a> |

<h2>Inactive Titles</h2>
<p>Titles which have been retired or unified</p>

<h3>WWE</h3>
<a class=wrestling href=/title-history/?titlecode=3>WWE European Title</a> |
<a class=wrestling href=/title-history/?titlecode=5>WWE Light Heavyweight Title</a> |
<a class=wrestling href=/title-history/?titlecode=6>WWE Hardcore Title</a> |
<a class=wrestling href=/title-history/?titlecode=12>WWE Cruiserweight Title</a> |

<h3>WCW</h3>
<a class=wrestling href=/title-history/?titlecode=32>WCW World Title</a> |
<a class=wrestling href=/title-history/?titlecode=9>WCW Television Title</a> |
<a class=wrestling href=/title-history/?titlecode=10>WCW Tag Team Titles</a> |
<a class=wrestling href=/title-history/?titlecode=11>WCW Hardcore Title</a> |

<h3>ECW</h3>
<a class=wrestling href=/title-history/?titlecode=13>ECW World Title</a> |
<a class=wrestling href=/title-history/?titlecode=14>ECW Television Title</a> |
<a class=wrestling href=/title-history/?titlecode=15>ECW Tag Team Titles</a> |

<h3>ROH</h3>
<a class=wrestling href=/title-history/?titlecode=25>ROH Pure Wrestling Title</a> |


	";
	echo $displayText;

}

elseif(is_page('top-100')){

	$domain = "http://" . $_SERVER['HTTP_HOST'] . "";

	$sqlgetauthors1 = "
	SELECT wp.post_title, wp.guid, wpm.meta_value
	FROM wp_posts wp, wp_term_relationships wtr, wp_postmeta wpm
	WHERE wtr.term_taxonomy_id =76
	and wtr.object_id = wp.ID
	and wpm.post_id = wp.ID
	and wpm.meta_key = 'topstory120x120'
	ORDER by post_date DESC
	";

	$sqlgetauthors = "
	SELECT wp.ID, wp.post_title, wp.guid
	FROM wp_posts wp, wp_term_relationships wtr
	WHERE wtr.term_taxonomy_id =76
	and wtr.object_id = wp.ID
	ORDER by post_date DESC
	";

	//echo $sqlgetauthors;

	$resultgetauthors = mysql_query($sqlgetauthors) or die($sqlgetauthors);

	while($rowgetauthors = mysql_fetch_array($resultgetauthors)){
		$thisid = $rowgetauthors['ID'];
		//echo $thisid;
			$sqlgetauthors2 = "
				SELECT wpm.meta_value
				FROM wp_postmeta wpm
				WHERE wpm.post_id = '$thisid'
				and wpm.meta_key = 'topstory120x120'
				LIMIT 1
				";

			$resultgetauthors2 = mysql_query($sqlgetauthors2) or die($sqlgetauthors2);
			$isit = mysql_num_rows($resultgetauthors2);
			//while($rowgetauthors2 = mysql_fetch_array($resultgetauthors2)){
			if($isit>0){
				while($rowgetauthors2 = mysql_fetch_array($resultgetauthors2)){
					$meta_value = $rowgetauthors2['meta_value'];
					//echo $meta_value;
					//echo "<br>";
				}
			}
			else{
				$meta_value = "http://www.insidepulsemedia.com/generaluse/120x120pulsewrestling.gif";

			}


		$post_title = $rowgetauthors['post_title'];
		$post_title = str_replace('"', '', $post_title);
		$post_title = str_replace("'", "", $post_title);


		$guid = $rowgetauthors['guid'];
		//$meta_value = $rowgetauthors['meta_value'];
		$authorslist .=  "

		<a href=/?p=".$thisid." title='".$post_title."'><img src=".$meta_value." border=0 width=120></a>

		";
	}
	echo $authorslist;
}








?>
		</div>



<?php endwhile; else: ?>
	<p>Lost? Go back to the <a href="<?php echo get_option('home'); ?>/">home page</a>.</p>
<?php endif; ?>


<?php include('sidebar.php'); ?>




<?php include('footer.php'); ?>