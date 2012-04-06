onerror = handleError; 

function handleError(msg, url, line){
	return true; 
}

errorBase = new Object(); 	//错误信息
errorText = new Object(); 
errorValue = new Object(); 	//错误代码

errorBase['指定なし'] = new Array('指定なし'); 
	errorText['指定なし'] = new Array('指定なし'); 
	errorValue['指定なし'] = 'all'; 

errorBase['表記の誤用'] = new Array('指定なし', '漢字', '仮名', 'その他', '誤字');
	errorValue['表記の誤用'] = new Array('Hk'); 
	
errorBase['文章構成の誤り'] = new Array('文章構成の誤り');
	errorValue['文章構成の誤り'] = new Array('Ss'); 
	
errorBase['語の誤り'] = new Array('動詞', '補助動詞', '名詞', '形式名詞', '代名詞', '複合語', '形容詞', '形容動詞', '助詞', '終助詞', '連体詞', '感嘆詞', '接辞', '複合助詞', '助動詞', '接続詞', '副詞', '連語'); 
errorValue['語の誤り'] = new Array('Ds'); 

	errorText['動詞'] = new Array('動詞', '語形', '自動詞', '受身態', '使役態', '可能態、自発態', '授受動詞', 'サ変動詞', '他動詞', '機能'); 
	errorValue['動詞'] = new Array('Ds', 'Ds1', 'Ds2', 'Ds3', 'Ds4', 'Ds5', 'Ds5', 'Ds6', 'Ds7', 'Ds8', 'Ds9'); 
	
	errorText['補助動詞'] = new Array('補助動詞', '語形', '受益を表す補助動詞', 'アスペクトを表す補助動詞', 'その他の補助動詞'); 
	errorValue['補助動詞'] = new Array('Hj'); 
	
	errorText['名词'] = new Array('名詞', '語形', '意味', '機能'); 
	errorValue['名詞'] = new Array('Ms'); 
		
	errorText['形式名詞'] = new Array('形式名詞', '語形', '機能'); 
	errorValue['形式名詞'] = new Array('Km'); 
	
	errorText['複合語'] = new Array('複合語', '語形', '意味', 'アスペクトを表す複合動詞', '機能'); 
	errorValue['複合語'] = new Array('Fg'); 
	
	errorText['代名詞'] = new Array('代名詞', '語形', '意味'); 
	errorValue['代名詞'] = new Array('Dm'); 
	
	errorText['形容詞'] = new Array('形容詞', '語形', '意味', '機能'); 
	errorValue['形容詞'] = new Array('Ky'); 
	
	errorText['形容動詞'] = new Array('形容動詞', '語形', '意味'); 
	errorValue['形容動詞'] = new Array('Ky'); 
	
	errorText['助詞'] = new Array('助詞', '格助詞', '接続助詞', '取り立て助詞'); 
	errorValue['助詞'] = new Array('Js'); 
	
	errorText['終助詞'] = new Array('終助詞'); 
	errorValue['終助詞'] = new Array('Syj'); 
	
	errorText['連体詞'] = new Array('連体詞', '語形', '意味'); 
	errorValue['連体詞'] = new Array('Rt'); 
	
	errorText['感嘆詞'] = new Array('感嘆詞'); 
	errorValue['感嘆詞'] = new Array('Gd'); 
	
	errorText['接辞'] = new Array('接辞', '語形', '意味'); 
	errorValue['接辞'] = new Array('Sj'); 
	
	errorText['複合助詞'] = new Array('複合助詞', '語形', '意味'); 
	errorValue['複合助詞'] = new Array('Fk'); 
	
	errorText['助動詞'] = new Array('助動詞', '語形', '意味'); 
	errorValue['助動詞'] = new Array('Jd'); 
	
	errorText['接続詞'] = new Array('接続詞', '語形', '意味'); 
	errorValue['接続詞'] = new Array('St'); 
	
	errorText['連語'] = new Array('連語', '語形', '意味'); 
	errorValue['連語'] = new Array('Lg'); 
	
	errorText['副詞'] = new Array('副詞', '語形', '意味', '機能'); 
	errorValue['副詞'] = new Array('F'); 
	
errorBase['フレーズの誤り'] = new Array('指定なし', '動詞＋動詞', '副詞＋動詞', '名詞＋動詞', '名詞＋名詞', '形容詞＋名詞', '形容動詞＋名詞', '形容動詞＋動詞', '形容詞＋動詞', '慣用句', '名詞＋形容詞'); 
errorValue['フレーズの誤り'] = 'R';

errorBase['語の誤用タイプ'] = new Array('指定なし', '過剰使用', '脱落', '文体', '語順', 'テンス、アスペクト'); 
errorValue['語の誤用タイプ'] = 'W';

errorBase['文の誤りタイプ'] = new Array('指定なし', '過剰使用', '脱落', 'テンス、アスペクト', '句読点', '語順', '文の置き換え', '文体', '肯定、否定'); 
errorValue['文の誤りタイプ'] = 'B';

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

		if (cv == '指定なし') {
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
		if (bv == '語の誤り') $("#tempError").change();
	}); 
	
	//第三层
	$("#tempError").change(function(){
		next = $("#nextError")[0];
		base = $("#baseError")[0];
		temp = $("#tempError")[0]; 
		real = $("#realError")[0]; 
		error = $("#error")[0]; 
		
		var cv, i;
		cv = '語の誤用タイプ';
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
		
		if (base.value != '語の誤り') return; 
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