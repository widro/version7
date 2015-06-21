function age_check(){

	var is_18 = false;

	var d = new Date();
	var curr_month = d.getMonth()+1;
	var curr_day = d.getDate();
	var curr_year = d.getFullYear();

	var ageform_month_val = $("#ageform_month").val();
	var ageform_day_val = $("#ageform_day").val();
	var ageform_year_val = $("#ageform_year").val();

	if((ageform_month_val=="")||(ageform_day_val=="")||(ageform_year_val=="")){
		$("#ageform_error").html("Please fill out the full form")
		return;
	}

	if(curr_year-ageform_year_val>18){
		is_18 = true;
	}
	else if(curr_year-ageform_year_val==18){
		if(ageform_month_val<curr_month){
			is_18 = true;
		}
		else if(ageform_month_val==curr_month){
			if(ageform_day_val<=curr_day){
				is_18 = true;
			}
		}
	}

	if(is_18){
		$("#ageform").hide();
		$(".article_body").show();
	}
	else{
		window.location = "/";
	}


}

function theRotator() {
	//Set the opacity of all images to 0
	$('.topstory_left li').css({opacity: 0.0});
	$('.topstory_right li').css({opacity: 0.0});

	//Get the first image and display it (gets set to full opacity)
	$('.topstory_left li:first').css({opacity: 1.0});
	$('.topstory_right li:first').css({opacity: 1.0});

	//Call the rotator function to run the slideshow, 6000 = change to next image after 6 seconds
	setInterval('rotate("")',5000);

}

function rotate(direction) {
	var loopvalue = 4;
	
	//Get the first image

	var current = ($('.topstory_left li.show')?  $('.topstory_left li.show') : $('.topstory_left li:first'));
	var current2 = ($('.topstory_right li.show')?  $('.topstory_right li.show') : $('.topstory_right li:first'));

	var current5 = ($('.container_row_topstory_right_thumbnails li.show')?  $('.container_row_topstory_right_thumbnails li.show') : $('.container_row_topstory_right_thumbnails li:first'));

	//Get next image, when it reaches the end, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('.topstory_left li:first') :current.next()) : $('.topstory_left li:first'));
	var next2 = ((current2.next().length) ? ((current2.next().hasClass('show')) ? $('.topstory_right li:first') :current2.next()) : $('.topstory_right li:first'));

	var next5 = ((current5.next().length) ? ((current5.next().hasClass('show')) ? $('.container_row_topstory_right_thumbnails li:first') :current5.next()) : $('.container_row_topstory_right_thumbnails li:first'));

	//Get next image, when it reaches the end, rotate it back to the first image
	var previous = ((current.prev().length) ? ((current.prev().hasClass('show')) ? $('.topstory_left li:last') :current.prev()) : $('.topstory_left li:last'));
	var previous2 = ((current2.prev().length) ? ((current2.prev().hasClass('show')) ? $('.topstory_right li:last') :current2.prev()) : $('.topstory_right li:last'));

	var previous5 = ((current5.prev().length) ? ((current5.prev().hasClass('show')) ? $('.container_row_topstory_right_thumbnails li:last') :current5.prev()) : $('.container_row_topstory_right_thumbnails li:last'));

	//Set the fade in effect for the next image, the show class has higher z-index
	if(direction=="backwards"){
		previous.css({opacity: 0.0})
		.addClass('show')
		.animate({opacity: 1.0}, 1000);

		previous2.css({opacity: 0.0})
		.addClass('show')
		.animate({opacity: 1.0}, 1000);
	}
	else{

		next.css({opacity: 0.0})
		.addClass('show')
		.animate({opacity: 1.0}, 1000);

		next2.css({opacity: 0.0})
		.addClass('show')
		.animate({opacity: 1.0}, 1000);
	}

	//Hide the current image
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');

	current2.animate({opacity: 0.0}, 1000)
	.removeClass('show');


	if(currentvalue==1){
		prevvalue = loopvalue;
		nextvalue = currentvalue+1;
	}
	else if(currentvalue==loopvalue){
		nextvalue = 1;
		prevvalue = currentvalue-1;
	}
	else{
		prevvalue = currentvalue-1;
		nextvalue = currentvalue+1;
	}
	var currentthumb = "#topstorythumb_" + currentvalue;
	var prevthumb = "#topstorythumb_" + prevvalue;
	var nextthumb = "#topstorythumb_" + nextvalue;

	
	if(direction=="backwards"){
		$(currentthumb).removeClass("on");

		$(prevthumb).addClass("on");

		if(currentvalue==1){
			currentvalue = loopvalue;
		}
		else{
			currentvalue--;
		}

	}
	else{
		$(currentthumb).removeClass("on");
		$(nextthumb).addClass("on");

		if(currentvalue==loopvalue){
			currentvalue = 1;
		}
		else{
			currentvalue++;
		}

	}

	

};
jQuery(document).ready(function($){ //fire on DOM ready

	var currentvalue = 1;
	var loopvalue = 4;
	
	
	
	$("#article_authorbox_show").click(function(){
		$("#article_authorbox_description1").hide();
		$("#article_authorbox_description2").show();
	});
	
	$("#article_authorbox_hide").click(function(){
		$("#article_authorbox_description1").show();
		$("#article_authorbox_description2").hide();
	});
	
	$(".tab").click(function(){
		var totalid = $(this).closest('div').parent().attr("id");
		var totalidlength = totalid.length;

		var totaltabs = parseInt($(this).closest('div').parent().attr("name").substr(totalidlength,1));

		var thistab_text = $(this).attr("id").substr(totalidlength+1,1);
		var thistab = parseInt($(this).attr("id").substr(totalidlength+1,1));
		$(this).closest('div').parent().removeClass(totalid+'_tabs').removeClass(totalid+'_tabs1').removeClass(totalid+'_tabs2').removeClass(totalid+'_tabs3').addClass(totalid+'_tabs'+thistab);

		if((thistab_text=="n")||(thistab_text=="p")){
			for(i=0;i<totaltabs;i++){
				var i1 = i+1;
				var tabid = "#" + totalid + "_" + i1;
				if($(tabid).hasClass('tab_on')){
					if(thistab_text=="p"){
						if(i1==totaltabs){
							thistab = 1;
						}
						else{
							thistab = i1+1;
						}
					}

					if(thistab_text=="n"){
						if(i1==1){
							thistab = totaltabs;
						}
						else{
							thistab = i1-1;
						}
					}
				}
			}
		}


		for(i=0;i<totaltabs;i++){
			var i1 = i+1;
			var contentid = "#" + totalid + "_content" + i1;
			var tabid = "#" + totalid + "_" + i1;
			$(tabid).removeClass('tab_on');
			if(i1==thistab){
				$(contentid).show();
				$(tabid).addClass('tab_on');
			}
			else{
				$(contentid).hide();
			}
		}

	});

	//arrows
	$("#topstoryarrowleft").click(function(){
		//currentvalue--;
		rotate("backwards");
	});
	$("#topstoryarrowright").click(function(){
		//alert('right');
		//currentvalue++;
		rotate("");
	});

	//Load the slideshow
	if($(".topstory")){
		theRotator();
	}

});



var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function jsddm_open()
{  jsddm_canceltimer();
   jsddm_close();
   ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

function jsddm_close()
{  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function jsddm_timer()
{  closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{  if(closetimer)
   {  window.clearTimeout(closetimer);
      closetimer = null;}}

$(document).ready(function()
{  $('#jsddm > li').bind('mouseover', jsddm_open)
   $('#jsddm > li').bind('mouseout',  jsddm_timer)});

document.onclick = jsddm_close;
