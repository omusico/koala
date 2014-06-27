$(function(){
   //defaults
   $.fn.editable.defaults.url = '/post';
   $.fn.editable.defaults.mode = 'inline';//'popup';
    //应用名
    $('#appname').editable({
        url: 'manage.php?s=Config-_write.html',
        type: 'text',
        pk: 1,
        name: 'appname',
        title: '请输入应用名',
        validate: function(value) {
           if($.trim(value) == '') return '该项必填';
        }
    });
    //项目绝对路径
    $('#projectpath').editable({
           url: 'manage.php?s=Config-_write.html',
           type: 'text',
           pk: 1,
           name: 'projectpath',
           title: '请输入项目绝对路径'
    });
    //项目发布路径
    $('#releasepath').editable({
           url: 'manage.php?s=Config-_write.html',
           type: 'text',
           pk: 1,
           name: 'releasepath',
           title: '请输入发布路径'
    });
   $('#createApp').click(function(){
        $.ajax({
        type: "post",
        url : "manage.php?s=Start-_createApp.html",
        dataType:'json',
        data: '',
        success: function(data){
            if(data.state!='success'){
                $('#error-msg').html(data.msg);
            }else{
                $('#error-msg').html('');
            }
        }
        });
   })

});