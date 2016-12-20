function $(_sId)
{
	return document.getElementById(_sId);
}
function hide(_sId)
{
	$(_sId).style.display = $(_sId).style.display == "none" ? "" : "none";
}
function swapPic(_sId,_sAttr,_sTxt1, _sTxt2)
{
	$(_sId)[_sAttr] = $(_sId)[_sAttr].indexOf(_sTxt1) > -1 ? _sTxt2 : _sTxt1;
}
function iframeautosize(o){
	var newHeight = o.contentWindow.document.body.scrollHeight + 20;
	o.style.height = newHeight>600?(newHeight+"px"):(600+"px");
}
