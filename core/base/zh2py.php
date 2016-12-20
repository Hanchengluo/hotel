<?php
function utf82gb($utfstr){ // UTF-8汉字转GBK汉字
	if(function_exists('iconv')){ return iconv('utf-8','gbk',$utfstr); }
	global $UC2GBTABLE;
	$okstr = "";
	if(trim($utfstr)=="") return $utfstr;
	if(empty($UC2GBTABLE)){
		$filename = dirname(__FILE__) . "/gb2312-utf8.table";
		$fp = fopen($filename,"r");
		while($l = fgets($fp,15))
		{	$UC2GBTABLE[hexdec(substr($l, 7, 6))] = hexdec(substr($l, 0, 6));}
		fclose($fp);
	}
	$okstr = "";
	$ulen = strlen($utfstr);
	for($i=0;$i<$ulen;$i++)
	{
		$c = $utfstr[$i];
		$cb = decbin(ord($utfstr[$i]));
		if(strlen($cb)==8){
			$csize = strpos(decbin(ord($cb)),"0");
			for($j=0;$j < $csize;$j++){
				$i++; $c .= $utfstr[$i];
			}
			$c = utf82u($c);
			if(isset($UC2GBTABLE[$c])){
				$c = dechex($UC2GBTABLE[$c]+0x8080);
				$okstr .= chr(hexdec($c[0].$c[1])).chr(hexdec($c[2].$c[3]));
			}
			else
			{ $okstr .= "&#".$c.";";}
		}
		else $okstr .= $c;
	}
	$okstr = trim($okstr);
	return $okstr;
}

function SpGetPinyin($str,$ishead=0,$isclose=1){ // GBK汉字转拼音
	global $pinyins;
	$restr = "";
	$str = trim($str);
	$slen = strlen($str);
	if($slen<2) return $str;
	if(count($pinyins)==0){
		$fp = fopen(dirname(__FILE__) . '/pinyin.db',"r");
		while(!feof($fp)){
			$line = trim(fgets($fp));
			$pinyins[$line[0].$line[1]] = substr($line,3,strlen($line)-3);
		}
		fclose($fp);
	}
	for($i=0;$i<$slen;$i++){
		if(ord($str[$i])>0x80)
		{
			$c = $str[$i].$str[$i+1];
			$i++;
			if(isset($pinyins[$c])){
				if($ishead==0) $restr .= $pinyins[$c];
				else $restr .= $pinyins[$c][0];
			}else $restr .= "_";
		}else if( eregi("[a-z0-9]",$str[$i]) ){	$restr .= $str[$i]; }
		else{ $restr .= "_";  }
	}
	if($isclose==0) unset($pinyins);
	return $restr;
}

function getPinyin($string){ // UTF-8汉字转拼音
	return SpGetPinyin(utf82gb($string));
}

//echo getPinyin("呢间真系“平价嘅美味”。虽然环境、服务“和一般嘅西餐厅冇得比”，不过D嘢真系“对得住价钱”。“最中意食”芝士鸡扒，鸡肉的确“鲜嫩”，分量“仲算可以”；蜗牛肉也“好香”，配上“浓郁嘅蒜香面包”，“好好味”。生意“几旺”，客人“多到惊”噶！");
?>