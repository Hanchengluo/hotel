$(document).ready(function(){
	
    var _img = $('.slidesBox a');
    var _len = _img.length;
    var _index = 0;
    var _moving;
    //插入图片索引数字
    var _ul = '<ul>'
    for (var i = 1; i <= _len; i++) {
        _ul = _ul + '<li>' + i + '</li>';
    }
    _ul = _ul + '</ul>';
    $('.slidesBox .ico').append(_ul);
    var _ico = $('.ico li');
    //划过数字
    _ico.mouseover(function () {
        _index = _ico.index(this);
        _img.filter(':visible').fadeOut(250, function () {
            _img.eq(_index).fadeIn(250);
        })
        $(this).addClass('current').siblings().removeClass('current');
    }).eq(0).mouseover();
    //自动渐变
    _moving = setInterval(autoShow, 5000);
    _img.hover(function () { clearInterval(_moving) }, function () {
        _moving = setInterval(autoShow, 5000);
    })
    _ico.hover(function () { clearInterval(_moving) }, function () {
        _moving = setInterval(autoShow, 5000);
    })
    function autoShow() {
        _index++;
        if (_index == _len) _index = 0;
        _ico.eq(_index).trigger('mouseover');
    };

	
	$('.tabsList a').hover(function(){
		
		index = $(this).index();
		$(this).addClass('cur').siblings().removeClass('cur');
		$('.tabs-list .soft-list').eq(index).addClass('list-show').siblings().removeClass('list-show');
		
	})
	
})