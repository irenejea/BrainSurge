
$(document).ready(function(){
	$("#fn").on("input", function(){
		var input=$(this);
		var first=input.val();
		if(first){
			input.removeClass("invalid").addClass("valid");
		}
		else{
			input.removeClass("valid").addClass("invalid");
		}
	});
	$("#ln").on("input", function(){
		var input=$(this);
		var last=input.val();
		if(last){
			input.removeClass("invalid").addClass("valid");
		}
		else{
			input.removeClass("valid").addClass("invalid");
		}
	});
	$("#user").on("input", function(){
		var input=$(this);
		var id=input.val();
		if(id){
			input.removeClass("invalid").addClass("valid");
		}
		else{
			input.removeClass("valid").addClass("invalid");
		}
	});
	$("#pass").on("input", function(){
		var input=$(this);
		var pw=input.val();
		if(pw){
			input.removeClass("invalid").addClass("valid");
		}
		else{
			input.removeClass("valid").addClass("invalid");
		}
	});
	$("#id").on("input", function(){
		var input=$(this);
		var id=input.val();
		if(id){
			input.removeClass("invalid").addClass("valid");
		}
		else{
			input.removeClass("valid").addClass("invalid");
		}
	});
	$("#pw").on("input", function(){
		var input=$(this);
		var pw=input.val();
		if(pw){
			input.removeClass("invalid").addClass("valid");
		}
		else{
			input.removeClass("valid").addClass("invalid");
		}
	});
	
	$("#submitR").click(function(event){
		var go=true;
		var form=$("#formR").serializeArray();
		for(var input in form){
			var pass=$("#"+form[3]['name']);
			var val=$("#"+form[input]['name']);
			var valid=val.hasClass("valid");
			var error = $("span", pass.parent());	
			if(!valid){
				error.removeClass("error").addClass("error_show")
				go=false;
			}
			else{
				error.removeClass("error_show").addClass("error");
			}
		}
		if(!go){
			event.preventDefault();
		}
	});
	$("#submitL").click(function(event){
		var go=true;
		var form=$("#formL").serializeArray();
		for(var input in form){
			var user=$("#"+form[0]['name']);
			var validUser=user.hasClass("valid");
			var pass=$("#"+form[1]['name']);
			var validPass=pass.hasClass("valid");
			var error = $("span", pass.parent());
			if(!validUser || !validPass){
				error.removeClass("error").addClass("error_show");
				go=false;
			}
			else{
				error.removeClass("error_show").addClass("error");
			}
		}
		if(!go){
			event.preventDefault();
		}
	});
})

