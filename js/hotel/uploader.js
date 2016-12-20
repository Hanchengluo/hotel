/**
	
	参数
	pic_name file的name
	thumbstatus 1为压缩 2为裁剪
	thumbsize 压缩或者裁剪尺寸 例子：100|75
*/


TV = window.TV || {};
TV.MAIN= TV.MAIN || {};
TV.ImgUploader = (function() {
	//--defaults options value--//
	var defaults=
			{
				callback:'',
				script:'/interface/common/json_pic_upload.php',
				onComplete:null,
				onError:null,
				errorId:null,
				name:'pic_name',
				container:'#dfz_uploader',
				thumb:0,
				size:'100|75',
				loading:'.img_uploading',
				loadingText:'<span class="img_uploading">正在上传..</span>',
				FileMaxSize:100
			};
	var options = {};
	var fileId= '';
	//-----global functions ------// 
	function chkDefault(options)
	{
		for(key in defaults)
		{
			if(typeof(options[key])=='undefined')
			{
				options[key]=defaults[key];
			}
		}
		return options;
	}
	
	function checkFile()
	{
		var filestr=document.getElementById(fileId).value;
		if(filestr=="")
		{
			error("请选择一个文件进行上传！");
			return false;
		}
		var pos = filestr.lastIndexOf(".");
		var lastname =filestr.substring(pos,filestr.length) //此处文件后缀名也可用数组方式获得str.split(".")
		if (lastname.toLowerCase()!=".jpg" && lastname.toLowerCase()!=".gif" && lastname.toLowerCase()!=".png")
		{
		   error("您上传的文件类型为"+lastname+"，图片必须为.jpg,.gif,.png类型!");
		   return false;
		}
		
		return true;
	}
	
	function error(msg)
	{
		if($.isFunction(options.onError))
		{
			options.onError(msg);
		}
		else if(options.errorId)
		{
			$(options.errorId).html(msg);
			$(options.errorId).show();
		}
		else
		{
			if($.isFunction(TV.alert))
			{
				TV.alert(msg);
			}
			else
			{
				alert(msg);
			}
		}
	}
	
	return {
		init: function( opts ) {
			options=chkDefault(opts);
			try
			{
				
				var formId='dfzImgUploaderForm'+Math.round(Math.random()*100);
				fileId = formId+'FileSelector';
				
				$(options.container).append('<form id="'+formId+'" target="dfz_uploader_post_iframe" class="img_form" action="'+options.script+'?cb='+encodeURIComponent(options.callback)+'&pic_name='+options.name+'&thumbstatus='+options.thumb+'&thumbsize='+options.size+'" enctype="multipart/form-data" method="POST"><div id="upact" class="upload_bnt" href="javascript:;"><input id="'+fileId+'" class="files" type="file" name="'+options.name+'"  size="1"></div><br>'+options.loadingText+'</form><iframe frameborder="0" src="about:blank" class="fb_img_iframe" name="dfz_uploader_post_iframe" id="dfz_uploader_post_iframe" style="display: none;"></iframe>');

				var theForm=$('#'+formId);
				var theSelector=$("#"+fileId);
				
				$(options.loading).hide();
				//选择上传的图片，提交图片到图片服务器 
				theSelector.change(function(){
				
					
						TV.MAIN.Tips.Loading("上传中。。。");
						
						theForm.submit();
					
				});
				
			}
			catch(e)
			{
				error(e);
			}
		}
		,
		onComplete:function(res)
		{

			TV.MAIN.Tips.remove_tip();
			if(options.errorId)
			{
				$(options.errorId).hide();
			}

			if(res.error>0 && typeof(res.errormsg)!='undefined')
			{
				error(decodeURIComponent(res.errormsg));
				return ;
			}
			
			if($.isFunction(options.onComplete))
			{
				options.onComplete(res);
			}
		}
	}	
})();


