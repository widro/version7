<?php

//zone pages
if(is_page('home')||is_page('pulsecasts')||is_page('wrestling')||is_page('movies')||is_page('tv')||is_page('sports')||is_page('insidefights')||is_page('inside-fights')||is_page('comics-nexus')||is_page('comics')||is_page('music')||is_page('commercials')||is_page('games')||is_page('figures')){
//	include('page_zone.php');
	include('loader.php');
}

//video pages
elseif(is_page('dell2')||is_page('new-video')||is_page('silverado2')||is_page('the-ride-season-3-the-game-ifeadi-odenigbo')){
	include('page_alphabird.php');
}


//dvd-release-dates
elseif(is_page('dvd-release-dates')||is_page('upcoming-theatrical-movie-release-calendar')){
	include('page_table.php');
}

//dvd archive+
elseif(is_page('dvd-review-archive')){
	include('page_masterarchive.php');
}

//comments
elseif(is_page('more-comments')){
	include('page_comments.php');
}

//dvd-release-dates
elseif(is_page('forum')||is_page('forums')){
	include('page_full.php');
}

elseif(strpos($_SERVER['REQUEST_URI'], "forums")){
	if(is_user_logged_in()){
		include('page_full.php');
	}
	else{
		echo "You need to be logged into the dashboard! <a href=\"/wp-login.php?redirect_to=%2Fforums%2F&reauth=1\">click here to go to the login page</a>";
		exit();
	}
}

//slides
elseif(is_page('advertising')){
	include('page_slide.php');
}
elseif(is_page('contribute')){
	include('page_slide.php');
}
elseif(is_page('about')){
	include('page_slide.php');
}
elseif(is_page('media-kit')){
	include('page_slide.php');
}
elseif(is_page('tv-show-madness')){
	include('page_full.php');
}
elseif(is_page('tv-show-madness-brackets')){
	include('page_full.php');
}
elseif(is_page('2013-inside-pulse-best-television-show-couple-tournament')){
	include('page_full.php');
}
elseif(is_page('2014-inside-pulse-best-tv-show-tournament-bracket')){
	include('page_full.php');
}


else{
	include('page_default.php');
}



?>

