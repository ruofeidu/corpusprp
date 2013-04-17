onerror = handleError; 

function handleError(msg, url, line){
	//var message = "本页存在错误。\n";
	//message += "错误：" + msg + "\n";
	//message += "URL：" + url + "\n"; 
	//message += "行号：" + line + "\n"; 
	//message += "点击确定继续";
	//alert(message);
	//return true; 
}

errorBase = new Object(); 	//错误信息
errorText = new Object(); 
errorValue = new Object(); 	//错误代码

errorBase['不限'] = new Array('不限'); 
	errorText['不限'] = new Array('不限'); 
	errorValue['不限'] = 'all'; 

errorBase['书写错误'] = new Array('不限', '汉字', '假名', '其他', '错别字');
	errorValue['书写错误'] = new Array('Hk'); 
	
errorBase['文章格式'] = new Array('文章格式');
	errorValue['文章格式'] = new Array('Ss'); 
	
errorBase['词语错误'] = new Array('动词', '补助动词', '名词', '形式名词', '代词', '复合词', '形容词', '形容动词', '助词', '终助词', '连体词', '感叹词', '接辞', '复合助词', '助动词', '接续词', '副词', '连语'); 
errorValue['词语错误'] = new Array('Ds'); 

	errorText['动词'] = new Array('动词', '词形', '自动词', '被动态', '使役态', '可能态、自发态', '授受动词', 'サ变动词', '他动词', '词性'); 
	errorValue['动词'] = new Array('Ds', 'Ds1', 'Ds2', 'Ds3', 'Ds4', 'Ds5', 'Ds5', 'Ds6', 'Ds7', 'Ds8', 'Ds9'); 
	
	errorText['补助动词'] = new Array('补助动词', '词形', '授受关系补助动词', '时体补助动词', '其他补助动词'); 
	errorValue['补助动词'] = new Array('Hj'); 
	
	errorText['名词'] = new Array('名词', '词形', '词义', '词性'); 
	errorValue['名词'] = new Array('Ms'); 
		
	errorText['形式名词'] = new Array('形式名词', '词形', '词义'); 
	errorValue['形式名词'] = new Array('Km'); 
	
	errorText['复合词'] = new Array('复合词', '词形', '词义', '时态复合动词', '词性'); 
	errorValue['复合词'] = new Array('Fg'); 
	
	errorText['代词'] = new Array('代词', '词形', '词义'); 
	errorValue['代词'] = new Array('Dm'); 
	
	errorText['形容词'] = new Array('形容词', '词形', '词义', '词性'); 
	errorValue['形容词'] = new Array('Ky'); 
	
	errorText['形容动词'] = new Array('形容动词', '词形', '词义'); 
	errorValue['形容动词'] = new Array('Ky'); 
	
	errorText['助词'] = new Array('助词', '格助词', '接续助词', '提示助词'); 
	errorValue['助词'] = new Array('Js'); 
	
	errorText['终助词'] = new Array('终助词语义和形式的使用错误'); 
	errorValue['终助词'] = new Array('Syj'); 
	
	errorText['连体词'] = new Array('连体词', '词形', '词义'); 
	errorValue['连体词'] = new Array('Rt'); 
	
	errorText['感叹词'] = new Array('感叹词'); 
	errorValue['感叹词'] = new Array('Gd'); 
	
	errorText['接辞'] = new Array('接辞', '词形', '词义'); 
	errorValue['接辞'] = new Array('Sj'); 
	
	errorText['复合助词'] = new Array('复合助词', '词形', '词义'); 
	errorValue['复合助词'] = new Array('Fk'); 
	
	errorText['助动词'] = new Array('助动词', '词形', '词义'); 
	errorValue['助动词'] = new Array('Jd'); 
	
	errorText['接续词'] = new Array('接续词', '词形', '词义'); 
	errorValue['接续词'] = new Array('St'); 
	
	errorText['连语'] = new Array('连语', '词形', '词义'); 
	errorValue['连语'] = new Array('Lg'); 
	
	errorText['副词'] = new Array('副词', '词形', '词义', '词性'); 
	errorValue['副词'] = new Array('F'); 
	
errorBase['词组错误'] = new Array('不限', '动/动搭配', '副/动搭配', '名/动搭配', '名/名搭配', '形/名搭配', '形动/名搭配', '形动/动搭配', '形/动搭配', '固定词组', '名/形搭配'); 
errorValue['词组错误'] = 'R';

errorBase['词法错误'] = new Array('不限', '重复', '欠缺', '语体', '语序', '时态'); 
errorValue['词法错误'] = 'W';

errorBase['句子错误'] = new Array('不限', '重复、多余', '欠缺', '时态', '标点', '语序', '句子置换', '文体', '肯定与否定'); 
errorValue['句子错误'] = 'B';

$(document).ready(function(){
	$(".sError").hide(); 
	$(".SEO").hide(); 
	//第一层
	$("#baseError").change(function(){
		next = $("#nextError")[0];
		base = $("#baseError")[0];
		temp = $("#tempError")[0]; 
		real = $("#realError")[0]; 
		error = $("#error")[0]; 
		if (base.selectedIndex == 0){
			$(".sError").hide();
			error.value = ""; 
			return; 
		}
		bv = base.value;
		next.length = 1;
		for (i = 0; i < errorBase[bv].length; i++)
		{
			next.options[i] = new Option();
			next.options[i].text = errorBase[bv][i];
			next.options[i].value = errorBase[bv][i];
		}
		$(".sError").hide(); 
		$("#nextError").show("normal"); 
		$("#nextError").change(); 
		$("#error")[0].value = errorValue[bv];
	}); 
	
	//第二层
	$("#nextError").change(function(){
		next = $("#nextError")[0];
		base = $("#baseError")[0];
		temp = $("#tempError")[0]; 
		real = $("#realError")[0]; 
		error = $("#error")[0]; 
		
		bv = base.value;
		cv = next.value;
		temp.length = 1;

		if (cv == '不限') {
			error.value = errorValue[bv];
			return;
		}
		if (typeof(errorText[cv]) == 'undefined') {
			temp.options[0] = new Option();
			temp.options[0].text = cv;
			temp.options[0].value = errorValue[bv] + next.selectedIndex;
			error.value = errorValue[bv] + next.selectedIndex;
			return;
		}
		
		for (i = 0; i < errorText[cv].length; i++) {
			temp.options[i] = new Option();
			temp.options[i].text = errorText[cv][i];
			if (i == 0)
				temp.options[i].value = errorValue[cv][0];
			else
				temp.options[i].value = errorValue[cv][0] + i;
		}
		$("#realError").hide(); 
		$("#tempError").hide(); 
		if (errorText[cv].length > 1) { 
			$("#tempError").show("normal"); 
			$("#realError").show("normal"); 	
		}
		error.value = errorValue[cv][0];
		if (bv == '词语错误') $("#tempError").change();
	}); 
	
	//第三层
	$("#tempError").change(function(){
		next = $("#nextError")[0];
		base = $("#baseError")[0];
		temp = $("#tempError")[0]; 
		real = $("#realError")[0]; 
		error = $("#error")[0]; 
		
		var cv, i;
		cv = '词法错误';
		real.length = 1;
		for (i = 0; i < errorBase[cv].length; i++) {
			real.options[i] = new Option();
			real.options[i].text = errorBase[cv][i];
			if (i == 0) {
				real.options[i].value = errorValue[cv];
			} else {
				real.options[i].value = errorValue[cv] + i;
			}
		}	
		
		if (base.value != '词语错误') return; 
		$('#realError').change(); 
	}); 
	
	//第四层
	$("#realError").change(function(){
		next = $("#nextError")[0];
		base = $("#baseError")[0];
		temp = $("#tempError")[0]; 
		real = $("#realError")[0]; 
		error = $("#error")[0]; 
		
		if (real.selectedIndex != 0){
			error.value = temp.value + '_' + real.value; 
		} else {
			error.value = temp.value;
		}
	}); 
}); 