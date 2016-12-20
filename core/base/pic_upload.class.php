<?php
//图片上传类
/**
 * @copyright yangchao
 */
/*
* 使用方法：
	$upload_config=array(
	'targetDir' => 'pics',//文件保存路径
	'saveType' => 2, //保存目录结构，默认两级
	'thumbStatus'=> 1, //开启图片压缩，1为等比缩放，2为裁剪
	'thumbSize' => array("100|75"), //压缩文件尺寸限制，原图为xxx.jpg压缩文件名为xxx_100.jpg(100为你填写的宽度限制值)
	'allowMaxSize' => 1024*1024*3, //允许上传图片大小
	'allowExtensions' => array('jpg', 'jpeg', 'gif', 'png', 'bmp')//允许上传的图片格式
	);
	$upload = new pic_upload($upload_config);
	$files = $upload->saveFiles('prize_pic');//传入表单图片名
	
* upfile 上传文件表单的文件变量名称
* $files 为一个上传成功后的一个文件信息数组
**/

//服务器上传文件目录配置开始
define ("DIFANG_UP_IMG_FILE_MAX_SIZE", 1024*1024*3);//最大上传文件3M

class pic_upload {

	//note 上传的目录，确保可写
	var $targetDir = '';

	//note 上传保存的方式：0为不生成子目录，即全部保存在一个目录下  1 按月方式为一个子目录存储 2 按天方式为一个子目录存储
	var $saveType =2;

	//note 返回的上传信息
	var $upFiles = array();

	//note 图片数组扩展后缀
	var $images = array('jpg', 'jpeg', 'gif', 'png', 'bmp');

	//note 可以上传的文件类型,不带点
	var $allowExtensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
	
	//note 可以上传的文件大小
	var  $allowMaxSize = DIFANG_UP_IMG_FILE_MAX_SIZE;

	//note 是否开启缩略图
	var $thumbStatus = 1;//1为等比压缩，图不变形，2为切割图，3为只限定宽度(未做)

	//note 缩略图尺寸
	var $thumbSize = array("100|75");
	//note 是否开启水印, 需要在 $imageConfig 同时配置
	var $waterMarkStatus = 0;

	//note 缩略图和水印的参数 数组, 具体配置说明看 MooImage的参数说明
	var $imageConfig = array();

	//note 判断是否已经生成了子目录，防止重复生成
	var $mkSubDirEd = false;

	//note 图片处理类
	var $imageClass = '';

	//note 是否已经配置图片处理类的相应参数
	var $imageConfiged = false;

	
	var $pic_name ="";
	/**
	 * 配置函数
	 *
	 * @param array $config: 配置数组,对应的key和变量对应
	 * @return void
	 */
	function pic_upload($config) {
		if(is_array($config)) {
			foreach ($config as $var=>$val) {
				if(isset($this->$var)) {
					$this->$var = $val;
				}
			}
		}
	}

	/**
	 * 批量处理上传文件
	 * @param string $upFilename 上传文件的文件变量名称
	 *
	 * @return array $this->upFiles 文件信息数组
	 */
	function saveFiles($upFilename) {

		$files = $this->getFiles($upFilename);
		foreach($files as $file) {
			if(!is_uploaded_file($file['tmp_name']) || !($file['tmp_name'] != 'none' && $file['tmp_name'] && $file['name'])) {
				continue;
			}
			if(!empty($this->allowExtensions) && !in_array($this->getExtension($file['name']), $this->allowExtensions)) {
				continue;
				//uploadError('Not AllowExtensions Attachment!');
			}
			$this->upFiles[] = $this->saveFile($file);
		}
		return $this->upFiles;
	}

	/**
	 * 保存处理单个文件
	 *
	 * @return string
	 */
	function saveFile(& $file) {
		
		$upFile  = array();
		
		if($this->pic_name)
		{
			$upFile['name'] = $this->pic_name;
			
		}
		else
		{
			$upFile['name'] = date("YmdHis").$this->random(10, 1);
			$upFile['name']=md5($upFile['name'].time().rand(1,1000));
		}
		
		$this->getSubDir($upFile['name']);
		$upFile['path'] = $this->targetDir;
		$upFile['filename'] = $file['name'];
		$upFile['extension'] = $this->getExtension($file['name']);
		$upFile['size'] = $file['size'];
		$upFile['isimage'] = 0;
		if($upFile['size'] > $this->allowMaxSize)
		{
			throw new Exception("抱歉！图片大小太大！{$this->allowMaxSize}");	
		}
		if(!empty($this->allowExtensions) && !in_array(strtolower($this->getExtension($upFile['filename'])), $this->allowExtensions)) {
			throw new Exception("抱歉！该格式图片不支持上传！");	
		}
		if(function_exists('getimagesize') && !($size=@getimagesize($file['tmp_name'])))
		{
			throw new Exception("抱歉！上传的图片内容有错！");
		} 
		if($size['mime'])
		{
			switch ($size['mime']) { 
		    case "image/gif": 
		        $function_image_create_from="imagecreatefromgif";
		        break; 
		    case "image/jpeg": 
		         $function_image_create_from="imagecreatefromjpeg";
		        break; 
		    case "image/png": 
		         $function_image_create_from="imagecreatefrompng"; 
		        break; 
		    case "image/bmp": 
		        $function_image_create_from="imagecreatefromwbmp"; 
		        break; 
			} 
			if(function_exists($function_image_create_from) && !$function_image_create_from($file['tmp_name'])){
				throw new Exception("抱歉！上传图片内容有错！");
			}
		}
		
		$file_name= $upFile['path'].$this->show_name.'.'.$upFile['extension'];
		
		$ret["pic"] = str_replace($_SERVER["DOCUMENT_ROOT"],"",$file_name);
		
		if (move_uploaded_file($file['tmp_name'], $file_name)) {
   		 	
		} else {
		   throw new Exception("图片移动出错");
		}
		
		
	    if($this->thumbStatus)
	    {
	    	list($width_pic, $height_pic) = getimagesize($file_name);
		
			switch ($size['mime']) { 
			    case "image/gif": 
			        $function_image_to_file="imagegif";
			        break; 
			    case "image/jpeg": 
			         $function_image_to_file="imagejpeg";
			        break; 
			    case "image/png": 
			         $function_image_to_file="imagepng"; 
			        break; 
			    case "image/bmp": 
			        $function_image_to_file="imagewbmp"; 
			        break; 
				} 
				
	    	foreach($this->thumbSize as $value)
	    	{
	    		$width_orig = $width_pic;
	    		$height_orig = $height_pic;
    			$size_info=explode("|",$value);
    			$width = $size_info[0] ? $size_info[0]  : 100 ;
	    		$height = $size_info[1] ? $size_info[1] : 100 ;
	    		$compare_value_config = $width / $height; //设置的比例
	    		$compare_value_pic = $width_orig / $height_orig;//上传图片比例
	    		$bin_width = 0 ;
	    		$bin_height = 0 ;
	    		switch ($this->thumbStatus) { 
	    			case 1: 
	    			  	//如果上传图片长宽比例比设置比例大，则取设置的宽度做为基准
			    		if($compare_value_pic > $compare_value_config)
			    		{
			    			//改变高度
			    			$height = ($width / $width_orig) * $height_orig;
			    		}
			    		else 
			    		{
			    			//改变宽度
			    			$width = ($height / $height_orig) * $width_orig;
			    			
			    		}
			    		 break; 
			    	case 2: 
	    				//如果上传图片长宽比例比设置比例大，则切割宽度
			    		if($compare_value_pic > $compare_value_config)
			    		{
			    			//切割宽度
			    			$cut_width = ($width / $height) * $height_orig;
			    			//开始切割点
			    			$bin_width = ( $width_orig - $cut_width ) / 2;
			    			$width_orig = $cut_width;
			    	
			    		}
			    		else 
			    		{
			    			//切割高度
			    			$cut_height = ($height / $width) * $width_orig;
			    			//开始切割点
			    			$bin_height = ( $height_orig - $cut_height ) / 2;
			    			$height_orig = $cut_height;
			    		}
			    		
			    		 break; 
	    		}
				$image_p = imagecreatetruecolor($width, $height);
			
				$image = $function_image_create_from($file_name);
			
				imagecopyresampled($image_p, $image, 0, 0, $bin_width, $bin_height, $width, $height, $width_orig, $height_orig);
				$file_name1=$upFile['path'].$this->show_name."_{$size_info[0]}.".$upFile['extension'];
				$ret["pic_cut"][] = str_replace($_SERVER["DOCUMENT_ROOT"],"",$file_name1);
			    $width = $value;
				$height = $value;
				$function_image_to_file($image_p,$file_name1);
				
				unset($image);
	    	}

	    }
		
		
	   	$upFile["pic_return_info"]=$ret;
	  	 return $upFile;
        	
	}
	
	
	//生成头像专用函数
	function create_user_head_pic($file_address,$big_pic_info = array() , $other_size_info=array(50=>"/50/",30=>"/30/"),$pic_url="header/180/1737886622_large")
	{
			$file_address = $_SERVER["DOCUMENT_ROOT"].$file_address;
	    	$image_info= getimagesize($file_address);
			$width_pic = $image_info[0];
			$height_pic = $image_info[1];
	    	$mime =  $image_info["mime"];
	    	
			switch ($mime) { 
			     case "image/gif": 
		        $function_image_create_from="imagecreatefromgif";
		         $function_image_to_file="imagegif";
		        break; 
			    case "image/jpeg": 
			         $function_image_create_from="imagecreatefromjpeg";
			         $function_image_to_file="imagejpeg";
			        break; 
			    case "image/png": 
			         $function_image_create_from="imagecreatefrompng"; 
			         $function_image_to_file="imagepng"; 
			        break; 
			    case "image/bmp": 
			        $function_image_create_from="imagecreatefromwbmp"; 
			        $function_image_to_file="imagewbmp"; 
			         break; 
				} 
	    	 
				list($new_width,$new_height,$x,$y) = $big_pic_info;
					
				$image_p = imagecreatetruecolor($new_width, $new_height);
				$image = $function_image_create_from($file_address);
				$width_pic = $width_pic - $x;
				$height_pic = $height_pic - $y;
				imagecopyresampled($image_p, $image, 0, 0, $x, $y, $new_width, $new_height, $width_pic, $height_pic);
				
				$this->getSubDir($pic_url);
				
				$file_name= $this->targetDir.$this->show_name.'.jpg';
				$function_image_to_file($image_p,$file_name);
				$result["pic"] = str_replace($_SERVER["DOCUMENT_ROOT"],"",$file_name);
				
				foreach($other_size_info as $key => $value)
				{
					$image_p = imagecreatetruecolor($key, $key);
					imagecopyresampled($image_p, $image, 0, 0, $x, $y, $key, $key, $width_pic, $height_pic);
					
					$pic_url_new = str_replace("/180/",$value,$pic_url);
					$this->getSubDir($pic_url_new);
					$file_name_new= $this->targetDir.$this->show_name.'.jpg';
					$function_image_to_file($image_p,$file_name_new);
					
					
					$result["pic_{$key}"] = str_replace($_SERVER["DOCUMENT_ROOT"],"",$file_name_new);
					
				}
				
				unlink($file_address);
				
				return $result;

	
	
	}

	/**
	 * 根据指定存储的方式取得上传子目录
	 *
	 * @return void
	 */
	function getSubDir($file_name) {
		if($this->targetDir)
		{
			$this->targetDir = $_SERVER["DOCUMENT_ROOT"]."/data"."/".$this->targetDir;
			
			if(!is_dir($_SERVER["DOCUMENT_ROOT"]."/data"))
			{
				mkdir($_SERVER["DOCUMENT_ROOT"]."/data");
			}
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
		}
		else
		{
			$this->targetDir = $_SERVER["DOCUMENT_ROOT"]."/data";
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
		}
		
		
		
		$file_name_array = explode("/",$file_name);
		for($i=0;$i<count($file_name_array)-1; $i++)
		{
			$this->targetDir .= "/".$file_name_array[$i];
				
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
		}
		$file_name = array_pop($file_name_array);
		$file_name = sprintf("%012s",$file_name);
		$this->show_name=$file_name;
		
	
		
		if($this->saveType == 1) {
			$this->targetDir .= "/".substr($file_name,0,2)."/";
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
		
		}else if($this->saveType == 2) 
		{
			$this->targetDir .= "/".substr($file_name,0,2);
			
			if(!is_dir($this->targetDir))
			{
				
				mkdir($this->targetDir);
			}
			
			$this->targetDir .= "/".substr($file_name,2,2)."/";
			
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
			
		}
		else 
		{
			$this->targetDir .= "/".substr($file_name,0,2);
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
			
			
			$this->targetDir .= "/".substr($file_name,2,2);
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
			
			$this->targetDir .= "/".substr($file_name,4,2)."/";
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir);
			}
		
		}


	}

	/**
	 * 返回上传文件不带"."的扩展名
	 *
	 * @return string
	 */
	function getExtension($fileName) {
		return pathinfo($fileName, PATHINFO_EXTENSION);
	}


	/**
	 * 把多个文件上传的信息拆分后返回
	 * @param string $upFilename  表单上传文件变量的名称
	 *
	 * @return array FilesInfo
	 */
	function getFiles($upFilename) {
		$upFiles = array();
		if(isset($_FILES[$upFilename]) && is_array($_FILES[$upFilename])) {
			foreach($_FILES[$upFilename] as $key => $var) {
				if(!is_array($var)) {
					$upFiles[0] = $_FILES[$upFilename];
					break;
				}
				foreach($var as $id => $val) {
					$upFiles[$id][$key] = $val;
				}
			}
		}
		return $upFiles;
	}

	/**
	 * 返回随机字符
	 * @param int $length  字符长度
	 * @param boolean $numeric  是否是数字
	 *
	 * @return string random string
	 */
	function random($length, $numeric = 0) {
		PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
		if($numeric) {
			$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
		} else {
			$hash = '';
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
			$max = strlen($chars) - 1;
			for($i = 0; $i < $length; $i++) {
				$hash .= $chars[mt_rand(0, $max)];
			}
		}
		return $hash;
	}

}
