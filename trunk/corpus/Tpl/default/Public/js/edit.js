(function($) {
$.fn.extend({
	insertContent: function(myValue, t) {
		var $t = $(this)[0];
		if (document.selection) { //ie
			this.focus();
			var sel = document.selection.createRange();
			sel.text = myValue;
			this.focus();
			sel.moveStart('character', -l);
			var wee = sel.text.length;
			if (arguments.length == 2) {
				var l = $t.value.length;
				sel.moveEnd("character", wee + t);
				t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);

				sel.select();
			}
		} else if ($t.selectionStart || $t.selectionStart == '0') {
			var startPos = $t.selectionStart;
			var endPos = $t.selectionEnd;
			var scrollTop = $t.scrollTop;
			$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
			this.focus();
			$t.selectionStart = startPos + myValue.length;
			$t.selectionEnd = startPos + myValue.length;
			$t.scrollTop = scrollTop;
			if (arguments.length == 2) {
				$t.setSelectionRange(startPos - t, $t.selectionEnd + t);
				this.focus();
			}
		}
		else {
			this.value += myValue;
			this.focus();
		}
	}
})
})(jQuery);

$(document).ready(function(){

var advanced = false; 

$("#article").select(function(){
	var str; 
	
	if (window.getSelection){
		str = window.getSelection();
    } else if (document.getSelection) {
		str = document.getSelection();
		foundIn = 'document.getSelection()';
	} else if(document.selection) {
		str = document.selection.createRange().text;
		foundIn = 'document.selection.createRange()';
    } else {
        str = ""; 
	}

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

$("#encode").click(function(){
	$("#article").insertContent( "[" + $("#before").val() + "," + $("#after").val() + "," + $("#error").val() + "]" );   
}); 
	
}); 