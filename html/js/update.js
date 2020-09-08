$(function(){
    $id = window.location.search.replace("?id=", "");
    $('#app_user_id').text($id);

    $.ajax({
        url: "http://52.199.100.24/admin/api/v1/app_user/" + $id,
        type: "get",
        timeout: 60000
    }).done(function(data){
        console.log(data);
        if(data.result != "ok"){
            alert("一件取得エラーです！");
            return;
        }
        $('#app_user_name').val(data.app_user.name);
    }).fail(function(data){
        console.log(data);
        alert("一件取得のエラーです！");
    });
    $('#update_btn').click(function(){
        $name = $('#app_user_name').val();
        var param = {
            "id" : $id,
            "name" : $name
        };
        $.ajax({
            url: "http://52.199.100.24/admin/api/v1/app_user",
            type: "put",
            data: JSON.stringify(param),
            contentType: 'application/json',
            dataType: 'json',
            timeout: 60000
        }).done(function(data){
            console.log(data);
            if(data.result != "ok"){
                alert("一件取得エラーです！");
                return;
            }
            window.location.href = "./index.html";
        }).fail(function(data){
            console.log(data);
            alert("更新のエラーです");
        });
    });
    $('#back_btn').click(function(){
        window.location.href = "./index.html";
    })
})