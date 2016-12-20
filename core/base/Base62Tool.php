<?php
class Base62Tool {
	
	public static $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	public static $encodeBlockSize = 7;
	public static $decodeBlockSize = 4;
	/**
	 * 将mid转换成62进制字符串
	 *
	 * @param	string	$mid
	 * @return	string
	 */
	public static function encode($mid) {
		$str = "";
		$midlen = strlen($mid);
		$segments = ceil($midlen / Base62Tool::$encodeBlockSize);
		$start = $midlen;
		for($i=1; $i<$segments; $i+=1) {
			$start -= Base62Tool::$encodeBlockSize;
			$seg = substr($mid, $start, Base62Tool::$encodeBlockSize);
			$seg = Base62Tool::encodeSegment( $seg );
			$str = str_pad($seg, Base62Tool::$decodeBlockSize, '0', STR_PAD_LEFT) . $str;
		}
		$str = Base62Tool::encodeSegment( substr($mid, 0, $start) ) . $str;
		return $str;
	}

	/**
	 * 将62进制字符串转成10进制mid
	 *
	 * @param	string	$str
	 * @return	string
	 */
	public static function decode($str, $compat=false ,$for_mid=true) {
		$mid = "";
		$strlen = strlen($str);
		$segments = ceil($strlen / Base62Tool::$decodeBlockSize);
		$start = $strlen;
		for($i=1; $i<$segments; $i+=1) {
			$start -= Base62Tool::$decodeBlockSize;
			$seg = substr($str, $start, Base62Tool::$decodeBlockSize);
			$seg = Base62Tool::decodeSegment( $seg );
			$mid = str_pad($seg, Base62Tool::$encodeBlockSize, '0', STR_PAD_LEFT) . $mid;
		}
		$mid = Base62Tool::decodeSegment( substr($str, 0, $start)) . $mid;
		if($compat && !in_array(substr($mid, 0, 3), array('109', '110', '201', '211', '221', '231', '241'))) {
			$mid = Base62Tool::decodeSegment(substr($str, 0, 4)).Base62Tool::decodeSegment(substr($str, 4));
		}
		if($for_mid){
			if(substr($mid, 0, 1)=='1' && substr($mid, 7, 1)=='0') {
				$mid = substr($mid, 0, 7).substr($mid, 8);
			}
		}
		return $mid;
	}

	/**
	 * 将10进制转换成62进制
	 *
	 * @param	string	$str	10进制字符串
	 * @return	string
	 */
	private static function encodeSegment($str) {
		$out = '';
		while($str > 0){
			$idx = $str % 62;
			$out = substr(Base62Tool::$string, $idx, 1) . $out;
			$str = floor($str / 62);
		}
		return $out;
	}
	
	/**
	 * 将62进制转换成10进制
	 *
	 * @param	string	$str	62进制字符串
	 * @return	string
	 */
	private static function decodeSegment($str) {
		$out = 0;
		$base = 1;
		for($t=strlen($str) - 1;$t>=0;$t-=1) {
			$out = $out + $base * strpos(Base62Tool::$string, substr($str, $t, 1));
			$base *= 62;
		}
		return $out . "";
	}
	
}
?>