$(document).ready(function(){
	$(".comment .comment-replay-link").click(function(){
		p = $(this).parents("div.comment-content:first");
		tinyMCE.execCommand('mceRemoveControl', false, 'ReplayCommentComment');
		p.after($("#ReplayCommentForm"));
		tinyMCE.init(mce_config);
		$("#ReplayCommentComment_tbl").css("width", "auto");
		$("#ReplayCommentForm #form-row-cancel-reply").show();
		id = $(this).parents("div.comment-content:first").find("div.comment-id").html();
		$("#ReplayCommentParentId").val(id);
		
		return false;
	});
	$("#ReplayCommentForm #form-row-cancel-reply a").click(function(){
		
		tinyMCE.execCommand('mceRemoveControl', false, 'ReplayCommentComment');
		$(".replay-view:first").after($("#ReplayCommentForm"));
		tinyMCE.init(mce_config);		
		$("#ReplayCommentForm #form-row-cancel-reply").hide();
		$("#ReplayCommentParentId").val(0);
		
		return false;
	});
});
