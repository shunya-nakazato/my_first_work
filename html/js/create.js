$(function(){
    $('#insert_btn').click(function(){
            $name = $('input[name="new_name"]').val();
            console.log($name);    
            var param = {
                "id": null,
                "name": $name
            };
            console.log(param);
        $.ajax({
            url: "http://52.199.100.24/admin/api/v1/app_user",
            type: "post",
            data: JSON.stringify(param),
            contentType: 'application/json',
            dataType: 'json',
            timeout: 60000
        }).done(function(data){
            console.log(data);
            if(data.result != "ok"){
                alert("新規作成のエラーです");
                return;
            };
            window.location.href = "./index.html";
        }).fail(function(data){
            console.log(data);
            alert("新規作成のエラーです");
        });
    });
    $('#back_btn').click(function(){
        window.location.href = "./index.html";
    })
})