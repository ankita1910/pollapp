$(document).ready(function() {

	/* Click binding handlers */

	$(".header .add-qs").click(function() {
		$(".add-qs-popup").show();
	});

	$(".header .user-name").click(function() {
		$(".addons-container").show();
	});

	$(".popup-heading .__close").click(function() {
		$(".add-qs-popup").hide();
	});

	$("#ask-qs-action").click(addPollQuestion);

	$("#user_qs").focus(function() {
		if($(this).html().trim() == $(this).attr("placeholder")) {
			$(this).empty();
		}
	});

});

addPollQuestion = function() {
	var question_text = $("#user_qs").html().trim();
	var option1 = $("#option1_content").val().trim();
	var option2 =  $("#option2_content").val().trim();
	var option3 =  $("#option3_content").val().trim();
	var option4 =  $("#option4_content").val().trim();
	var category = "Default";
	if($(".category-node").hasClass(".active-category")) {
		category = $(".active-category").html().trim();
	}
	$(".add-qs-popup").hide();
	$.ajax({
		type: "post",
		url: "../insite/poll-apis.php",
		dataType: "text",
		data: {
			cmd: "INSERTQUESTION",
			question_text: question_text,
			option1: option1,
			option2: option2,
			option3: option3,
			option4: option4,
			category: category
		},
		success: function(response) {
			console.log(response);
			location.reload(true);
			alert(response);
		},
		error: function(error) {
			console.log(error);
			alert(error);
		}
	});
};

selectCategory = function(element) {
	
	$(".category-node").removeClass("active-category");
	$(element).addClass("active-category");
}
