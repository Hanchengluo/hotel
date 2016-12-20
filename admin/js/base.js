if(_needcode == null) var _needcode = false;
window.onerror=function(){return true};

//用于从指定窗口对象中Copy变量
function InitVars(_src, _target, varsList){
	if (varsList instanceof Array){
		var l = varsList.length;
		for (var i=0; i<l; i++){
			var cur = varsList[i];
			try{
				if(_src[cur]) _target[cur] = _src[cur];
			}catch(e){}
		}
	}
}
	
// 获取地址栏的指定参数
function GetQueryString(str) {
	var tmp = new RegExp("(^|)" + str + "=([^\&]*)(\&|$)", "gi").exec(String(window.location.href));
	return tmp?tmp[2]:'';
}
/** 页面大小 */
var getPageSize = function() {
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	}
	else if (document.body.scrollHeight > document.body.offsetHeight) {
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	}
	else {
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	var windowWidth, windowHeight;
	if (self.innerHeight) {
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight) {
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	}
	else if (document.body) {
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	}
	else { 
		pageHeight = yScroll;
	}
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	}
	else {
		pageWidth = xScroll;
	}
	return [pageWidth,pageHeight,windowWidth,windowHeight];
};
var isIE,isIE5,isIE6,isIE7,isOpr,isMoz;
var agent=navigator.userAgent;
String.prototype.inc=function(s){return this.indexOf(s)>-1?true:false}
isOpr=agent.inc("Opera")
isIE=agent.inc("IE")&&!isOpr
isMoz=agent.inc("Mozilla")&&!isOpr&&!isIE
isIE6=agent.inc("MSIE 6")
isIE7=agent.inc("MSIE 7")
if(isMoz){
	Event.prototype.__defineGetter__("srcElement",function(){var node=this.target;while(node.nodeType!=1){node=node.parentNode}return node})
	Event.prototype.__defineGetter__("x",function(){return this.clientX})
	Event.prototype.__defineGetter__("y",function(){return this.clientY})
}
String.prototype.leftB=function(len, els){
	if (isNull(els) || this.lenB() <= len){
		els = "";
	}
	len -= els.length;
	var s=this.replace(/\*/g," ").replace(/[^\x00-\xff]/g,"**");
	return this.slice(0,s.slice(0,len).replace(/\*\*/g," ").replace(/\*/g,"").length) + els;
}
String.prototype.lenB=function(){return this.replace(/\*/g," ").replace(/[^\x00-\xff]/g,"**").length}
String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*$)/g,"");}
String.prototype.byteLength = function () {
	aMatch = this.match(/[^\x00-\x80]/g);
	return (this.length + (! aMatch ? 0 : aMatch.length));
}
Array.prototype.add=function(key){this[this.length]=key}

var getEvent = function () {
	return window.event;
};
var randomInt=function(n1,n2){return Math.round(n1+(n2-n1)*Math.random())}
if(isMoz){
	getEvent = function () {
		var o = arguments.callee.caller;
		var e;
		var n = 0;
		while(o != null && n < 40){
			e = o.arguments[0];
			if (e && (e.constructor == Event || e.constructor == MouseEvent)) {
				return e;
			}
			n ++;
			o = o.caller;
		}
		return e;
	};
}
//禁止事件冒泡
var stopEvent = function() {
	var ev = getEvent();
	ev.cancelBubble = true;
	ev.returnValue = false;
};
if(isMoz) {
	stopEvent = function() {
		var ev = getEvent();
		ev.preventDefault();
		ev.stopPropagation();
	};
}
function $(obj){return document.getElementById(obj)}
function oDel(obj){if(obj!=null){obj.parentNode.removeChild(obj)}}
function addEvent(obj,eventName,eventFunc){if(obj.attachEvent){obj.attachEvent(eventName,eventFunc);}else if(obj.addEventListener){eventName = eventName.toString().replace(/on(.*)/i,'$1');obj.addEventListener(eventName,eventFunc,true);}}
function delEvent(obj,eventName,eventFunc){if(obj.detachEvent){obj.detachEvent(eventName,eventFunc);}else if(obj.removeEventListener){eventName = eventName.toString().replace(/on(.*)/i,'$1');obj.removeEventListener(eventName,eventFunc,true);}}
function objxy(e){
	if(e instanceof Array || e.length) return e;
	var a=new Array()
	var t=e.offsetTop;
	var l=e.offsetLeft;
	var w=e.offsetWidth;
	var h=e.offsetHeight;
	while(e=e.offsetParent){
		t+=e.offsetTop;
		l+=e.offsetLeft;
	}
	a[0]=t;a[1]=l;a[2]=w;a[3]=h
  return a;
}
//时间戳
function ts(){
	return (new Date()).getTime();
}
////script取值
function scriptRequest(url,echo, nornd){
	var t=new Date();
	if (nornd != true) {
		if (url.inc("?")) {
			url += "&" + t.getTime()
		}
		else {
			url += "?" + t.getTime()
		}
	}
	var head = document.getElementsByTagName("head")[0];
	var ss = document.getElementsByTagName("script");
	for (var i=0;i<ss.length;i++) {
		if (ss[i].src&&ss[i].src.indexOf(url)!=-1){
			head.removeChild(ss[i]);
		}
	}
	var script = document.createElement("script");
	script.src = url;
	script.setAttribute("type", "text/javascript");
	script.charset="utf-8";
	head.appendChild(script);
	script.onload = script.onreadystatechange = function(){
		if (this.readyState && this.readyState == "loading"){
			return;
		}
		if(typeof(echo)=="function"){
			echo();
		}else{
			eval(echo);
		}
	};
}
///页面高度
function getbodyCH(){var bh=document.body.clientHeight;var eh=document.documentElement.clientHeight;if(bh>eh){return bh}else{return eh}}
///屏幕高度
function showbodyCH(){if(window.innerHeight){return window.innerHeight;}else if(document.documentElement&&document.documentElement.clientHeight){return document.documentElement.clientHeight;}else if(document.body){return document.body.clientHeight;}}
///屏幕宽度
function getbodyCW(){var bw=document.body.clientWidth;var ew=document.documentElement.clientWidth;if(bw>ew){return bw}else{return ew}}
/////滚动条高度
function scrolltop(){if(window.pageYOffset){return window.pageYOffset;}else if(document.documentElement&&document.documentElement.scrollTop){return document.documentElement.scrollTop;}else if(document.body){return document.body.scrollTop;}}

////鼠标焦点在文本后
function setCursor(o){
	if(document.all){
		rng=o.createTextRange()
		rng.move("textedit")
		rng.select()		
	}else{
		var rng=document.createRange()
		o.focus()
		rng.setStartAfter(o)
	}
}

/**
 * 判断某元素是否包含指定样式
 *@author xs
 */
function hasCls(o, s){
	 var n = o.className;
	 return (n == s || n.match(new RegExp("(^|\\s)" + s + "(\\s|$)")));
}

/**
 * 添加样式
 *@author xs
 */
function addCls(o, s){
	if(!hasCls(o,s)){
		var a = o.className.split(/\s+/);
		a.push(s);
		o.className = a.join(' ');
	}
}

/**
 * 删除样式
 *@author xs
 */
function delCls(o, s){
	if(hasCls(o,s)){
		var n = o.className.replace(s, '');
		var a = n.split(/\s+/);
		o.className = a.join(' ');
	}
}

/**************
文本最多显示字节数
obj为输入框，n是限制长度，dom显示信息的容器id
***************/
function strsize(obj,n,dom){
	dom = $(dom) || {};
	var len=obj.value.lenB();
	if(len>n){
		//alert("您已超出"+n+"字")
		dom.innerHTML="<font style='color:#F00'>超出"+(-k)+"个字</font>";
		obj.value=obj.value.replace(/\n$/g,"").leftB(n);
		obj.scrollTop=1000;
		setCursor(obj);
		len=n;
	}
	var k= n-len;
	if(k>=0)
		dom.innerHTML="剩余"+(Math.floor(k/2))+"个汉字";
	else
		dom.innerHTML="超出"+(Math.floor(-k))+"个汉字";
}
/****设置分页****
obj,渲染DOM
total,总条数
onpage,当前页
fs,每页显示数
txt,说明文字
$echo翻页回调函数
****************/
function set_page(obj,total,onpage,fs,$echo){
//	obj="guestbook_page"
//	total=780
//	onpage=1
//	fs=10
//	txt="条留言"
	
	///程序开始
	var ps=parseInt(total/fs);		//总页数
	if(total%fs>0){
		ps++;
	}
	if(ps<=1){
		return;
	}
	var str="<span>";
	if(onpage!=1){
		str+='<a href="javascript:;'+$echo.replace("$pages",(onpage-1))+'" class="tf">&lt;上一页</a>';
	}
	var startPage=Math.floor((onpage-1)/10)*10+1;
	var endPage=startPage+9;
	for(var i=1;i<=ps;i++){
		if(i==onpage){
			str+='<strong>'+i+'</strong>';
		}else{
			if(i>=startPage&&i<=endPage){
				str+='<a href="javascript:'+$echo.replace("$pages",i)+'">'+i+'</a>';
			}
		}
	}
	if(onpage!=ps){
		str+='<a href="javascript:'+$echo.replace("$pages",(parseInt(onpage)+1))+'" class="tf">下一页&gt;</a>';
	}
	str+="</span>";
	$(obj).innerHTML=str;
}
function $time(t){
	var zero=function(m){if(m>9){return m}else{return "0"+m}}
	var a=new Array()
	t=t*1000
	t=new Date(t)
	a[0]=t.getFullYear()
	a[1]=zero(t.getMonth()+1)
	a[2]=zero(t.getDate())
	a[3]=zero(t.getHours())
	a[4]=zero(t.getMinutes())
	a[5]=zero(t.getSeconds())
	return a
}
var setTime={
	"format":function(t,k){		//格式化为2007-01-01 08:09
		var t=$time(t)
		if(k==null)
			return "<span class='f_10s'>"+t[0]+"-"+t[1]+"-"+t[2]+" "+t[3]+":"+t[4]+"</span>"
		else
			return t[0]+"-"+t[1]+"-"+t[2]+" "+t[3]+":"+t[4]
	},
	"del_sec":function(t){
		return "<span class='f_10s'>"+t.replace(/:\d\d$/,"")+"</span>"
	},
	"v_time":function(t){
		if(_servertime) {
			var now=new Date(_servertime*1000);
		}else{
			var now = new Date();
		}
		var front=new Date(t*1000);
		var x=now-t*1000;
		if(x<=60000){
			return "1分钟前";
		}
		if(x>60000&&x<3540000){
			return Math.floor(x/60000)+1+"分钟前";
		}
		var now_Date=new Date(now.getYear(),now.getMonth()+1,now.getDate());
		var front_Date=new Date(front.getYear(),front.getMonth()+1,front.getDate());
		var xx=(now_Date-front_Date)/86400000;
		var t=$time(t);
		if(xx==0){
			return "今天 "+t[3]+":"+t[4];
		}else{
			return parseInt(t[0],10)+"年"+parseInt(t[1], 10)+"月"+parseInt(t[2], 10)+"日"+" "+t[3]+":"+t[4];
		}
	},
	"visitor":function(t){
		if(_servertime) {
			var now=new Date(_servertime*1000);
		}else{
			var now = new Date();
		}
		var front=new Date(t*1000);
		var x=now-t*1000;
		if(x<=60000){
			return "1分钟前";
		}
		if(x>60000&&x<3540000){
			return Math.floor(x/60000)+1+"分钟前";
		}
		var now_Date=new Date(now.getYear(),now.getMonth()+1,now.getDate());
		var front_Date=new Date(front.getYear(),front.getMonth()+1,front.getDate());
		var xx=(now_Date-front_Date)/86400000;
		var t=$time(t);
		if(xx==0){
			return "今天 "+t[3]+":"+t[4];
		}else{
			return parseInt(t[1], 10)+"月"+parseInt(t[2], 10)+"日";
		}
	}
}
/**
 * ajax提交和获取
 * @param {Object} 请求地址
 * @param {Object} 参数列表
 * @param {Object} 执行函数
 * @param {Object} 是否将返回值直接放入执行函数
 * @param {Object} 是否是异步操作，true为异步，不填写为同步操作
 */
function SetAjax(url,parameter,echo,clear,open){
	var put="get";//提交类型
	if(parameter.slice(0,5)=="post:"){
		parameter=parameter.slice(5)
		put="post"
	}
	var req = null;
	if(window.XMLHttpRequest){
		req = new XMLHttpRequest();
	}else if(window.ActiveXObject){
		var msxml = new Array('MSXML2.XMLHTTP.5.0', 'MSXML2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP', 'Microsoft.XMLHTTP');
		for(var i=0;i<msxml.length;i++){
			try{
				req = new ActiveXObject(msxml[i]);
			    break;
			}catch(e){}
		}
	}
	var t=new Date()
	if(put=="get"){
		if(url.inc("?"))
			url+="&"+t.getTime()
		else
			url+="?"+t.getTime()			
		parameter=null
	}
	if(open==null){
		req.open(put,url, true);
	}else{
		req.open(put,url, false);
	}
	req.onreadystatechange = function(){
		if(req.readyState==4 && req.status==200){
			if(clear==null){
				if(typeof(echo)=="function"){
					eval("var back_join="+req.responseText);
					echo(back_join);
				}else if(typeof(echo)=="object"){
					//prompt("ddd",req.responseText)
					echo.innerHTML=req.responseText;
				}
			}else{
				echo(req.responseText);
			}
			try{
				put=null
				msxml=null
				req=null;
				CollectGarbage();
			}catch(e){}			
		}
	}
	req.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	req.send(parameter);
	//if (isIE && clear==null)
	//	window.attachEvent('onbeforeunload',function(){try{req.abort()}catch(e){}})
}

//获取事件对象的 x, y 座标 
//(考虑到有滚动条的情况, 与直接的 event.x 不同)
//@ add by xs | zhenhua1@staff.sina.com.cn
function getXY(e){
	var x = -1, y = -1;
	if (isIE) {
		x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
		y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
	}else{
		x = e.pageX;
		y = e.pageY;
	}
	return {x: x,  y: y};
}

//对象拖拽类
//@ add by xs | zhenhua1@staff.sina.com.cn
function objDrag(id) {
	var e = getEvent();
	var me = this;
	//容错
	this.el = (typeof id=='object'?id:$(id) );
	var pos = getXY(e);
	this._X = pos.x;
	this._Y = pos.y;
	this._Left  = parseInt(this.el.style.left, 10);
	this._Top   = parseInt(this.el.style.top,  10);
	
	//移动对象
	this.Drag =  function () {
		var ev = getEvent();
		var pos = getXY(ev);
		me.el.style.left = (me._Left + pos.x - me._X) + "px";
		me.el.style.top  = (me._Top  + pos.y - me._Y) + "px";
		stopEvent();
	}
	//释放对象
	this.StopDrag = function() {
		delEvent(document,"onmousemove", me.Drag);
		delEvent(document,"onmouseup", me.StopDrag);
		if(isIE) me.el.releaseCapture();
		me.el = null;
	}

	addEvent(document, "onmousemove", this.Drag);
	addEvent(document, "onmouseup", this.StopDrag);
	if(isIE) this.el.setCapture();
	stopEvent();
}

////////模拟窗体
//@ last changed by xs | zhenhua1@staff.sina.com.cn
var zindex=10000;
function _$w(){
	var me = this;
	var _title="信息提示";						///窗口标题
	var _content="";
	var _width, _height = -1;						//窗口宽/高 (默认为auto)
	var _x, _y											//窗口位置
	var dragobj={};								//拖拽全局变量
	
	var box, hoar								//对话框容器, 背景容器
	var wbody, _icon, wbody_r;			//窗体, 图标, 右侧容器(如果有图标的话)
	var top;									//层拖拽的头部
	var boxHTML;								//内容html
	var btBox, _bCenter = true, _inBox = false;						//按钮容器, 按钮对齐(默认居中),  按钮位置(容器内/外)
	var wclose;									//关闭窗口按钮
	var _autoClose = true;					//点按钮是否自动关闭(默认自动关闭)
	var _canClose = true;					//是否显示关闭按钮 (默认显示)
	var _canDrag = true;					//是否可以拖动 (默认不可拖动)
	var _transparency = false;			//背景是否透明
	var _hasBg	= true;					//是否生成遮盖背景
	var _winId = 'sinaDialog_';			//窗口 id
	var _Modeless = true;				//是否模态窗口
	var wiframe;							//遮盖iframe, 用于挡住下拉框

	
	//公用方法, 用于设置对话框参数
	this.title=function(title){if(title)_title = title; }
	this.content=function(nr){_content=nr; }
	this.canClose = function(cl) { if(!isNull(cl)) _canClose = cl;}
	this.autoClose = function(cl) { if(!isNull(cl)) _autoClose = cl;}
	this.canDrag  = function(dg) { if(!isNull(dg)) _canDrag = dg; }
	this.transparency = function(b){ if(!isNull(b)) _transparency = b; }
	this.bg	= function(b) { if(!isNull(b)) _hasBg = b; }
	this.ico = function(n) { if(!isNull(n)) _icon = n; }
	this.width=function(w){  _width = w; }
	this.height=function(h){	_height = h; }
	this.x=function(x){  _x = x; 	}
	this.y=function(y){	_y = y; }
	this.bCenter = function(a){ if(!isNull(a)) _bCenter = a; }
	this.inBox = function(b){ if(!isNull(b)) _inBox = b; }
	this.winId = function(s){ if(!isNull(s)) _winId = s; }
	this.Modeless = function(b){ if(!isNull(b)) _Modeless = b; }

	//生成对话框容器
	var createBox = function(){
			if(_hasBg){
				hoar=document.createElement("div");		//灰色背景
				zindex++
				hoar.id = "space_darkbg";
				var _alpha = "background-color:#000;filter:alpha(opacity=5);-moz-opacity:0.05;";
				if(_transparency) _alpha = "background:transparent;";
				hoar.style.cssText="position:absolute;width:100%;height:100%;"+_alpha+"top:0px;left:0px;z-index:"+zindex;
				if(isOpr)
					hoar.style.backgroundColor="";

				var pageSize = getPageSize();
					hoar.style.height=pageSize[1]+"px"
				if(isIE)
					hoar.style.width=pageSize[0]+"px";
				document.body.appendChild(hoar);
			}

			box=document.createElement("div");		//层窗口
			box.className = "fn_model";
			box.style.cssText="position:absolute;"+(_height == -1?'height:auto;':'')+"padding-bottom:15px;top:-1100px;left:-1100px;z-index:"+zindex;			

			if(_Modeless){
				zindex++;
				box.id = _winId + zindex;
			} else {
				if($(_winId)) oDel($(_winId));
				box.id = _winId;
			}
			
			wbody = document.createElement("div");
			box.appendChild(wbody);

			if(_width) wbody.style.width = box.style.width = _width + "px";
			if(_height && _height != -1) wbody.style.height = box.style.height = _height + "px";
	}

	//设置阴影 (iframe遮盖)
	var shadow = function(){
			wiframe = document.createElement("iframe");
			wiframe.src="about:blank";
			wiframe.style.cssText="position:absolute;width:100%;top:0px;left:0px;filter:alpha(opacity=0);-moz-opacity:0;z-index:1;";
			if(isOpr)
				wiframe.style.display="none";
			(hoar||document.body).appendChild(wiframe);
	}
	
	var dragStop;
	var setTop = function(){					///拖拽头部
			var sp = document.createElement("span");
			wclose = document.createElement("a");
			if(isIE) wclose.style.fontWeight = 'bold';
			if(_canClose){
				wclose.innerHTML = "×";
				wclose.href = 'javascript:;';
				wclose.onclick = function(){
					me.close();
				}
			}
			sp.appendChild(wclose);
			var t = document.createElement("strong");
				t.innerHTML = _title;
			top = document.createElement("div");
			bar = document.createElement("div");
			bar.style.cssText="position:relative;left:-10px;padding-left:10px;width:90%; height:100%; margin:0;cursor:"+(_canDrag?'move':'default')+";-moz-user-select: none";
			top.className = "top";

			bar.appendChild(t);
			top.appendChild(sp);		
			top.appendChild(bar);
			
			wbody.appendChild(top);

			if(_canDrag){
				bar.onmousedown = function(){
					//拖拽窗口，调用拖拽类
					new objDrag(box);
					new objDrag(wiframe);
				}
			}
			top.onselectstart=function(){return false;}
	}	
	
	var setContent=function(){				//窗口内容HTML
		boxHTML=document.createElement("div");
		boxHTML.className = "con fn_layer";
		//图标
		if(_icon && !isNaN(_icon)){
			var icoArr = ['09', '07', '12', '03'];
			var sIco = '<div class="layer_l" style="padding-top:15px;"><img src="http://www.sinaimg.cn/pay/space/images2/images/fuen/layer_icon_'+icoArr[_icon-1]+'.png" width="40" height="45" /></div>';
			boxHTML.innerHTML = sIco;
			wbody_r = document.createElement("div");
			wbody_r.className = "layer_r";
			var bw = (_width?_width - 90 + 'px' : '80%');
			wbody_r.style.width = bw;
			wbody_r.style.paddingTop = '30px';
			boxHTML.appendChild(wbody_r);
		}
		//按钮容器
		btBox = document.createElement("p");
		btBox.className = _bCenter?"p_btn p_c":"p_btn"; //按钮位置 (默认为不居中)
		_bCenter?btBox.style.textAlign="center":'';
		
		var clear = document.createElement("div");
			 clear.className = "fn_clear";
		boxHTML.appendChild(clear);
		wbody.appendChild(boxHTML);

		if(wbody_r) {
			wbody_r.innerHTML = '<p class="p_bold">'+_content+'</p>';
			(_inBox?wbody_r:wbody).appendChild(btBox);
		}else{
			boxHTML.innerHTML=_content;
			wbody.appendChild(btBox);
		}
	}

	
	///设置窗体
	var set_wbody=function(){	
		setTop();							//插入窗口头部
		setContent();						//插入窗口内容HTML
	}

	///关闭窗体操作
	this.close = function(){					
		oDel(box);
		if(hoar) oDel(hoar);
		if(wiframe) oDel(wiframe);
		if(isIE){
			try{
				dragstop=dragobj=wbody=wbody2=top=boxHTML=btBox=wclose=wiframe=shadow=setTop=setContent=set_wbody=close=null;
				CollectGarbage();
			}catch(e){}
		}
	}
	
	///添加按钮
	this.addbt=function(value,echo,k1,k2, focus){
		var sp = document.createElement("span");
		var bt=document.createElement("a");
		bt.style.marginLeft = bt.style.marginRight =  "6px";
		bt.href="javascript:void(0);";
		bt.className= "btn_inline";
		bt.innerHTML = "<span><cite>　" + value + "　</cite></span>";
		bt.onclick = function(){ return false; };
		//bt.onfocus = function(){ this.blur(); };
		sp.appendChild(bt);

		btBox.appendChild(sp);
		sp.onmousedown = function () {
			stopEvent();
		}
		sp.onclick = function(){
			if(typeof(echo)=="function"){
				if(echo(k1,k2, me)==false) return false;
			}else{
				eval(echo)
			}
			if(_autoClose) me.close();
			return false;
		}
		setTimeout(function(){
			box.focus(); box.blur(); //fix firefox focus
			if(focus) sp.focus();
		},300);
	}
	
	//显示窗体
	this.show=function(){
		createBox();
		shadow();
		set_wbody();
		document.body.appendChild(box);
	}
	//设置窗体位置
	this.setWindow=function(){
		var wbody_height=box.offsetHeight;			//获取窗口高度
		var box_h=box.offsetHeight;
		var box_w=box.offsetWidth;

		//判断是否超过浏览器边界
		if(_x + box_w > getbodyCW()) 
			box.style.left= _x - box_w + "px";
		else
			box.style.left= (!_x?(getbodyCW()-box_w)/2:_x) +"px";

		box.style.top= (!_y?(scrolltop()+(showbodyCH()-box_h)/2):_y) + "px";
		if(!isOpr){
			wiframe.style.width=box_w+"px";
			wiframe.style.height= (box_h + 30)+"px";
			wiframe.style.left= box.style.left;
			wiframe.style.top= box.style.top;
		}

	}
	
}
////////////模拟窗体结束
//普通提示框 
//@ last changed by xs | zhenhua1@staff.sina.com.cn
function msg(nr,echo,title,k1,k2, bAlert, opt){
	
	if(typeof opt != 'object') opt = {title: title};

	var ok = {value : opt.val_ok || "确定", echo: echo, k1: k1, k2: k2, focus: opt.fok };
	var cancle = {value : opt.val_cancle || "取消", focus: opt.fcancle};
	opt.btns = opt.btns || [ok];
	//按钮默认值 (兼容旧的 bAlert参数)
	if(!isNull(bAlert)) opt.btns = bAlert?[ok]:[ok, cancle]; 
	return pop(nr,  opt);
}

/**
 * 错误信息提示 (msg二次封装, 主要修改参数方便调用)
 */
function errTips(errMsg, ico, echo, k1, k2, bAlert, opt){
	ico = ico || 3;
	if(!opt) opt = {};
	msg(errMsg, echo, opt.title,  k1, k2, bAlert, {
		ico: ico,
		w: opt.w || 0,
		h: opt.h || 0,
		fok: opt.fok || true,
		ib: opt.ib || false,
		ac: opt.ac,
		x:opt.x || "",
		y:opt.y || ""
	});
}

/**
 * 用于判断参数是否真的为空 (而不是 false);
 *@author  xs 
 */
function isNull(a){
	if(!a && typeof a == 'boolean') return false;
	return (typeof a == 'undefined' || a == '' || a == null);
}

//扩展功能提示框 (自定宽,高,按钮等)
//@ add by xs | zhenhua1@staff.sina.com.cn
function pop (nr, opt) {
	//默认值
	if(typeof opt != 'object') opt = {
		title: '',
		w: '',
		h: '',
		btns : []		 //自定按钮(对象数组)
	};
	var w=new _$w();
	w.title(opt.title);
	w.width(opt.w);
	w.height(opt.h);
	w.x (opt.x);
	w.y (opt.y);
	w.content(nr);
	w.autoClose(opt.ac);
	w.canClose(opt.close);
	w.canDrag(opt.drag);
	w.transparency(opt.trans);
	w.bg(opt.bg);
	w.ico(opt.ico);
	w.bCenter(opt.bc);
	w.inBox (opt.ib);
	w.Modeless (opt.mod);
	w.winId (opt.wid);
	setTimeout(function () {
		w.show();
		w.setWindow();
		for (var b =opt.btns, i=0, l = b.length; i<l; i++) {
			var cur = b[i];
			var v = cur.value;
			if(v){
				var echo = cur.echo || function(){};
				var k1 = cur.k1 || null;
				var k2 = cur.k2 || null;
				var fc  = cur.focus;
				w.addbt(v, echo, k1, k2, fc);
			}
		}
		
	}, 10);
	return w;
}

////浮动的层 (固定不可移动)
function setAw(obj,w,h, opt){
	var pos = objxy(obj);

	var ok = {value : "确定", focus: true};
	var cancle = {value : "取消"};

	if(typeof opt != 'object') opt = {title: '',  content: '' };
	opt.y = pos[0] + pos[3];
	opt.x = pos[1];
	opt.w = w;
	opt.h = h;
	opt.close = true;
	opt.drag = false;
	opt.btns = opt.btns || [ok, cancle];
	opt.trans = true;
	opt.bg = false;
	opt.mod = false;
	opt.wid = 'Sina_AW';
	opt.ac = opt.ac;
	return pop(opt.content, opt);
}

//setAw例子
function testAw(o){
	//o是点击的对象
	var aw = setAw(o, 410, 150, {title: '提示', content: 'content'} );
	//关闭层就使用 aw.close();
}

///格式化中文
function formatS(str){
	unescape(str)
}
function two(bin){
	var k=new Array()
	while(bin){
		m = 1&bin;
		bin>>=1;
		k.add(m.toString())
	}
	return k
}
//访客2级删除访客
function del_fk(vid,time,pid){
	var back_del_fk=function(json){
		if(json.status==1){
			$(vid).style.display=""
			$("fk"+vid).style.display="none"
		}else
			errTips(json.error)
	}
	SetAjax("/visitor/aj_delvisitor.php?ownerid="+spaceinfo.uid+"&vid="+vid+"&pid="+pid+"&vtime="+time,"",back_del_fk)
}
function hidden_fk(){location.reload()}
function addblack(fid){
	var back_addblack=function(json){location.reload()}
	SetAjax("/friend/aj_addblacklist.php?fid="+encodeURIComponent(fid),"",back_addblack)
}
//隐藏显示开关
function toggle(d){
	d.style.display=d.style.display=="none"?"":"none";
}

//表单获取焦点后清空
function cleanout(obj,key){
	if(obj.value.inc(key))
		obj.value="";
}

//初始化登录名动态提示层
function initCardTips(obj1, obj2){

		var  addCss = function(h){
				 if(check('link','href','cardtips.css')) return;
				 var s = d.createElement('link');
				 s.rel = 'stylesheet';
				 s.type = 'text/css';
				 s.href = 'http://spaceimg.sinajs.cn/view/css/cardtips.css';
				 h.appendChild(s);
				 return s;
		}
		var  addJS = function(h){
				 if(check('script','src','cardtips.js')) return;
				 var s = d.createElement('script');
				 s.type="text/javascript"
				 s.language = 'javascript';
				 s.src = 'http://spacejs.sinajs.cn/view/js/cardtips.js';
				 h.appendChild(s);
				 return s;
		}
		var check = function(tag, name, url){
			var ss = document.getElementsByTagName(tag);
			for (var i=0;i<ss.length;i++) if (ss[i][name]&&ss[i][name].indexOf(url)!=-1) return true;
		}
		if(typeof passcardOBJ == 'undefined' || !passcardOBJ){
			//动态载入所需脚本及css
			var d = document;
			var h = d.getElementsByTagName("head")[0];
			addCss(h);
			addJS(h);
			var me = arguments.callee;
			setTimeout(function(){
				me(obj1, obj2);
			}, 500);
			return;
		}

		obj1 = typeof obj1=='string'?$(obj1):obj1;
		obj2 = typeof obj2=='string'?$(obj2):obj2;
		if(!obj1) return;
		passcardOBJ.init(
			// FlashSoft 注意,最好这个input的autocomplete设定为off
			// 需要有下拉框的input对象
			obj1,
			{
			// 鼠标经过字体颜色
			overfcolor: "#999",
			// 鼠标经过背景颜色
			overbgcolor: "#e8f4fc",
			// 鼠标离开字体颜色
			outfcolor: "#000000",
			// 鼠标离开背景颜色
			outbgcolor: ""
			},
			// 输入完成后,自动需要跳到的input对象[备选]
			obj2);
			obj1.focus();
}

//验证码地址
var _CodeUrl = 'http://space.sina.com.cn/CheckCode.php?type=';
///加好友浮层
function ajfriend(obj,uid,nickname, pic){
	var slogin = '';
	if(!_islogin) slogin = ' <p class="p_red">您还未登录，请先登录！</p>\
		<p style="margin:3px 0;"><label for="loginname_txt">登录名：<input type="text" size="15" class="input_bor" style="width:82px;height:17px" autocomplete="off" id="loginname_txt" name="user" /></label> &nbsp;\
         <label for="loginpwd_txt">密码：<input type="password" size="15" class="input_bor" style="width:69px;height:17px" id="loginpwd_txt" name="password" /></label> &nbsp;<a href="http://login.sina.com.cn/getpass.html" target="_blank">找回密码</a> &nbsp;<span style="color:#ccc">|</span>&nbsp; <a href="http://login.sina.com.cn/hd/reg.php?entry=space" target="_blank">注册</a></p>';

	var scode = '<p class="p_img" id="af_code" style="display:'+(_needcode?'block':'none')+'"><label for="ct_ipt_3">验证码：<input  id="ct_ipt_3" name="checkcode" type="text" class="input_bor" size="6" maxlength="4" /></label>\
     <img id="friend_checkImg" align="absmiddle" onerror="this.src=\''+_CodeUrl+'3&\'+ts()" onclick="this.src=\''+_CodeUrl+'3&\'+ts()"  style="cursor:pointer" src="'+_CodeUrl+'3&'+ts()+'"  width="51" height="16" /></p>';

	 //头像
	 pic = pic || 'http://portrait'+(uid%8+1)+'.sinaimg.cn/'+uid+'/blog/50';
	var struc = '<form name="fm_friend" onsubmit="return false;"><p class="p_bold" style="margin-bottom:2px;">加'+nickname+'为好友吗？</p>'+slogin+'\
         <div class="fn_lay_box">\
       	   <div class="lay_box_l"><a href="http://space.sina.com.cn/u/'+uid+'"><img src="'+pic+'" width="50" height="50" /></a></div>\
            <div class="lay_box_r">\
           	  <p id="fm_ftype">好友类型：<input name="ftype" type="radio" id="t2" value="1" /><label for="t2">同学</label> <input name="ftype" type="radio" id="t3"  value="2" /><label for="t3">同事</label> <input name="ftype" type="radio" id="t4"  value="3" checked="checked" /><label for="t4">朋友</label> <input name="ftype" type="radio" id="t5"  value="4" /><label for="t5">家人</label><input name="ftype" type="radio" id="t1" value="0" /><label for="t1">网友</label></p>\
                <p id="fm_realname" style="visibility:hidden">真实姓名：<input name="realname" id="ipt_realname" type="text" class="input_bor" /></p> \
				<div id="fm_rtip" style="visibility: hidden;"><p>填写真实姓名将有助于您的朋友方便联络您</p><p style="visibility:hidden">选择“同事”类型需要向对方显示您的真实姓名</p></div>\
            </div>\
            <div class="fn_clear"></div>\
         </div>\
         <p><textarea name="msg" cols="" rows="3" style="width:350px; height:50px;*height:50px;" onkeyup="strsize(this,200,\'ajfriend_txt\')" onblur="strsize(this,200,\'ajfriend_txt\')"  onfocus="cleanout(this,\'填写附加留言，限100个汉字...\');" class="input_bor">填写附加留言，限100个汉字...</textarea><span  id="ajfriend_txt" style="color:#666;font-weight:normal;margin-right:10px;float:right;">&nbsp;</span><div class="fn_clear"></div>'+scode+'</p></form>';

	//按钮及事件回调
	var btns = [
			{
				value : "加好友",
				focus : true,
				echo : joinfriend,
				k1:uid,
				k2:nickname
			},
			{
				value : "取消",
				echo : function(k1,k2,w){
					w.close();
				}
			}			
		];
//	//动态控制宽高
//	var h = 298;
//	if(!slogin) h -= 30;
//	if(!scode) h -= 20;
	var aw = setAw(obj, 0, -1, {title: '加好友', content: struc,  btns : btns, ac : false} );
	setTimeout(function(){
		initCardTips('loginname_txt', 'loginpwd_txt');
		if($('fm_ftype')){
			var opt = $('fm_ftype').getElementsByTagName('input');
			for (var i=0; i<opt.length; i++) {
				if(opt[i].name=='ftype') 
					opt[i].onclick = function(){
						var chk = (this.checked && this.value!="0");
						$('fm_realname').style.visibility = chk?'visible':'hidden';
						$('fm_rtip').style.visibility = chk?'visible':'hidden';
						if(!_realname){
				        	$('fm_realname').style.visibility = 'visible';
				        	$('fm_rtip').style.visibility = 'visible';
				        }else{
							$('fm_realname').style.visibility = 'hidden';
				        	$('fm_rtip').style.visibility = 'hidden';
						}
						$('fm_rtip').innerHTML = chk?'选择“'+this.nextSibling.innerHTML+'”类型需要向对方显示您的真实姓名':'不让你看';
					}
			}
		}
		if($('ipt_realname')&&typeof _realname !='undefined') $('ipt_realname').value =_realname;
		if(!_realname){
        	$('fm_realname').style.visibility = 'visible';
        	$('fm_rtip').style.visibility = 'visible';
        }
	}, 100);
}
function joinfriend(uid,nickname, win){

	//判断是否显示验证码
	var checkCode = function(need){
			if(need){
				_needcode = 1;
				if($('af_code')) $('af_code').style.display = 'block';
				if($("friend_checkImg")) 
					setTimeout(function(){
						$("friend_checkImg").src=_CodeUrl+'3&'+ts();
					},20);
			}
	}
	var back_joinfriend=function(json){
		if(json.status==1){
			var ft = document.forms["fm_friend"]['ftype'][0].checked;
			if(!ft){
				var req = _modifyRealname($('ipt_realname').value);
				if(req.status==1){
					if(win) win.close();
					errTips("您发给 "+nickname+" 的好友邀请发送成功，请等待对方确认。", 1, function(){
						if(!_islogin) location.reload();
					});
				}else{
					errTips(req.error);
				}
			}else{
					if(win) win.close();
					errTips(json.error, 1, function(){
						if(!_islogin) location.reload();
					});
			}
			checkCode(json.needcode);
		}else{
			errTips(json.error);
			checkCode(json.needcode);
		}
	}
	var fm=document.forms["fm_friend"]
	var k=new Array()
	for(var i=0;i<fm.length;i++){
		if(fm[i].name=="user"){
			if(fm[i].value==""||fm[i].value=="会员名/手机/UC号"){
				errTips("请输入登录名！")
				fm[i].focus()
				return false;
			}
		}
		if(fm[i].name=="password"){
			if(fm[i].value==""){
				errTips("请输入密码！")
				fm[i].focus()
				return false;
			}
		}
		
		if(fm[i].name=="checkcode"&&$('af_code')&&$('af_code').style.display!='none'){
			if(fm[i].value==""){
				errTips("请输入验证码！")
				fm[i].focus()	
				return false;
			}
		}
		if(fm[i].name=="msg"){
				if(fm[i].value=="填写附加留言，限100个汉字...") fm[i].value="";
		}
		if(fm[i].name=="ftype" && !fm[i].checked) continue;
		k.add(fm[i].name+"="+encodeURIComponent(fm[i].value));
	}

	SetAjax("/friend/aj_addfriendreq.php","post:pid=9&fid="+uid+"&"+k.join("&"), back_joinfriend);
}
///发纸条
function sendmsg(obj,toid,nickname,key){
	var slogin = '';
	if(!_islogin) slogin = '<!--<p class="p_red">您还未登录，请先登录！</p>-->\
		<p style="margin:3px 0;"><label for="loginname_txt">登录名：<input type="text" size="15" class="input_bor" autocomplete="off" id="loginname_txt" name="loginname" /></label> \
         <label for="loginpwd_txt">密码：<input type="password" size="15" class="input_bor" id="loginpwd_txt" name="password" /></label> <a href="http://login.sina.com.cn/hd/reg.php?entry=space" target="_blank">注册</a></p>';

	var scode = '<p class="p_img" id="sm_code" style="display:'+(_needcode?'block':'none')+'"><label for="ct_ipt_3">验证码：<input  id="ct_ipt_3" name="checkcode" type="text" class="input_bor" size="6" maxlength="4" /></label>\
     <img id="msg_check" align="absmiddle" onerror="this.src=\''+_CodeUrl+'2&\'+ts()" onclick="this.src=\''+_CodeUrl+'2&\'+ts()"  style="cursor:pointer" src="'+_CodeUrl+'2&'+ts()+'" /></p>';

	var struc = '<form name="fm_sendmsg" onsubmit="return false;">\
					<p class="p_bold" style="margin-bottom:2px;">'+(!key?'发送':'回复')+'纸条给：'+nickname+'&nbsp;\
					<span  id="guestbook_txt" style="color:#666;font-weight:normal;"></span></p>'+slogin+'\
					<p><textarea cols="" rows="3" style="width:350px; height:95px;*height:95px;word-wrap:break-word;word-break:break-all;" name="content" onkeyup="strsize(this,300,\'guestbook_txt\')" onblur="strsize(this,300,\'guestbook_txt\')" onfocus="cleanout(this,\'您最多可以输入150个汉字...\');"  id="msg_content" class="input_bor">您最多可以输入150个汉字...</textarea>'+scode+'</p></form>';

	//按钮及事件回调
	var btns = [
			{
				value : "发送",
				echo : send_msg,
				k1:toid,
				k2:nickname,
				focus: true
			},
			{
				value : "取消",
				echo : function(k1,k2,w){
					w.close();
				}
			}			
		];
//动态控制宽高
//	var h = 248;
//	if(!slogin) h -= 30;
//	if(!scode) h -= 20;
	var aw = setAw(obj, 0, -1, {title: '发纸条', content: struc,  btns : btns, ac: false} );
	setTimeout("initCardTips('loginname_txt', 'loginpwd_txt')", 100);
}
//提交发纸条
function send_msg(toid,nickname, win, key, fname){
	//判断是否显示验证码
	var checkCode = function(need, reload){
			if(need){
				_needcode = 1;
				if($('sm_code')) $('sm_code').style.display = 'block';
			}
			if(reload){
				var check = $("msg_check") || $("md_check");
				if(check){
					setTimeout(function(){
							check.src= _CodeUrl + '2&'+ts();
					},20);
				}
			}
	}

	var back_sendmsg=function(json){
		if(typeof $pageid =='undefined') $pageid = '';
		if(json.status==1){
			if(win) win.close();
			errTips("给"+nickname+"的纸条已成功发送！", 1, function(){
					if(!_islogin || !win || $pageid=='detail') location.reload();
			});
			//处理验证码
			checkCode(json.needcode);
		}else{
			errTips(json.error, 3, function(){
				if(win) win.close();
			});
			checkCode(json.needcode, true);
		}
	}
	var fm=document.forms[fname||"fm_sendmsg"];
	var k=new Array()
	for(var i=0;i<fm.length;i++){
		if(fm[i].name=="loginname"){
			if(fm[i].value==""||fm[i].value=="会员名/手机/UC号"){
				errTips("请输入登录名！");
				fm[i].focus();
				return false;
			}
		}
		if(fm[i].name=="password"){
			if(fm[i].value==""){
				errTips("请输入密码！")
				fm[i].focus()
				return false;
			}
		}
		
		if(fm[i].name=="checkcode"){
			if(fm[i].value==""&&$('sm_code')&&$('sm_code').style.display!='none'){
				errTips("请输入验证码！")
				fm[i].focus()	
				return false;
			}
		}
		if(fm[i].name=="content" && (fm[i].value=="您最多可以输入150个汉字..."||fm[i].value=='')){
			errTips("请输入纸条内容！");
			fm[i].focus();
			return false;
		}
		k.add(fm[i].name+"="+encodeURIComponent(fm[i].value))
	}
	var fromid=""
	if(_islogin) fromid="&fromid="+_cuid;
	key = key?"&re=1":'';
	SetAjax("/message/aj_sendmsg.php","post:pid=9"+fromid+"&toid="+toid+key+"&"+k.join("&"),back_sendmsg);
}

///写留言
function leaveword(obj,_ouid,nickname){
	var slogin = '';
	if(!_islogin) slogin = '<!--<p class="p_red">您还未登录，请先登录！</p>-->\
		<p style="margin:3px 0;"><label for="loginname_txt">登录名：<input type="text" size="15" class="input_bor" autocomplete="off" id="loginname_txt" name="user" /></label> \
         <label for="loginpwd_txt">密码：<input type="password" size="15" class="input_bor" id="loginpwd_txt" name="password" /></label> <a href="http://login.sina.com.cn/hd/reg.php?entry=space" target="_blank">注册</a></p>';

	var scode = '<p class="p_img" id="lw_code" style="display:'+(_needcode?'block':'none')+'"><label for="ct_ipt_3">验证码：<input  id="ct_ipt_3" name="checkcode" type="text" class="input_bor" size="6" maxlength="4" /></label>\
     <img id="lw_check" align="absmiddle" onerror="this.src=\''+_CodeUrl+'1&\'+ts()" onclick="this.src=\''+_CodeUrl+'1&\'+ts()"  style="cursor:pointer" src="'+_CodeUrl+'1&'+ts()+'"  width="51" height="16" /></p>';

	var struc = '<form name="fm_leaveword" onsubmit="return false;">\
					<p class="p_bold" style="margin-bottom:2px;">给'+nickname+'写留言&nbsp;\
					<span  id="guestbook_txt" style="color:#666;font-weight:normal;"></span></p>'+slogin+'\
					<p><textarea cols="" rows="3" style="width:350px; height:95px;*height:95px;word-wrap:break-word;word-break:break-all;" name="content" onkeyup="strsize(this,600,\'guestbook_txt\')" onblur="strsize(this,600,\'guestbook_txt\')" onfocus="cleanout(this,\'您最多可以输入300个汉字...\');"  id="msg_content" class="input_bor">您最多可以输入300个汉字...</textarea>'+scode+'</p></form>';

	//按钮及事件回调
	var btns = [
			{
				value : "发表留言",
				echo : send_word,
				k1: [obj, _ouid],
				k2: nickname,
				focus: true
			},
			{	
				value : "取消",
				echo : function(k1,k2,w){
					w.close();
				}
			}			
		];

//动态控制宽高 (现改参数为 -1 , 自适应宽高)
//	var h = 248;
//	if(!slogin) h -= 30;
//	if(!scode) h -= 20;
	var aw = setAw(obj, 0, -1, {title: '写留言', content: struc,  btns : btns, ac : false} );
	setTimeout("initCardTips('loginname_txt', 'loginpwd_txt')", 100);
}
//提交留言
function send_word(o,nickname, win){
	var obj = o[0];
	var _ouid = o[1];

	//判断是否显示验证码
	var checkCode = function(need){
			if(need){
				_needcode = 1;
				if($('lw_code')) $('lw_code').style.display = 'block';
				if($("lw_check")) 
					setTimeout(function(){
						$("friend_checkImg").src= _CodeUrl + '1&' + ts();
					} ,20);
			}
	}
	var back_sendword=function(json){
		if(json.status==1){
			if(win) win.close();
			errTips("给"+nickname+"的留言已成功发送！", 1, function(){
				if(!_islogin) location.reload();
			});
			//处理验证码
			checkCode(json.codetype);
		}else{
			errTips(json.error,'', function(){
				win.close();
			});
			checkCode(json.codetype);
		}
	}
	var fm=document.forms["fm_leaveword"]
	var k=new Array()
	for(var i=0;i<fm.length;i++){
		if(fm[i].name=="loginname"){
			if(fm[i].value==""||fm[i].value=="会员名/手机/UC号"){
				errTips("请输入登录名！")
				fm[i].focus()
				return false;
			}
		}
		if(fm[i].name=="password"){
			if(fm[i].value==""){
				errTips("请输入密码！")
				fm[i].focus()
				return false;
			}
		}
		
		if(fm[i].name=="checkcode"&&$('lw_code')&&$('lw_code').style.display!='none'){
			if(fm[i].value==""){
				errTips("请输入验证码！")
				fm[i].focus()	
				return false;
			}
		}
		if(fm[i].name=="content" && (fm[i].value=="您最多可以输入300个汉字..."||fm[i].value=='')){
			errTips("请输入留言内容！")
			fm[i].focus()
			return false;
		}
		k.add(fm[i].name+"="+encodeURIComponent(fm[i].value))
	}
	SetAjax("/wall/aj_addwall.php","post:ownerid="+_ouid+"&"+k.join("&"), back_sendword);
}

//加入黑名单确认
function aj_black(bid){
	errTips("您确认将该用户加入到黑名单？", 4, function(){
			SetAjax("/friend/aj_addblacklist.php?fid="+bid,"",  function(json){
				errTips(json.error);
			});
	},'','',false);
}
//设置邮件数
function set_mail(){
	if($("mailcount")!=null){
		if(sinamailinfo.result==true){
			$("mailcount").innerHTML="（"+sinamailinfo.unreadmail+"）"
			$("mailcount").style.display=""
			$("mailurl").href=sinamailinfo.url
		}
	}
}

function set_msg_10(){
	function viewData(nIndex) {
		if (msgArr.length < 2) {
			$("top10_msg_box_prvBtn").style.visibility = "hidden";
			$("top10_msg_box_nextBtn").style.visibility = "hidden";
		}else{
			if (nIndex < 1) {
				$("top10_msg_box_prvBtn").style.visibility = "hidden";
				$("top10_msg_box_nextBtn").style.visibility = "visible";
			}else{
				if(nIndex + 1 == msgArr.length) {
					$("top10_msg_box_nextBtn").style.visibility = "hidden";
					$("top10_msg_box_prvBtn").style.visibility = "visible";
				}else{
					$("top10_msg_box_prvBtn").style.visibility = "visible";
					$("top10_msg_box_nextBtn").style.visibility = "visible";
				}
			}
		}
		$("top10_msg_box_content").innerHTML = '<p>' + msgArr[nIndex] +'</p>';
	}
	var viewIndex = 0;
	//var top10MSG={"msgs":["adfasdfasdfasdfasdfasdf","我是谁","hello"],"morelink":"\/syslog\/syslog.php"};
	top10MSG = typeof top10MSG =='undefined'?{}:top10MSG;
	top10MSG = top10MSG || {};
	var msgArr = top10MSG.msgs;
	var msgMore = top10MSG.morelink;
	if(msgArr.length == 0)return;
	if($("top10_msg_box")==null){
		var box=document.createElement("DIV")
		box.setAttribute("id","top10_msg_box")
	}else{
		var box=$("top10_msg_box")
	}
	box.style.cssText="position: absolute;"
	var xy=objxy($("homelink"));
	box.style.top=(xy[0]+xy[3]+7)+"px";
	if(isMoz){
		if(document.body.clientWidth/2<xy[1]){
			box.style.left=(xy[1]-80+xy[2])-155+"px";
		}else{
			box.style.left=xy[1]-159+"px";
		}
	}else{
		if(document.body.clientWidth/2<xy[1]){
			box.style.left=(xy[1]-80+xy[2] + 10)-165+"px";
		}else{
			box.style.left=xy[1] + 10-141 +"px";
		}
	}
	var str='\
		<iframe src="about:blank" style="width:280px;height:165px;position:absolute;top:0;left:0;z-index:-10;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;"></iframe>\
		<div style="width:280px;height:auto !important" class="fn_model">\
		<div class="top">\
			<span><a href="javascript:;" id="top10_ct_ipt_2_close">×</a></span>\
			<strong>系统消息</strong>\
		</div>\
		<div class="fn_layer con" style="padding:" id="top10_msg_box_content">\
		</div>\
		<p style="padding:5px;text-align:right"><a href="javascript:;" id="top10_msg_box_prvBtn">上一页</a>&nbsp;&nbsp;<a href="javascript:;" id="top10_msg_box_nextBtn">下一页</a>&nbsp;&nbsp;<a href="javascript:;" id="top10_msg_box_morelink">查看全部</a></p>\
		</div>\
		';
	box.innerHTML=str;
	setTimeout(function () {
		document.body.appendChild(box);
		viewData(viewIndex);
		$("top10_msg_box_morelink").href=msgMore;
		$("top10_msg_box_prvBtn").onclick = function () {
			if(viewIndex < 2) {
				viewIndex = 0;
			}else{
				viewIndex--;
			}
			viewData(viewIndex);
		}
		$("top10_msg_box_nextBtn").onclick = function () {
			if(viewIndex + 2 == msgArr.length) {
				viewIndex = msgArr.length - 1;
			}else{
				viewIndex ++;
			}
			viewData(viewIndex);
		}
		$("top10_ct_ipt_2_close").onclick=function () {
			box.style.display="none";
		};
	},1000);
};
function GetCookie(_Name){
	var Res = eval('/'+_Name+'=([^;]+)/').exec(document.cookie);
	return Res == null ? false : Res[1];
}
function SetCookie(n, v, e, p){
	var cookiestr = n + "=" + escape(v) + "; ";
	if (!isNull(e) && !isNaN(e)){
		var d=new Date();
		d.setTime(d.getTime() + e * 1000);
		cookiestr += "expires=" + d.toGMTString() + "; ";
	}
	cookiestr += "domain=space.sina.com.cn; ";
	if (!isNull(p)){
		cookiestr += "path=" + p + "; ";
	}
	else{
		cookiestr += "path=/; ";
	}
	document.cookie = cookiestr;
}
//留言回复
function gbhidden(gid){$('reform'+gid).style.display='none'}
function gbsubmit(gid){addwall($('fm_'+gid),'aj_reply')}


function writeGbook(sStr) {
	$("ajaxbottom").innerHTML = sStr;
	initCardTips('gbookUser', 'gbookPass');
}
	
/**
 * 检查是否安装了魔方客户端
 * @private
 * @return {Boolean} 如果安装了则返回true,反之则为false
 */
function checkMofunClient() {
	try{
		var obj= new ActiveXObject("SinaMofun.MofunActivex");
		obj = null;
		return true;
	}
	catch(e) {
		return false;
	}
}
/**
 * 调用魔方
 * @param {Object} nUID
 * @author FlashSoft | fangchao@staff.sina.com.cn
 */
function callMofun (nUID) {
	if($("mofundownload_box")==null){
		var box=document.createElement("DIV")
		box.setAttribute("id","mofundownload_box")
	}else{
		var box=$("mofundownload_box")
	}
	box.style.cssText="position: absolute;left:0;top:0"
	var str = '\
		<div class="ct_layer" id="mofundownload_box_content">\
			<div class="ct_main">\
				<dl class="ct_cnt ct_mcube">\
					<dt>您还未安装新浪魔方，无法进行即时聊天</dt>\
					<dd>\
						<ul class="ct_tbl ct_tbl3">\
							<li class="ct_msg3">使用新浪通行证、UC号、新浪邮箱均可登录魔方。</li>\
							<li>\
								<div class="ct_mcube_area"><a href="http://mofun.sina.com.cn/index1.html" target="_blank" class="ct_mcube_sign"></a><p class="ct_mcube_btns"><a href="http://mofun.sina.com.cn/help.html" target="_blank" class="ct_mcube_more" title="了解新浪魔方">了解新浪魔方</a><a target="_blank" href="http://mofun.sina.com.cn/download.html" class="ct_mcube_down" title="下载新浪魔方">下载新浪魔方</a></p>\
								</div>\
							</li>\
						</ul>\
					</dd>\
				</dl>\
				<a href="#" class="close_b" title="关闭" id="mofundownload_box_close"></a>\
			</div>\
			<div class="ct_shadow"></div>\
		</div>\
		';
	box.innerHTML=str
	document.body.appendChild(box);
	box.style.visibility = "hidden";
	
	if (checkMofunClient()) {
		try {
			var obj = new ActiveXObject("SinaMofun.MofunActivex");
			obj.IMChat(nUID);
		} 
		catch (e) {}
	}
	else {
		/** FireFox浏览器 */
		if(isMoz) {
			alert("FireFox不支持此功能,请使用IE浏览器!");
			return;
		}
		box.style.visibility = "visible";
		/** 如果是都判断不出来,则显示魔方下载层 */
		var contentBox = $("mofundownload_box_content");
		var mofunTipWidth = contentBox.offsetWidth;
		var mofunTipHeight = contentBox.offsetHeight;
		
		var pageSize = getPageSize();
		
		box.style.left = (pageSize[2] - mofunTipWidth) / 2 + "px";
		box.style.top = ((pageSize[3] - mofunTipHeight) / 2 + scrolltop()) + "px";
	}
	
	
	
	addEvent($("mofundownload_box_close"),"onmousedown", function () {
		box.style.visibility="hidden";
	});
};
function get_MofunStatus () {
	if (SpaceCardMofunOnline[spaceinfo.uid] == "1") {
		$("mofun_client_btn").className = "btnSize4 btnChat";
	}
}
/**互动icon
 * 使用方法php打印的<a href="javascript:;" onclick="activeIcon(this,uid)"><img src="http://www.sinaimg.cn/pay/space/images2/images/icon/icon18.gif" style="vertical-align:middle" /></a>
 * 其中变化的只有uid(用户的uid)
 */
function _activeIcon(obj, uid, nick, hide){
	/**这次魔方不上线
	if(checkMofunClient()){}**/
	
	src = obj;
	obj = objxy(obj);
	var menu=[
			{
				name:"加好友",
				style:"",
				icon:"",
				action: function(e){
					ajfriend(obj, uid, nick);
				}
			},
			{
				name:"打招呼",
				style:"",
				icon:"",
				action:function(e){
					showPoke(e.srcElement, 'poke',  null, uid);
				}
			},
			{
				name:"送礼物",
				style:"",
				icon:"",
				action:function(e){
					showPoke(e.srcElement, 'gift',  null, uid);
				}
			},
			{
				name:"写留言",
				style:"",
				icon:"",
				action:function(e){
					e.srcElement.href = 'http://space.sina.com.cn/wall/wall.php?uid='+uid+'#leaveword';
					//leaveword(obj, uid, nick);
				}
			},
			{
				name:"发纸条",
				style:"",
				icon:"",
				action: function(e){
					sendmsg(obj, uid, nick);
				}
			},
			{	
				name:"即时聊天",
				style:"li_a",
				icon:"http://www.sinaimg.cn/pay/space/images2/images/fuen/layer_icon_14.png",
				action:function(e){return;}
			}
		];
	
		//根据 hide 值，移除指定菜单条
		if(!isNull(hide) || !isNaN(hide)) {
			if(hide.length){
				hide = hide.sort();
				for (var i=0; i< hide.length; i++) menu.splice(parseInt(hide[i]-i), 1);
			}else{
				menu.splice(parseInt(hide), 1);
			}
		}

	var icon=document.getElementById("_activeIcon_");
	if(icon){
		oDel(icon);
	}
	icon=document.createElement("div");
	icon.setAttribute("id","_activeIcon_");
	icon.className="layer_friend";
	icon.style.position="absolute";
	icon.style.display="";
	var xy=objxy(obj);
	icon.style.left= xy[1]+"px";
	icon.style.top=(xy[0]+12)+"px";
	var ul=document.createElement("ul");
	var li=[];
	for(var i=0;i<menu.length;i++){
		li[i]=document.createElement("li");
		if(menu[i].style!==""){
			li[i].className=menu[i].style;
		}
		if(menu[i].icon!=""){
			li[i].innerHTML='<img src="'+menu[i].icon+'" />  ';
		}
		var a=document.createElement("a");
		a.setAttribute("href","javascript:;");
		a.o = obj;
		a.appendChild(document.createTextNode(menu[i].name));
		li[i].appendChild(a);
		addEvent(a,"onclick",menu[i].action);
		ul.appendChild(li[i]);
	}
	icon.appendChild(ul);
	document.body.appendChild(icon);

	//判断是否超出页面右边界
	var ixy = objxy(icon);
	var _x = ixy[1], _w = ixy[2];
	if(_x + _w > getbodyCW()) 
		icon.style.left = parseInt(_x  -  _w  + xy[2])+'px';

	addEvent(document.body,"onclick",function(e){
		var ee=e.srcElement;
		while(ee){
			if(ee==src){
				return;
			}
			if(ee==document.body){
					try{
						oDel(icon);
					}catch(e){}
				return;
			}
			ee=ee.parentNode
		}
	});
}
/**
 * objs是数组类型，数组内容是包括在线状态图片的dom，甚至于body都可以
 * 在php打印的时候需要在将在线状态图片打印成：
 * <img src="http://www.sinaimg.cn/pay/space/images2/images/icon/icon14.gif" uid="{$friend.Friend.Uid}" icon="online" title="不在线" />
 * 其中uid就是用户uid，其他的保持不变
 * 使用方法是在body加载完毕后执行online(objs);
 */
function _online(objs){
	var setOnline=function(){
		for(var i=0;i<onlineImg.length;i++){
			if(_spaceOnline[onlineUid[i]]!=0){
				onlineImg[i].src="http://www.sinaimg.cn/pay/space/images2/images/icon/icon13.gif";
				onlineImg[i].title="当前用户在线";
			}
		}
	}
	var allImg=[];
	var onlineImg=[];
	var onlineUid=[];
	for(var i=0;i<objs.length;i++){
		var child=objs[i].getElementsByTagName("img");
		for(var j=0;j<child.length;j++){
			if(child[j].getAttribute("icon")=="online"){
				onlineUid.add(child[j].getAttribute("uid"));
				onlineImg.add(child[j]);
			}
		}
	}
	scriptRequest("http://v.space.sina.com.cn/person/online.php?u="+onlineUid+ "&varname=_spaceOnline",setOnline,true);
}
/**
 * objs是数组类型，数组内容是包括在线状态图片的dom，甚至于body都可以
 * 在php打印的时候需要在将在线状态图片打印成：
 * <img src="http://www.sinaimg.cn/pay/space/images2/images/icon/icon22.gif" uid="{$friend.Friend.Uid}" icon="new" />
 * 其中uid就是用户uid，其他的保持不变
 * 使用方法是在body加载完毕后执行_recentUpdate(objs);
 */
function _recentUpdate(objs){
	var setRecent=function(json){
		if(json){
			for(var i=0;i<recentImg.length;i++){
				for(var j in json){
					if(parseInt(recentImg[i].getAttribute("uid"))==parseInt(j)){
						if(_servertime-json[j]<=86400){
							recentImg[i].src="http://www.sinaimg.cn/pay/space/images2/images/icon/icon15.gif";
							recentImg[i].title="最近有更新";
						}
					}
				}
			}
		}else{
			return;
		}
	}
	var allImg=[];
	var recentImg=[];
	var recentUid=[];
	for(var i=0;i<objs.length;i++){
		var child=objs[i].getElementsByTagName("img");
		for(var j=0;j<child.length;j++){
			if(child[j].getAttribute("icon")=="new"){
				recentUid.add(child[j].getAttribute("uid"));
				recentImg.add(child[j]);
			}
		}
	}
	SetAjax("/personinfo/aj_updatetimes.php?uids="+recentUid,"",setRecent);
}
/**
 * 登录组件，和其他组件是分离的
 * @param obj是点击对象
 */
function setlogin(obj){
	if($("login_box")==null){
		var box=document.createElement("DIV");
		box.setAttribute("id","login_box");
	}else{
		var box=$("login_box");
	}
	box.style.cssText="position: absolute;"
	var xy=objxy(obj);
	box.style.top=(xy[0]+16)+"px"
	if(document.body.clientWidth/2<xy[1]){
			box.style.left=(xy[1]-340+xy[2])+"px"
	}else{
			box.style.left=xy[1]+"px"
	}
	var codeStr;
	if(_needcode=="1"){
		codeStr='<p class="p_img" id="checkcodeContainer">验证码：<input type="text" name="checkcode" class="input_bor" size="6" maxlength="4" />\
					<img align="absmiddle" id="login_img" style="cursor:pointer;width:60px;height:20px" onclick="this.src=\'/CheckCode.php?type=4&\'+ts()" /></p>';
	}else{
		codeStr='<p class="p_img" style="display:none" id="checkcodeContainer">验证码：<input type="text" class="input_bor" size="6" maxlength="4" name="checkcode" />\
					<img align="absmiddle" id="login_img" style="cursor:pointer;width:60px;height:20px" onclick="this.src=\'/CheckCode.php?type=4&\'+ts()" src="/CheckCode.php?type=4&'+ts()+'" /></p>';
	}
	var str='<iframe src="about:blank" style="filter:alpha(opacity=0);-moz-opacity:0;opacity:0;width:340px;height:100px;position:absolute;left:2px;top:0;z-index:-1"></iframe>\
			<form name="fm_islogin" onsubmit="return false;">\
				<div style="width:340px;height:auto !important" class="fn_model">\
				<a href="http://iask.sina.com.cn/browse/get_class4.php?fatherid=1315&nav=1" target="_blank" style="position:absolute;right:40px;top:7px;display:block;" title="帮助">帮助</a>\
				<div class="top">\
					<span><a href="javascript:;" onclick="$(\'login_box\').style.display=\'none\'">×</a></span>\
					<strong>通行证登录</strong>\
				</div>\
				<div class="con fn_layer">\
				<p style="display:none;color:#f00" id="checkcode_error">请输入验证码</p>\
				<p style="display:none;color:#f00" id="loginname_error">请输入登录名</p>\
				<p style="display:none;color:#f00" id="password_error">请输入密码</p>\
				<p style="display:none;color:#f00" id="login_error_box"></p>\
				<p style="margin: 4px 0pt;">登录名：<input type="text" size="26" class="input_bor" tabindex="1" autocomplete="off" id="loginname_txt" name="loginname" /> <a href="http://login.sina.com.cn/hd/reg.php?entry=space" target="_blank">注册</a></p>\
				<p style="margin: 4px 0pt;">密　码：<input type="password" size="26" class="input_bor" autocomplete="off" name="password" id="password_login" tabindex="2" /> <a href="http://login.sina.com.cn/getpass.html" target="_blank">找回密码</a>\
				</p>'+codeStr+'<p style="margin: 4px 0pt;padding-left:43px">\
				<label for="cbox_1x"><input type="checkbox" id="cbox_1x" name="isremember" />记住用户名</label></p>\
				<p class="p_btn p_c" style="margin-top:20px"><input type="submit" value="" style="width:0;height:0;position:absolute;z-index:-10" tabindex="2" onclick="onlogin();" /><a href="javascript:;" onclick="onlogin();" class="btn_inline"><span><cite>　登 录　</cite></span></a>    <a href="javascript:;" class="btn_inline" onclick="$(\'login_box\').style.display=\'none\'"><span><cite>　取 消　</cite></span></a></p>\
				</div>\
			</div></form>';
	box.innerHTML=str;
	document.body.appendChild(box);
	if($("loginname_txt")){
		initCardTips('loginname_txt', 'password_login');
	}
	var del_box=function(e){
		e=e||event;
		var ee=e.srcElement;
		while(ee){
				if(ee==$("login_box")||ee==$("sinaNote")){
					return;
				}
				if(ee.tagName=="HTML"){
					$("login_box").style.display="none";
					return;
				}
				ee=ee.parentNode
		}
		//passcardOBJ.removeMenu();
	}
	addEvent(document.body,"onmousedown",del_box);
	window.setTimeout('$("login_img").src="/CheckCode.php?type=4&'+ts()+'"',20)
	if (GetCookie("spaceuser") != false) {
		$("loginname_txt").value = decodeURIComponent(GetCookie("spaceuser"));
		$("cbox_1x").checked=true;
	}
}
//登录提交
function onlogin(){
	var fm=document.forms["fm_islogin"]
	var k=new Array()
	for(var i=0;i<fm.length;i++){
		if(fm[i].name=="loginname"){
			if(fm[i].value=="" || fm[i].value=="会员名/手机/UC号"){
				login_error(fm[i]);
				return;
			}
		}
		if(fm[i].name=="password" && fm[i].value==""){
			login_error(fm[i]);
			return;
		}
		if(fm[i].name=="checkcode" && fm[i].value==""&&_needcode==1){
			login_error(fm[i]);
			return;
		}
		if($(fm[i].name+"_error")!=null){
			$(fm[i].name+"_error").style.display="none"
		}
		if(fm[i].name=="isremember"){
			if(fm[i].checked){
				k.add("isremember="+1);
			}else{
				k.add("isremember="+0);
			}
		}else{
			k.add(fm[i].name+"="+fm[i].value)			
		}
	}
	var back_onlogin=function(json){
		if(json.status==1){
			location.reload();
		}else if(json.status == 2){
			location.href=json.error;
		}else{
			$("loginname_error").style.display = $("password_error").style.display = "none"
			if ($("checkcode_error")) {
				$("checkcode_error").style.display = "none"
			}
			$("login_error_box").style.display = "";
			$("login_error_box").innerHTML = json.error;
			if (json.needcode) {
				if (json.needcode == true) {
					$("checkcodeContainer").style.display = "";
					$("login_img").src = '/CheckCode.php?type=4&' + ts();
					_needcode = 1;
				}
			}
		}
	}
	SetAjax("/aj_loginaction.php","post:"+k.join("&"),back_onlogin);
	return false;
}
function login_error(obj){
	$("login_error_box").style.display = "none";
	$("loginname_error").style.display=$("password_error").style.display="none";
	if($("checkcode_error")){$("checkcode_error").style.display="none"}
	$(obj.name+"_error").style.display="";
	obj.focus();
}
/**
 * 修改真实姓名
 * 参数是需要修改的真实姓名
 * 返回:成功{status:1,realname:"真实姓名"}
 * 失败{status:0,error:"错误信息"}
 */
function _modifyRealname(newName){
	if(typeof _realname == 'undefined') _realname = '';
	var newRealname=newName.trim();
	newRealname=newRealname.replace(/[^\u4e00-\u9fa5\.a-zA-Z\s]/g,"");
	if(newRealname.lenB()==0){
		return {"status":0,"error":"真实姓名不能为空"};
	}else if(newRealname.lenB()<4||newRealname.lenB()>16){
		return {"status":0,"error":"真实姓名的长度是4-16个字符"};
	}
	var tmpReturn="";
	var modifyRealnameOK=function(json){
		if(json.status==1){
			_realname=newRealname;
			tmpReturn={"status":1,"realname":newRealname};
		}else{
			tmpReturn={"status":0,"error":json.error};
		}
	}
	if(_realname==newRealname){
		return {"status":1,"realname":newRealname};
	}else{
		SetAjax("/personinfo/aj_realname.php?action=1&realname="+encodeURIComponent(newRealname),"",modifyRealnameOK,null,true);
		return {"status":1,"realname":newRealname};
	}
}
function _autoIframe(iframeName){
	//var iframe=document[iframeName];
	//var h=iframe.contentWindow.document.body.clientHeight;
	//alert(h);
	//iframe.style.height=height;
}






function hidden(obj){
	toggle(obj);
}
/* show top memnu */
var menu_init = false;
var hid_menu = function(){
	//$("mymenu_0").style.display = "none";
	$("mymenu_1").style.display = "none";
	$("mymenu_2").style.display = "none";
	//$("mymenu_3").style.display = "none";
	$("mymenu_4").style.display = "none";
	$("mymenu_5").style.display = "none";
}
function show_top_menu(menu){
	hid_menu();
	if (!menu_init){
		addEvent(document, "onclick", hid_menu)
		menu_init = true;
	}
	hidden(menu);
	stopEvent();
}
function menu_top_over(n,type){
	if(type==1){
		$("mymenu_"+n+"_img").src="http://www.sinaimg.cn/pay/space/images2/images/icon/icon20_on.gif";
	}else{
		$("mymenu_"+n+"_img").src="http://www.sinaimg.cn/pay/space/images2/images/icon/icon20.gif";
	}
}

/* check current user message */
function check_user_message(){
	if (_islogin != 1) return;
	var msg_alert = Array();
	var __message = false;
	function _message_alert(){
		if (__message) return;
		__message = true;
		var doc_title = document.title;
		var msg_alert_curr = 0;
		var blink = 0;
		if (!isNull(_music)&& _music > 0){
			play_sound(_music);
		}
		function __set_title(){
			if (msg_alert_curr == msg_alert.length) {
				msg_alert_curr = 0;
			}
			var tit = "";
			if (blink % 2 == 0){
				tit = msg_alert[msg_alert_curr];
				msg_alert_curr++;
				blink++;
				
			}
			else{
				tit = "　　　　　　".leftB(msg_alert[msg_alert_curr].lenB());
				blink++;
			}
			if (blink == 20){
				document.title = doc_title;
			}
			else{
				document.title = "◆" + tit + "◆" + doc_title;
				setTimeout(arguments.callee, 1000);
			}
		}
		__set_title();
		
	}
	function check_mail_msg(){
		if (GetCookie("space_mail_check") == 1){
			return;
		} else {
			scriptRequest("http://hint.sinamail.sina.com.cn/mailproxy/mail.php", function(){
				if (sinamailinfo.result == true && sinamailinfo.unreadmail > 0) {
					__news_message_show("message_mail", {"tit" : "有新邮件", "num" : sinamailinfo.unreadmail});
				}
				
			});
			SetCookie("space_mail_check",'1',7200);
		}
			
	}
	function check_sys_msg(){
		var sys_msg_type = {"feed" : "有新系统消息", "msg" : "有新纸条", "wall" : "有新留言", "comment" : "有新评论"}
		SetAjax("/personinfo/aj_mycount.php", "", function(back_join){
			if (back_join.status != 1) return;
			for (var ret in sys_msg_type){
				var obj = "message_" + ret;
				if (back_join[ret] > 0){
					__news_message_show(obj, {"tit" : sys_msg_type[ret], "num" : back_join[ret]});
				}
			}
		});
		
	}
	function check_rss_msg(){
		scriptRequest("http://xianguo.space.sina.com.cn/sina/unread-num?uid=" + _cuid, function(){
			if (parseInt(_subscribeCount) > 0){
				//__news_message_show($("message_rss"), {"tit" : "有新订阅", "num" : _subscribeCount});
				//取消铃声提醒直接显示条数
				if (isNull($("message_rss"))) return;
				$("message_rss").getElementsByTagName("span")[0].innerHTML = "<span>(" + _subscribeCount + ")</span>";
				if(!isNull($("message_rss_profile"))){
					with($("message_rss_profile")){
						innerHTML = '('+ _subscribeCount +')';
						className = "c_orange";
					}
					
				}
			}
		})
		

	}
	function __news_message_show(obj, res){
		msg_alert.push(res.tit);
		_message_alert();
		if (isNull($(obj))) return;
		$(obj).getElementsByTagName('span')[0].innerHTML = "<span>(" + res.num + ")</span>";
		if(!isNull($(obj + "_profile"))){
			$(obj + "_profile").innerHTML = "(" + res.num + ")";
			$(obj + "_profile").className = "c_orange";
		}
	}
	check_mail_msg();
	check_sys_msg();
	check_rss_msg();
	setTimeout(arguments.callee, 300000);
}
//由于新邮件提示有延时，所以新邮件检查间隔5分钟
function mail_checked(){}

//铃声容器
document.write("<div id='__play_message_sound' style='position:absolute;width:0px;height:0px'></div>");
function play_sound(file){
	var sound_html = '<embed src="http://image2.sina.com.cn/book/col/playsound.swf" style="height:0;width:0;" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="mp3URL=http://spacejs.sinajs.cn/view/sound/a' + file + '.mp3" />';
	var sound = $("__play_message_sound");
	if (isNull(sound)){
		sound = document.createElement("div");
		sound.id = "__play_message_sound";
		sound.style.position = "absolute";
		sound.innerHTML = sound_html;
		document.body.appendChild(sound);
	}
	else{
		sound.innerHTML = sound_html;
	}
}
function check_search_form(f){
	if (f.keyword.value == "" || f.keyword.value == "找朋友/同学/同事"){
		errTips("请输入她/他的资料进行搜索！", '', function(){ f.keyword.focus(); });
		return false;
	}
	return true;
}
/*change background music*/
function changeMusic(){
	var _html = '<form id="set_message_sound">\
		<p>选择您喜欢的铃声，当您收到最新消息时会以铃声提示您，即使您在浏览其他网页时，也可以第一时间接到通知。</p>\
		<div style="height:0;font:0/0 a;border-bottom:1px solid #CCC;margin-top:10px;margin-bottom:5px"></div>\
		<table width="210" border="0" cellspacing="0" cellpadding="0" class="tab1">\
		  <tr>\
		    <td width="150"><strong>选择铃声</strong></td>\
		    <td width="60"><strong>试听</strong></td>\
		  </tr>\
		  <tr>\
		    <td><label>\
		      <input type="radio" name="message_sound" id="message_sound_1" value="1" onclick="play_sound(this.value)" />\
		    </label>铃声1</td>\
		    <td style=" padding-left:5px"><a href="javascript:;" onclick="play_sound(\'1\');return false;" title="试听"><img src="http://www.sinaimg.cn/pay/space/images2/img_components/ring.gif" width="17" height="15" /></a></td>\
		  </tr>\
		  <tr>\
		    <td><label>\
		      <input type="radio" name="message_sound" id="message_sound_2" value="2" onclick="play_sound(this.value)" />\
		    </label>铃声2</td>\
		    <td style=" padding-left:5px"><a href="javascript:;" onclick="play_sound(\'2\');return false;" title="试听"><img src="http://www.sinaimg.cn/pay/space/images2/img_components/ring.gif" width="17" height="15" /></a></td>\
		  </tr>\
		  <tr>\
		    <td><label>\
		      <input type="radio" name="message_sound" id="message_sound_3" value="3" onclick="play_sound(this.value)" />\
		    </label>铃声3</td>\
		    <td style=" padding-left:5px"><a href="javascript:;" onclick="play_sound(\'3\');return false;" title="试听"><img src="http://www.sinaimg.cn/pay/space/images2/img_components/ring.gif" width="17" height="15" /></a></td>\
		  </tr>\
		  <tr>\
		    <td><label>\
		      <input type="radio" name="message_sound" id="message_sound_4" value="4" onclick="play_sound(this.value)" />\
		    </label>铃声4</td>\
		    <td style=" padding-left:5px"><a href="javascript:;" onclick="play_sound(\'4\');return false;" title="试听"><img src="http://www.sinaimg.cn/pay/space/images2/img_components/ring.gif" width="17" height="15" /></a></td>\
		  </tr>\
		  <tr>\
		    <td><label>\
		      <input type="radio" name="message_sound" id="message_sound_5" value="5" onclick="play_sound(this.value)" />\
		    </label>铃声5</td>\
		    <td style=" padding-left:5px"><a href="javascript:;" onclick="play_sound(\'5\');return false;" title="试听"><img src="http://www.sinaimg.cn/pay/space/images2/img_components/ring.gif" width="17" height="15" /></a></td>\
		  </tr>\
		  <tr>\
		    <td><label>\
		      <input type="radio" name="message_sound" id="message_sound_0" value="0" />\
		    </label>关闭铃声提示</td>\
		    <td style=" padding-left:5px"><img src="http://www.sinaimg.cn/pay/space/images2/img_components/ring_close.gif" width="17" height="15" /></td>\
		  </tr>\
		 </table>\
		 <div style="height:0;font:0/0 a;border-bottom:1px solid #CCC;margin-bottom:10px;margin-top:5px"></div>\
		</form>';
	if (isNull(_music)){
		_music = 1;
	}
	var w = new _$w();
	w.title("铃声设置");
	w.content(_html);
	w.show();
	w.addbt("保存", save_message_sound);
	w.addbt("取消");
	w.setWindow();
	try{
		$("message_sound_" + _music).checked = true;
	} catch(e){}
}

function save_message_sound(){
	var sd = $("set_message_sound").message_sound;
	var le = sd.length;
	for (var i = 0; i < le; i++){
		if (sd[i].checked){
			_music = sd[i].value;
			SetAjax("/plugin/aj_setbjmusic.php?uid=" + _cuid + "&sound=" + sd[i].value, "", function(back_join){
				if (back_join.status == 1) {
					errTips("铃声设置保存成功！", 1);
				}
				else {
					errTips("铃声设置保存失败！");
				}
			});
			return;
		}
	}
	errTips("请选择您要设置的铃声！");
}
function uid2Icon(uid, size){
	document.write('<img src="http://portrait' + (uid%8+1) + '.sinaimg.cn/' + uid + '/blog/' + size + '" width="' + size + '" height="' + size + '" />');
}