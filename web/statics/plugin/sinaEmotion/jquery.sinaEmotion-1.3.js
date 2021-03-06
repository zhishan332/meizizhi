(function($){
	var target;
	$.fn.sinaEmotion = function(options){
		var defaults = {
			target: $(this).parent('form').find('textarea'),
			app_id: '1362404091'
		};
		options = $.extend({}, defaults, options);
		var cat_current;
		var cat_page;
		var emotions = new Array();
		var categorys = new Array();
		$(this).click(function(event){
			event.stopPropagation();
			if(!$('#emotions')[0]){
				$(this).parent().append('<div id="emotions"></div>');
			}
			$('#emotions').css({top: $(this)[0].offsetTop + $(this).height() + 8, left: $(this)[0].offsetLeft});
            var   domid=options.target;
            if(options.class!=null &&options.class==true){
                domid+=$(this).attr("id").split("-")[1];
            }
            target = $(domid);
			if($('#emotions .facecategorys')[0]){
				$('#emotions').toggle();
				return;
			}
			$('#emotions').html('<div>正在加载，请稍候...</div>');
			$('#emotions').click(function(event){
				event.stopPropagation();
			});
			$.ajax({
				dataType: 'json',
				url: "../action/emotion.php?ac=query_all",
				beforeSend: function(){},
				error: function(request){
					$('#emotions').html('<div>加载失败</div>');
				},
				success: function(response){
					$('#emotions').html('<div style="float:right"><a href="javascript:void(0);" id="prev">&laquo;</a><a href="javascript:void(0);" id="next">&raquo;</a></div><div class="facecategorys"></div><div class="facecontainer"></div><div class="page"></div>');
					var data = response;
					for(var i in data){
						if(data[i].category == ''){
							data[i].category = '默认';
						}
						if(emotions[data[i].category] == undefined){
							emotions[data[i].category] = new Array();
							categorys.push(data[i].category);
						}
						emotions[data[i].category].push({name: data[i].phrase, icon: data[i].icon});
					}
					$('#emotions #prev').click(function(){
						showCategorys(cat_page - 1);
					});
					$('#emotions #next').click(function(){
						showCategorys(cat_page + 1);
					});
					showCategorys();
					showEmotions();
				}
			});
		});
		$('body').click(function(){
			$('#emotions').hide();
		});
		$.fn.insertText = function(text){
			this.each(function() {
				if(this.tagName !== 'INPUT' && this.tagName !== 'TEXTAREA') {return;}
				if (document.selection) {
					this.focus();
					var cr = document.selection.createRange();
					cr.text = text;
					cr.collapse();
					cr.select();
				}else if (this.selectionStart || this.selectionStart == '0') {
					var 
					start = this.selectionStart,
					end = this.selectionEnd;
					this.value = this.value.substring(0, start)+ text+ this.value.substring(end, this.value.length);
					this.selectionStart = this.selectionEnd = start+text.length;
				}else {
					this.value += text;
				}
			});        
			return this;
		}
		function showCategorys(){
			var page = arguments[0]?arguments[0]:0;
			if(page < 0 || page >= categorys.length / 5){
				return;
			}
			$('#emotions .facecategorys').html('');
			cat_page = page;
			for(var i = page * 5; i < (page + 1) * 5 && i < categorys.length; ++i){
				$('#emotions .facecategorys').append($('<a href="javascript:void(0);">' + categorys[i] + '</a>'));
			}
			$('#emotions .facecategorys a').click(function(){
				showEmotions($(this).text());
			});
			$('#emotions .facecategorys a').each(function(){
				if($(this).text() == cat_current){
					$(this).addClass('current');
				}
			});
		}
		function showEmotions(){
			var category = arguments[0]?arguments[0]:'默认';
			var page = arguments[1]?arguments[1] - 1:0;
			$('#emotions .facecontainer').html('');
			$('#emotions .page').html('');
			cat_current = category;
			for(var i = page * 72; i < (page + 1) * 72 && i < emotions[category].length; ++i){
				$('#emotions .facecontainer').append($('<a href="javascript:void(0);" title="' + emotions[category][i].name + '"><img src="' + emotions[category][i].icon + '" alt="' + emotions[category][i].name + '" width="22" height="22" /></a>'));
			}
			$('#emotions .facecontainer a').click(function(){
				target.insertText($(this).attr('title'));
				$('#emotions').hide();
			});
			for(var i = 1; i < emotions[category].length / 72 + 1; ++i){
				$('#emotions .page').append($('<a href="javascript:void(0);"' + (i == page + 1?' class="current"':'') + '>' + i + '</a>'));
			}
			$('#emotions .page a').click(function(){
				showEmotions(category, $(this).text());
			});
			$('#emotions .facecategorys a.current').removeClass('current');
			$('#emotions .facecategorys a').each(function(){
				if($(this).text() == category){
					$(this).addClass('current');
				}
			});
		}
	}
})(jQuery);