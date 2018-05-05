
function delimg(obj) {
    $(obj).parent().remove();
}
$(function(){
    var options = {
        type:'post',           //post提交
        //url:'http://ask.tongzhuo100.com/server/****.php?='+Math.random(),   //url
        dataType:"json",        //json格式
        data:{},    //如果需要提交附加参数，视情况添加
        clearForm: false,        //成功提交后，清除所有表单元素的值
        resetForm: false,        //成功提交后，重置所有表单元素的值
        cache:false,
        async:false,          //同步返回
        success:function(data){
            if(data.code==0){
                layer.msg(data.msg);
            }else{
                layer.msg(data.msg,{icon:1,time:500},function(){
                    $("#reset").click();
                    lotus_close();
                    parent.location.reload();
                });
            }
            //服务器端返回处理逻辑
        },
        error:function(XmlHttpRequest,textStatus,errorThrown){
            layer.msg('操作失败:服务器处理失败');
        }
    };
    layui.use('form', function(){
        var form = layui.form;
        $('#mainForm').ajaxForm(options).submit(function(data){});
    });
    layui.use('upload', function(){
        var upload = layui.upload;

        //执行实例
        var urls="{:url('admin/system/uploadvideo')}"
        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: urls //上传接口
            ,field:'video'
            ,accept:'video'
            ,done: function(res){
                //上传完毕回调
                layer.closeAll();
                $('#video').val(res.data);

            }
            ,error: function(){
                //请求异常回调
                layer.msg('上传失败');
                setTimeout(function () {
                    layer.closeAll();
                },1000)

            }
            ,before:function () {
                layer.msg('正在上传', {
                    icon: 16
                    ,shade: 0.01,
                    time:100000
                });
            }
        });

        var url2="{:url('admin/company/uploadfile')}"
        //执行实例
        var uploadInst = upload.render({
            elem: '#test2' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                console.log(7777);
                console.log(res);
                var html='<div class="divs">'+
                    '<img src="'+res.data+'" style="width: 150px;height: 150px">'+
                    '<input type="hidden" value="'+res.data+'" name="img_url[]" >'+
                    '<span onclick="delimg(this)" class="item">删除</span>'+
                    '</div>';
                $('#listimgs').append(html);
            }
            ,error: function(){
                //请求异常回调
            }
        });
        var uploadInst = upload.render({
            elem: '#test2_1' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                $('#banner_1').find('img').attr('src',res.data);
                $('#banner_1').find('input').val(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });

        var uploadInst = upload.render({
            elem: '#test2_2' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                $('#banner_2').find('img').attr('src',res.data);
                $('#banner_2').find('input').val(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });

        var uploadInst = upload.render({
            elem: '#test2_3' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                $('#banner_3').find('img').attr('src',res.data);
                $('#banner_3').find('input').val(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });

        var uploadInst = upload.render({
            elem: '#test2_4' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                $('#banner_4').find('img').attr('src',res.data);
                $('#banner_4').find('input').val(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });


        var uploadInst = upload.render({
            elem: '#test2_5' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                $('#banner_5').find('img').attr('src',res.data);
                $('#banner_5').find('input').val(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });

        var uploadInst = upload.render({
            elem: '#test2_6' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                $('#banner_6').find('img').attr('src',res.data);
                $('#banner_6').find('input').val(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });

        var uploadInst = upload.render({
            elem: '#test2_7' //绑定元素
            ,url: url2 //上传接口
            ,field:'image'
            ,multiple:true
            ,done: function(res){
                //上传完毕回调
                $('#banner_7').find('img').attr('src',res.data);
                $('#banner_7').find('input').val(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });
    });

})