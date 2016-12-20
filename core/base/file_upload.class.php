<?php
//文件上传类
/**
 * @copyright yangchao
 */
/*
* 使用方法：
**/

class file_upload {

	var $targetDir ="file";
	var $allowExtensions = array();
	
	/**
	 * 批量处理上传文件
	 * @param string $upFilename 上传文件的文件变量名称
	 *
	 * @return array $this->upFiles 文件信息数组
	 */
	function saveFile($file) {
		
		if(!is_uploaded_file($file['tmp_name']) || !($file['tmp_name'] != 'none' && $file['tmp_name'] && $file['name'])) {
				continue;
			}
			if(!empty($this->allowExtensions) && !in_array($this->getExtension($file['name']), $this->allowExtensions)) {
				//continue;
				//uploadError('Not AllowExtensions Attachment!');
			}
		$extension= $this->getExtension($file['name']);	
		$this->getSubDir(md5($file['name'].time().rand(1,1000)));
		$file_name= $this->targetDir.$this->show_name.".{$extension}";
		
		if (move_uploaded_file($file['tmp_name'], $file_name)) {
		} else {
		   throw new Exception("图片移动出错");
		}
		
		$link = str_replace($_SERVER["DOCUMENT_ROOT"],"",$file_name);

		return $link;
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
				mkdir($_SERVER["DOCUMENT_ROOT"]."/data",0777);
			}
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
		}
		else
		{
			$this->targetDir = $_SERVER["DOCUMENT_ROOT"]."/data";
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
		}
		
		
		
		$file_name_array = explode("/",$file_name);
		for($i=0;$i<count($file_name_array)-1; $i++)
		{
			$this->targetDir .= "/".$file_name_array[$i];
				
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
		}
		$file_name = array_pop($file_name_array);
		$file_name = sprintf("%012s",$file_name);
		$this->show_name=$file_name;
		
	
		
		if($this->saveType == 1) {
			$this->targetDir .= "/".substr($file_name,0,2)."/";
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
		
		$this->targetDir .= "/".$file_name."/";
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
		}else if($this->saveType == 2) 
		{
			$this->targetDir .= "/".substr($file_name,0,2);
			
			if(!is_dir($this->targetDir))
			{
				
				mkdir($this->targetDir,0777);
			}
			
			$this->targetDir .= "/".substr($file_name,2,2);
			
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
			
			
			$this->targetDir .= "/".$file_name."/";
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
			
		}
		else 
		{
			$this->targetDir .= "/".substr($file_name,0,2);
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
			
			
			$this->targetDir .= "/".substr($file_name,2,2);
			
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
			
			$this->targetDir .= "/".substr($file_name,4,2);
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
			
			$this->targetDir .= "/".$file_name."/";
			if(!is_dir($this->targetDir))
			{
				mkdir($this->targetDir,0777);
			}
			
		}


	}

}
