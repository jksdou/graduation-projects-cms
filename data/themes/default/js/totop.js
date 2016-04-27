/**
 * 返回顶部
 * @param backTop_minheight
 */
function backTop(backTop_minheight)
{
	var backTop_html = '<div id="backTop">返回顶部</div>';//预定义返回顶部的html代码，它的css样式默认为不显示
	$("#container").append(backTop_html);//将返回顶部的html代码插入页面上id为container的元素的末尾 
	$("#backTop")
		.click(//定义返回顶部点击向上滚动的动画，数值100为滚动完成使用的时间值，值越小速度越快
			function backTop_animate() { $('html,body').animate({ scrollTop: 0 }, 100); }
		)
		.hover(//为返回顶部增加鼠标hover反馈效果，用添加删除css类实现
			function backTop_display() { $(this).addClass("hover"); },
			function backTop_hidden() { $(this).removeClass("hover"); }
		);
	backTop_minheight ? backTop_minheight = min_height: backTop_minheight = 300;//获取页面的最小高度，无传入值则默认为400像素
	$(window).scroll(//为窗口的scroll事件绑定处理函数
		function backTop_scroll()
		{
			var backTop_current = $(window).scrollTop();//获取窗口的滚动条的垂直位置
			//当窗口的滚动条的垂直位置大于页面的最小高度时，让返回顶部元素渐现，否则渐隐，数值为渐现渐隐完成时间值，值越小动作越快
			if (backTop_current > backTop_minheight) { $("#backTop").fadeIn(1000); }
			else { $("#backTop").fadeOut(500); };
		}
	);
};
backTop();