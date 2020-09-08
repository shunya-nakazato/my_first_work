$(function(){
    $('#register-btn').click(function(){
            $name = $('input[name="name"]').val();
            $email = $('input[name="email"]').val();
            $password = $('input[name="password"]').val();
            if(!($name)){
                $('#formContent > small').remove();
                $('#formContent').prepend('<small style="color: red;">アカウント名を入力してください</small>');
                return;
            }
            if(!($email)){
                $('#formContent > small').remove();
                $('#formContent').prepend('<small style="color: red;">メールアドレスを入力してください</small>');
                return;
            }
            if(!($password.match(/^[\u0020-\u007e]+$/))){
                $('#formContent > small').remove();
                $('#formContent').prepend('<small style="color: red;">パスワードは、半角英数字または記号で入力してください</small>');
                return;
            }
            var param = {
                "id": null,
                "name": $name,
                "email": $email,
                "password": $password
            };
            // alert('hoge');
            console.log(param);
        $.ajax({
            url: "http://52.199.100.24/admin/api/v1/app_user/register",
            type: "post",
            data: JSON.stringify(param),
            contentType: 'application/json',
            dataType: 'json',
            timeout: 60000
        }).done(function(data){
            console.log(data);
            if(data.result != "ok"){
                if(data.result != "ok"){
                    $('#formContent > small').remove();
                    $('#formContent').prepend('<small style="color: red;">' + data.error_message + '</small>');
                    return;
                };
                return;
            };
            // セッションに保存
            sessionStorage.setItem('user_id', data.app_user.id);
            sessionStorage.setItem('user_name', data.app_user.name);
            sessionStorage.setItem('user_email', data.app_user.email);
            window.location.href = "./index.html";
            console.log($app_user);
        }).fail(function(data){
            console.log(data);
            alert("新規登録のエラーです");
        });
    });
})