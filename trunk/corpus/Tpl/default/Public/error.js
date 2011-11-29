
//手写javascript无压力了...
errorBase = new Object(); 	//错误信息
errorText = new Object(); 
errorValue = new Object(); 	//错误代码

errorBase['所有类型'] = new Array('不限'); 
	errorText['不限'] = new Array('不限'); 
	errorValue['不限'] = new Array('all'); 

errorBase['书写错误'] = new Array('不限', '表记', '文章格式');
	errorText['表记'] = new Array('表记'); 
	errorValue['表记'] = new Array('Hk'); 
	
	errorText['文章格式'] = new Array('文章格式'); 
	errorValue['文章格式'] = new Array('Ss'); 
	
errorBase['词语错误'] = new Array('不限', '动词', '补助动词', '名词', '形式名词', '代词', '复合词', '代词', '形容词', '助词', '终助词', '连体词', '感叹词', '接辞', '复合助词', '助动词', '接续词', '副词', '词语'); 

	errorText['动词'] = new Array('动词', '词形', '自动词', '被动态', '使役态', '可能态', '授受动词', 'サ变动词', '他动词', '词性'); 
	errorValue['动词'] = new Array('Ds', 'Ds1', 'Ds2', 'Ds3', 'Ds4', 'Ds5', 'Ds5', 'Ds6', 'Ds7', 'Ds8', 'Ds9'); 
	
	errorText['补助动词'] = new Array('补助动词', '词形', '授受关系补助动词', '时体补助动词', '其他补助动词'); 
	errorValue['补助动词'] = new Array('Hj'); 
	
	errorText['名词'] = new Array('名词', '词形', '词义', '词性'); 
	errorValue['名词'] = new Array('Ms'); 
		
	errorText['形式名词'] = new Array('形式名词', '词形', '词义'); 
	errorValue['形式名词'] = new Array('Km'); 
	
	errorText['复合词'] = new Array('复合词', '词形', '词义', '时态复合动词'); 
	errorValue['复合词'] = new Array('Fg'); 
	
	errorText['代词'] = new Array('代词', '词形', '词义'); 
	errorValue['代词'] = new Array('Dm'); 
	
	errorText['形容词'] = new Array('形容词', '词形', '词义', '词性'); 
	errorValue['形容词'] = new Array('Ky'); 
	
	errorText['助词'] = new Array('助词', '格助词', '接续助词'); 
	errorValue['助词'] = new Array('Js'); 
	
	errorText['终助词'] = new Array('终助词语义和形式的使用错误'); 
	errorValue['终助词'] = new Array('Syj'); 
	
	errorText['连体词'] = new Array('连体词'); 
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
	
	errorText['副词'] = new Array('副词', '词形', '词义', '词性'); 
	errorValue['副词'] = new Array('F'); 
	
errorBase['词组错误'] = new Array('不限', '动/动搭配', '副/动搭配', '名/动搭配', '名/名搭配', '形/名搭配', '形动/名搭配', '形动/动搭配', '形/动搭配', '固定词组', '名/形搭配'); 
errorValue['词组错误'] = 'R';

errorBase['词法错误'] = new Array('不限', '重复', '欠缺', '语体', '语序', '时态'); 
errorValue['词法错误'] = 'W';

errorBase['句子错误'] = new Array('不限', '重复、多余', '欠缺', '时态', '标点', '语序', '句子置换', '文体', '肯定与否定'); 
errorValue['句子错误'] = 'B';

function set_base(base, next, temp, error)
{
   //改变二级级联下拉菜单的选项供选择
	var pv, i;

	pv = base.value;
	next.length = 1;

	if (pv == '0') return;
	if (typeof(errorBase[pv]) == 'undefined') return;

	for (i = 0; i < errorBase[pv].length; i++)
	{
		next.options[i] = new Option();
		next.options[i].text = errorBase[pv][i];
		next.options[i].value = errorBase[pv][i];
	}
    set_next(base, next, temp, error); 
}

function set_next(base, next, temp, error)
{
   //改变三级级联下拉菜单的选项供选择
	var bv, cv, i;

	bv = base.value; 
	cv = next.value;
	temp.length = 1;

	if (cv == '0') return;
	if (typeof(errorText[cv]) == 'undefined') {
		temp.options[0] = new Option();
		temp.options[0].text = cv;
		temp.options[0].value = errorValue[bv] + next.selectedIndex;
		set_last(base, temp, error);
		return;
	}
	
	for (i = 0; i < errorText[cv].length; i++)
	{
		temp.options[i] = new Option();
		temp.options[i].text = errorText[cv][i];
		if (i == 0)
			temp.options[i].value = errorValue[cv][0];
		else
			temp.options[i].value = errorValue[cv][0] + i;
	}
	
	set_last(base, temp, error);
}

function set_last(base, temp, error)
{
   //改变四级级联下拉菜单的选项供选择
	var cv, i;

	cv = '词法错误';
	error.length = 1;
	
	if (base.value == '词语错误'){
		for (i = 0; i < errorBase[cv].length; i++)
		{
			error.options[i] = new Option();
			if (i == 0){
				error.options[i].text = temp.value + '_' + errorValue[cv];	// errorText[cv][i];
				error.options[i].value = temp.value + '_' + errorValue[cv];
			} else {
				error.options[i].text = temp.value + '_' + errorValue[cv] + i;	// errorText[cv][i];
				error.options[i].value = temp.value + '_' + errorValue[cv] + i;
			}
		}
	} else {
		error.length = 1;
		error.options[0] = new Option();
		error.options[0].text = temp.value; 
		error.options[0].value = temp.value; 
	}
}