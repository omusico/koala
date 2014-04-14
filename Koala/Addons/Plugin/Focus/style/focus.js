var timer = null;
var offset = 5000;
var index = 0;
var maxindex = 1;
var target = ["1","2"];
//大图交替轮换
function slideImage(i){
    var id = 'image_'+ target[i];
    $('#'+ id)
        .animate({opacity: 1}, 800, function(){
            $(this).find('.title').animate({height: 'show'}, 'slow');
        }).show()
        .siblings(':visible')
        .find('.title').animate({height: 'hide'},'fast',function(){
            $(this).parent().animate({opacity: 0}, 800).hide();
        });
}
//bind thumb a
function hookThumb(){
    if($('#thumbs li a').length!=0)
    {
        $('#thumbs li a')
        .bind('click', function(){
            if (timer) {
                clearTimeout(timer);
            }                
            var id = this.id;            
            index = getIndex(id.substr(6));
            rechange(index);
            slideImage(index); 
            timer = window.setTimeout(auto, offset);  
            this.blur();            
            return false;
        });
    }
}
//bind next/prev img
function hookBtn(){
    if($('#thumbs li img').filter('#play_prev,#play_next').length!=0)
    $('#thumbs li img').filter('#play_prev,#play_next')
        .bind('click', function(){
            if (timer){
                clearTimeout(timer);
            }
            var id = this.id;
            if (id == 'play_prev') {
                index--;
                if (index < 0) index = maxindex;
            }else{
                index++;
                if (index > maxindex) index = 0;
            }
            rechange(index);
            slideImage(index);
            timer = window.setTimeout(auto, offset);
        });
}

function bighookBtn(){
    if($('#bigarea p span').filter('#big_play_prev,#big_play_next').length!=0)
    $('#bigarea p span').filter('#big_play_prev,#big_play_next')
        .bind('click', function(){
            if (timer){
                clearTimeout(timer);
            }
            var id = this.id;
            if (id == 'big_play_prev') {
                index--;
                if (index < 0) index = maxindex;
            }else{
                index++;
                if (index > maxindex) index = 0;
            }
            rechange(index);
            slideImage(index);
            timer = window.setTimeout(auto, offset);
        });
}

function getIndex(v){
    for(var i=0; i < target.length; i++){
        if (target[i] == v) return i;
    }
}
function rechange(loop){
    var id = 'thumb_'+ target[loop];
    if($('#thumbs li a').length!=0){
        $('#thumbs li a.current').removeClass('current');
        $('#'+ id).addClass('current');
    }
}
function auto(){
    index++;
    if (index > maxindex){
        index = 0;
    }
    rechange(index);
    slideImage(index);
    if (timer){clearTimeout(timer);} 
    timer = window.setTimeout(auto, offset);  
}
$(function(){    
    $('div.title').css({opacity: 0.85});
    timer = window.setTimeout(auto, offset);
    hookThumb(); 
    hookBtn();
	bighookBtn()
    
});