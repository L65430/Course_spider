<?php
//�û��������롢�γ̺š������
$zjh = '';
$mm = '';
$kch = '';
$kxh = '';
//˵������ýű�����
//$zjh = $_POST['zjh'];
//$mm = $_POST['mm'];
//$kch = $_POST['kch'];
//$kxh = $_POST['kxh'];
//curl������ʼ������ȡcookies��ҪHEADER
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 5);
while (true) {
	//���ε�½�Ի�ȡcookies
	//curl_setopt($curl, CURLOPT_URL, 'http://202.115.47.141/loginAction.do?zjh=' . $zjh . '&mm=' . $mm);
	curl_setopt($curl, CURLOPT_URL, 'http://202.115.47.141/loginAction.do');
	curl_setopt($curl, CURLOPT_POST, 1);
	$post_data = array('zjh'=>$zjh, 'mm'=>$mm);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	$data = curl_exec($curl);
	preg_match("!Set-Cookie: (.*)!", $data, $matches);
	$cookies = $matches[1];
	echo "Login! Cookies: ".$cookies."\n";
	curl_setopt($curl, CURLOPT_COOKIE, $cookies);
	curl_setopt($curl, CURLOPT_URL, 'http://202.115.47.141/xkAction.do');
	$data = curl_exec($curl);
	echo "Init len: ".strlen($data)."\n";
	//countΪѭ���Ƴ���ǣ���������flag
	$flag = 0;
	//sumΪѭ��������
	$sum = 0;
	//ˢ��ѭ��
	while ($flag == 0) {
		if (preg_match("!alert.gif!", $data)==1) {
			echo "fuck!!! Re-login.\n";
			break;
		}
		curl_setopt($curl, CURLOPT_URL, 'http://202.115.47.141/xkAction.do?kch=' . $kch . '&cxkxh=' . $kxh . '&kcm=&skjs=&kkxsjc=&skxq=&skjc=&pageNumber=-2&preActionType=3&actionType=5');
		$data = curl_exec($curl);
		//һ�������ж�ѡ��˵���пο�ѡ��֮��ѭ�����˳�
		$flag = preg_match("!checkbox!", $data);
		$sum = $sum + 1;
		echo $sum.": ".$flag." len: ". strlen($data)."\n";
	}
	if ($flag == 1) {
		echo "Found it!\n";
		break;
	}
}
//ѡ�β���
//curl_setopt($curl, CURLOPT_URL, 'http://202.115.47.141/xkAction.do');
//$data = curl_exec($curl);
curl_setopt($curl, CURLOPT_URL, 'http://202.115.47.141/xkAction.do?kcId=' . $kch . '_' . $kxh . '&preActionType=5&actionType=9');
$data = curl_exec($curl);
echo $data."\nFinished!\n";
curl_close($curl);
?>
