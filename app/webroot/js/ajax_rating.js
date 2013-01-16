$(document).ready(function(){
	var replay_id;
	
	$(".rate-up-link").click(function(){
		submitRating(this, 1);
		
		return false;
	});
	
	$(".rate-down-link").click(function(){
		submitRating(this, 0);
		
		return false;
	});
});

function submitRating(elem, v){
	replay_id = $(elem).parents("div.replay-container:first").find(".replay-id").html();
	loader = $(elem).parents("div.replay-container:first").find(".ajax-loader");
	loader.show();
	
	rating_value = $(elem).parents("div.replay-container:first").find(".rating-value");
		
	$.ajax({
	   type: "POST",
	   url: "/replayRatings/submitRating",
	   data: "v="+v+"&x="+replay_id,
	   success: function(msg){
	     loader.hide();
	     if(msg != "false"){
	     	rating_value.html(msg);
	     }
	   }
	});
}