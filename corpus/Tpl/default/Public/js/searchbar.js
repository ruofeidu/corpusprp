onerror = handleError; 

function handleError(msg, url, line){
	var message = "��ҳ���ڴ���\n";
	message += "����" + msg + "\n";
	message += "URL��" + url + "\n"; 
	message += "�кţ�" + line + "\n"; 
	message += "���ȷ������";
	//alert(message);
	return true; 
}
var searchMode = 1; 

$(document).ready(function(){
$("#errorSearch").hide(); 
$("#infoView").hide();
$("#aboutView").hide();
$("#mysubmit").hide();

$("#orgTab").click(function(){
	$("#aboutView").hide();
	$("#infoView").hide();
	$("#errorSearch").hide("normal"); 
	searchMode = 1; 
}); 

$("#errorTab").click(function(){
	$("#aboutView").hide();
	$("#infoView").hide();
	$("#errorSearch").show("normal"); 
	searchMode = 2; 
});

$("#infoTab").click(function(){
	$("#infoView").hide();
	$("#errorSearch").hide(); 
	$("#aboutView").hide();

	$("#infoView").show("normal");
});

$("#keywords").keydown(function(event){
	if (event.which == 13) {
		$("#submit").click(); 
		$("#keywords").focus(); 
	}
});

$("#uid").keydown(function(event){
	if (event.which == 13) {
		$("#submit").click(); 
		$("#keywords").focus(); 
	}
});

$("#aboutTab").click(function(){
	$("#infoView").hide();
	$("#errorSearch").hide(); 
	$("#aboutView").hide();

	$("#aboutView").show("normal");
});

$(".submit").click(function(){
	var dl = 0; 
	if (this.id == "dlbutton") {
		dl = 1;
		//alert("����");
		$("#resultList").html("&nbsp;&nbsp;&nbsp;ϵͳ����Ϊ������Excel�ļ�...�������ĵȴ�..."); 
	} else {
		//alert("����");
		$("#resultList").html("&nbsp;&nbsp;&nbsp;ϵͳ����Ϊ��������...�������ĵȴ�..."); 
	}
	$('#download')[0].value = dl; 
	var kw = $('#keywords')[0].value;
	var lkw = $('#lastkeywords')[0].value;
	var sc = $('#school')[0].value; 
	var gd = $('#gender')[0].value; 
	var tmin = $('#studytime')[0].value; 
	var tmax = parseInt(tmin) + 150; 

	var fl = $('#firstlang')[0].value; 
	var yr = $('#year')[0].value; 
	var ud = $('#uid')[0].value;  
	var er = $('#error')[0].value; 
	var sp = $('#samepage')[0].value; 
	if (sp == 1) pg = $('#page')[0].value; else {
		pg = 1; 
		$('#page')[0].value = 1; 
	}	
	$('#lastkeywords')[0].value = kw; 
	var ln = $('#listnum')[0].value;
		
	if (dl == 0){
		if (searchMode == 1){
			if (tmin == 0){
				$("#resultList").load("__URL__/search" , { keywords: kw, school: sc, gender: gd, firstlang:fl, year:yr, uid:ud, page:pg, listnum:ln, download:dl} );
			} else {
				$("#resultList").load("__URL__/search" , { keywords: kw, school: sc, gender: gd, timemin: tmin, timemax: tmax, firstlang:fl, year:yr, uid:ud, page:pg, listnum:ln, download:dl} );
			}
		} else { 
			if (tmin == 0){
				$("#resultList").load("__URL__/search" , { keywords: kw, school: sc, gender: gd, firstlang:fl, year:yr, uid:ud, error:er, page:pg, listnum:ln, download:dl} );
			} else {
				$("#resultList").load("__URL__/search" , { keywords: kw, school: sc, gender: gd, timemin: tmin, timemax: tmax, firstlang:fl, year:yr, uid:ud, error:er, page:pg, listnum:ln, download:dl} );
			}
		}
	} else {
			//$("#myForm").submit();
			//alert("�Ѿ��ύ");
		$("#mysubmit").click();
		//if (searchMode == 1){
		//	$.ajax({ type: "POST", url: "__URL__/search", data:  { keywords: kw, school: sc, gender: gd, studytime: st, firstlang:fl, year:yr, uid:ud, page:pg, listnum:ln, download:dl},  success: function(str_response) {  var obj = window.open("about:blank");  obj.document.write(str_response);  } });  
		//} else { 
		//	$.ajax({  type: "POST", url: "__URL__/search",  data: { keywords: kw, school: sc, gender: gd, studytime: st, firstlang:fl, year:yr, uid:ud, error:er, page:pg, listnum:ln, download:dl},  success: function(str_response) {  var obj = window.open("about:blank");  obj.document.write(str_response);  }  });  
		//}
	}
	$('#samepage')[0].value = 0; 
	if (this.id == "dlbutton ") {
		$("#resultList").html("&nbsp;&nbsp;&nbsp;ϵͳ�Ѿ�Ϊ��������Excel�ļ����뵽��������Ŀ¼�в鿴��"); 
	} 
}); 
}); 