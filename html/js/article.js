$(function(){
    $id = window.location.search.replace("?id=", "");
    $login_id = $app_user_id = sessionStorage.getItem('user_id');

    $.ajax({
        // クエリパラメータ
        url: "http://52.199.100.24/admin/api/v1/article?" + "id=" + $id + "&login_id=" + $login_id,
        type: "get",
        timeout: 60000,
    }).done(function(data){
        // ナビバー
        $.each(data.categories, function(index, category){
            if(category.id == data.category_id){
                $category_link = $('<a class="nav-link category active" href="./category_articles.html?id=' + category.id + '">').text(category.category_name);
            }else{
                $category_link = $('<a class="nav-link category" href="./category_articles.html?id=' + category.id + '">').text(category.category_name);
            }
            $nav_item = $('<li class="nav-item">').append($category_link);
            $('#nav-category').append($nav_item);
        });

        
        $article_image = $('<img class="article-image" src="http://52.199.100.24/admin/' + data.article.image_path + '">');
        $article_title = $('<h4 class="article-title"></h4>').text(data.article.title);
        $like_button = $('<P></P>')
        // ログインしているかどうかで分岐
        if(sessionStorage.getItem('user_id')){
            // いいねしているかどうかで分岐
            if(data.like){
                $like_button = $('<button id="delete-like" type="button" class="btn btn-outline-secondary">').text(data.likes_count + 'いいね済み');
            }else{
                $like_button = $('<button id="create-like" type="button" class="btn btn-outline-secondary">').text(data.likes_count + 'いいね');
            }
        }else{
            $like_button = $('<button id="create-like-guest" type="button" class="btn btn-outline-secondary">').text(data.likes_count + 'いいね');
        }
        $article_text = $('<div class="article-text"></div>').text(data.article.text);
        $('#wrapper').append($article_image).append($article_title).append($like_button).append($article_text);
        
        // ログインしていない場合のいいねの動作
        $('#create-like-guest').click(function(){
            alert('ログインしてください');
        });
        // 未いいねの場合
        $('#create-like').click(function(){
            $app_user_id = sessionStorage.getItem('user_id');
            $article_id = data.article.id;
            var param = {
                "id" : null,
                "app_user_id" : $app_user_id,
                "article_id" : $article_id
            };
            console.log(param);

            $.ajax({
                url: "http://52.199.100.24/admin/api/v1/like",
                type: "post",
                data: JSON.stringify(param),
                contentType: 'application/json',
                dataType: 'json',
                timeout: 60000
            }).done(function(data){
                console.log(data);
                if(data.result != "ok"){
                    alert("いいねのエラーです");
                    return;
                }
                location.reload();
            }).fail(function(data){
                alert("jsonのエラーです");
            });
        })
        
        // いいね済みの場合
        $('#delete-like').click(function(){
            $app_user_id = sessionStorage.getItem('user_id');
            $article_id = data.article.id;
            var param = {
                "id" : null,
                "app_user_id" : $app_user_id,
                "article_id" : $article_id
            };
            console.log(param);

            $.ajax({
                url: "http://52.199.100.24/admin/api/v1/like/delete?" + "id=" + $id + "&login_id=" + $login_id,
                type: "delete",
                dataType: 'json',
                timeout: 60000
            }).done(function(data){
                console.log(data);
                if(data.result != "ok"){
                    alert("いいね削除のエラーです");
                    return;
                }
                location.reload();
            }).fail(function(data){
                alert("jsonのエラーです");
            });
            })
        }).fail(function(data){
            console.log(data);
            alert("一件取得のエラーです！");
        });    
    
})