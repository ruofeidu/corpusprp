
//��дjavascript��ѹ����...
errorBase = new Object(); 	//������Ϣ
errorText = new Object(); 
errorValue = new Object(); 	//�������

errorBase['��������'] = new Array('����'); 
	errorText['����'] = new Array('����'); 
	errorValue['����'] = new Array('all'); 

errorBase['��д����'] = new Array('����', '���', '���¸�ʽ');
	errorText['���'] = new Array('���'); 
	errorValue['���'] = new Array('Hk'); 
	
	errorText['���¸�ʽ'] = new Array('���¸�ʽ'); 
	errorValue['���¸�ʽ'] = new Array('Ss'); 
	
errorBase['�������'] = new Array('����', '����', '��������', '����', '��ʽ����', '����', '���ϴ�', '����', '���ݴ�', '����', '������', '�����', '��̾��', '�Ӵ�', '��������', '������', '������', '����', '����'); 

	errorText['����'] = new Array('����', '����', '�Զ���', '����̬', 'ʹ��̬', '����̬', '���ܶ���', '���䶯��', '������', '����'); 
	errorValue['����'] = new Array('Ds', 'Ds1', 'Ds2', 'Ds3', 'Ds4', 'Ds5', 'Ds5', 'Ds6', 'Ds7', 'Ds8', 'Ds9'); 
	
	errorText['��������'] = new Array('��������', '����', '���ܹ�ϵ��������', 'ʱ�岹������', '������������'); 
	errorValue['��������'] = new Array('Hj', 'Hj1', 'Hj2', 'Hj3'); 
	
	errorText['����'] = new Array('����', '����', '����', '����'); 
	errorValue['����'] = new Array('Ms', 'Ms1', 'Ms2', 'Ms3'); 
		
	errorText['��ʽ����'] = new Array('��ʽ����', '����', '����'); 
	errorValue['��ʽ����'] = new Array('Km'); 
	
	errorText['���ϴ�'] = new Array('���ϴ�', '����', '����', 'ʱ̬���϶���'); 
	errorValue['���ϴ�'] = new Array('Fg'); 
	
	errorText['����'] = new Array('����', '����', '����'); 
	errorValue['����'] = new Array('Dm'); 
	
	errorText['���ݴ�'] = new Array('���ݴ�', '����', '����', '����'); 
	errorValue['���ݴ�'] = new Array('Ky'); 
	
	errorText['����'] = new Array('����', '������', '��������'); 
	errorValue['����'] = new Array('Js'); 
	
	errorText['������'] = new Array('�������������ʽ��ʹ�ô���'); 
	errorValue['������'] = new Array('Syj'); 
	
	errorText['�����'] = new Array('�����'); 
	errorValue['�����'] = new Array('Rt'); 
	
	errorText['��̾��'] = new Array('��̾��'); 
	errorValue['��̾��'] = new Array('Gd'); 
	
	errorText['�Ӵ�'] = new Array('�Ӵ�', '����', '����'); 
	errorValue['�Ӵ�'] = new Array('Sj'); 
	
	errorText['��������'] = new Array('��������', '����', '����'); 
	errorValue['��������'] = new Array('Fk'); 
	
	errorText['������'] = new Array('������', '����', '����'); 
	errorValue['������'] = new Array('Jd'); 
	
	errorText['������'] = new Array('������', '����', '����'); 
	errorValue['������'] = new Array('St'); 
	
	errorText['����'] = new Array('����', '����', '����', '����'); 
	errorValue['����'] = new Array('F'); 
	
errorBase['�������'] = new Array('����', '��/������', '��/������', '��/������', '��/������', '��/������', '�ζ�/������', '�ζ�/������', '��/������', '�̶�����', '��/�δ���'); 
errorValue['�������'] = 'R';

errorBase['�ʷ�����'] = new Array('����', '�ظ�', 'Ƿȱ', '����', '����', 'ʱ̬'); 
errorValue['�ʷ�����'] = 'W';

errorBase['���Ӵ���'] = new Array('����', '�ظ�������', 'Ƿȱ', 'ʱ̬', '���', '����', '�����û�', '����', '�϶����'); 
errorValue['���Ӵ���'] = 'W';

function set_city(province, city, error)
{
   //�ı�������������˵���ѡ�ѡ��
	var pv, i;

	pv = province.value;
	city.length = 1;

	if (pv == '0') return;
	if (typeof(errorBase[pv]) == 'undefined') return;

	for (i = 0; i < errorBase[pv].length; i++)
	{
		city.options[i] = new Option();
		city.options[i].text = errorBase[pv][i];
		city.options[i].value = errorBase[pv][i];
	}
    set_next(city, error); 
}

function set_next(city, error)
{
   //�ı�������������˵���ѡ�ѡ��
	var cv, i;

	cv = city.value;
	error.length = 1;

	if (cv == '0') return;
	if (typeof(errorText[cv]) == 'undefined') {
		error.options[0] = new Option();
		error.options[0].text = cv;
		error.options[0].value = errorValue[cv] + city.index;
		return;
	}
	
	for (i = 0; i < errorText[cv].length; i++)
	{
		error.options[i] = new Option();
		error.options[i].text = errorText[cv][i];
		error.options[i].value = errorValue[cv] + i;
	}
}