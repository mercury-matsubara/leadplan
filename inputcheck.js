//---------------------------------------------------//
//                                                   //
//             ���̓`�F�b�N�֐�                      //
//   ����name : �h�L�������gID                       //
//   ����size : �ő啶�����͕�����                   //
//   ����type : ���̓^�C�v(                          //
//                       1:�S�p�̂�                  //
//                       2:���p�̂�                  //
//                       3:���p�p���̂�(�L���s��)    //
//                       4:���p�����̂�              //
//                       5:All OK                    //
//   ����isnotnull:���͕K�{��                        //
//   �߂�ljudge:�`�F�b�N����                        //
//                                                   //
//---------------------------------------------------//
function inputcheck(name,size,type,isnotnull){
	var judge =true;
	var str = document.getElementById(name).value;
	m = String.fromCharCode(event.keyCode);
	var len = 0;
	var str2 = escape(str);
	if(type==1)
	{
		for(i = 0; i < str2.length; i++, len++){
			if(str2.charAt(i) == "%"){
				if(str2.charAt(++i) == "u"){
					i += 3;
					len++;
				}
				else
				{
					judge=false;
				}
				i++;
			}
			else
			{
				judge=false;
			}
		}
		if(judge)
		{
			document.getElementById(name).style.backgroundColor = '';
		}
		else
		{
			window.alert('�S�p�œ��͂��Ă�������');
			document.getElementById(name).style.backgroundColor = '#ff0000';
		}
	}
	else if(type==2)
	{
		for(i = 0; i < str2.length; i++, len++){
			if(str2.charAt(i) == "%"){
				if(str2.charAt(++i) == "u"){
					i += 3;
					len++;
					judge=false;
				}
			}
		}
		if(judge)
		{
			document.getElementById(name).style.backgroundColor = '';
		}
		else
		{
			window.alert('���p�œ��͂��Ă�������');
			document.getElementById(name).style.backgroundColor = '#ff0000';
		}
	}
	else if(type==3)
	{
		if(str.match(/[^0-9A-Za-z]+/)) 
		{
			judge=false;
		}
		if(judge)
		{
			document.getElementById(name).style.backgroundColor = '';
		}
		else
		{
			window.alert('���p�p���œ��͂��Ă�������');
			document.getElementById(name).style.backgroundColor = '#ff0000';
		}
	}
	else if(type==4)
	{
		if(str.match(/[^0-9]+/)) 
		{
			judge=false;
		}
		if(judge)
		{
			document.getElementById(name).style.backgroundColor = '';
		}
		else
		{
			window.alert('���p�����œ��͂��Ă�������');
			document.getElementById(name).style.backgroundColor = '#ff0000';
		}
	}
//	if (size < (str.length))
	if (size < strlen(str))
	{
		if("\b\r".indexOf(m, 0) < 0)
		{
			window.alert(size+'�����ȓ��œ��͂��Ă�������');
		}
		document.getElementById(name).style.backgroundColor = '#ff0000';
		judge = false;
	}
	else
	{
		if(judge)
		{
			document.getElementById(name).style.backgroundColor = '';
		}
	}
	
	if(isnotnull == 1)
	{
		if(document.getElementById(name).value == '')
		{
			document.getElementById(name).style.backgroundColor = '#ff0000';
			judge = false;
			window.alert('�l����͂��Ă�������');
		}
		else if(judge)
		{
			document.getElementById(name).style.backgroundColor = '';
		}
	}
	return judge;
}

function notnullcheck(id,isnotnull)
{
	if(isnotnull == 1)
	{
		var selectnum = document.getElementById(id).selectedIndex;
		if(document.getElementById(id).options[selectnum].value == "")
		{
			document.getElementById(id).style.backgroundColor = '#ff0000';
			judge = false;
				window.alert('�l��I�����ĉ�����');
		}
		else
		{
			document.getElementById(id).style.backgroundColor = '';
		}
	}
}


function strlen(str) {
  var ret = 0;
  for (var i = 0; i < str.length; i++,ret++) {
    var upper = str.charCodeAt(i);
    var lower = str.length > (i + 1) ? str.charCodeAt(i + 1) : 0;
    if (isSurrogatePear(upper, lower)) {
      i++;
    }
  }
  return ret;
}

function strsub(str, begin, end) {
  var ret = '';
  for (var i = 0, len = 0; i < str.length; i++, len++) {
    var upper = str.charCodeAt(i);
    var lower = str.length > (i + 1) ? str.charCodeAt(i + 1) : 0;
    var s = "";
    if(isSurrogatePear(upper, lower)) {
      i++;
      s = String.fromCharCode(upper, lower);
    } else {
      s = String.fromCharCode(upper);
    }
    if (begin <= len && len < end) {
      ret += s;
    }
  }
  return ret;
}

function isSurrogatePear(upper, lower) {
  return 0xD800 <= upper && upper <= 0xDBFF && 0xDC00 <= lower && lower <= 0xDFFF;
}


