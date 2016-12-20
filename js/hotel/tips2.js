/**
	@author yangcaho message         
**/
TV2 = window.TV2 || {};
TV2.MAIN= TV2.MAIN || {};
TV2.MAIN.Tips = (function($) {
	
	
	function show_message(message,second)
	{
		if(!second)
		{
			second = 1000;
		}
		var boarddiv = '<div class="tip_class" style="border:3px solid green;max-width: 300px; font-size: 14px;z-index: 10001;  margin: 3px; line-height: 65px;  background-color: rgb(255, 255, 255); text-align: center; position: fixed; left: 450px; top: 200px; display: block;" id="poster_loading"><span style="color:green;font-size: 30px;font-weight:bolder;margin:10px;">'+message+'</span></div>';
		$(document.body).append(boarddiv);
		
		window.setTimeout("TV2.MAIN.Tips.remove_tip()", second);
	}


	function remove_tip()
	{
		$(".tip_class").remove();
	}
	
	function show_loding(message)
	{
		
		var boarddiv = '<div class="tip_class" style="border:3px solid green;max-width: 300px; font-size: 14px;z-index: 10001;  margin: 3px; line-height: 65px;  background-color: rgb(255, 255, 255); text-align: center; position: fixed; left: 450px; top: 200px; display: block;" id="poster_loading"><span style="color:green;font-size: 30px;font-weight:bolder;margin:10px;">'+message+'</span></div>';
		$(document.body).append(boarddiv);
	
	}

	function text_default_val(text_id)
	{
		$(text_id).val($(text_id).attr("default-value"))
		$(text_id).attr("style","color:#A6A6A6;");
		$(text_id).bind("focusin",function(e)
		{

			if($(text_id).val() == "" ||  $(text_id).attr("default-value") ==$(text_id).val() )
			{
				$(text_id).val("");
				$(text_id).attr("style","color:#000000;");
			}
		});
		$(text_id).bind("focusout",function(e)
		{
			if($(text_id).val() == ""   ||  $(text_id).attr("default-value") ==$(text_id).val() )
			{
				$(text_id).val($(text_id).attr("default-value"));
				$(text_id).attr("style","color:#A6A6A6;");
			}
			
		});

	}

	return {
			
			
			Show:function(errmsg,second){
				show_message(errmsg,second);
			},
			Loading:function(errmsg)
			{
				show_loding(errmsg);
			},
			remove_tip:function(){
				remove_tip();
			},
			text_default_val:function(text_id){
				text_default_val(text_id);
			}	
		};

})(jQuery);