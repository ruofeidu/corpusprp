$(document).ready(function(){

var advanced = false; 

$("#article").select(function(){
	var str = window.getSelection().toString();
	var n = str.length; 
	var comma = 0; var p1 = 0; var p2 = 0; 
	for (var i = 0; i < n; ++i) if (str[i] == ',') {
		if (comma == 0) p1 = i; else p2 = i; 
		++comma;
	}
	if (str[0] == '[' && str[n-1] == ']' && comma == 2) {
		advanced = true; 
		$("#before").val(str.substr(1,p1-1));	
		$("#after").val(str.substr(p1+1,p2-p1-1));
		$("#error").val(str.substr(p2+1,n-p2-2));
	} else {
		advanced = false; 
		$("#before").val(str);
		$("#after").val(""); 
		$("#error").val(""); 
	}	
}); 

$("encode").click(function(){
	
	
}); 


}); 