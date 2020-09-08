$(function(){
    $id = window.location.search.replace("?id=", "");
    $login_id = $app_user_id = sessionStorage.getItem('user_id');

    $.ajax({
        url: "http://52.199.100.24/admin/api/v1/category_articles?" + "id=" + $id + "&login_id=" + $login_id,
        type: "get",
        timeout: 60000,
    }).done(function(data){
        if(data.result != "ok"){
            alert("全取得エラーです！");
            return;
        };

        $array_category_name = [];  // 後でカテゴリーの名前を取得しやすいように配列を作っておく

        // ナビバー
        $.each(data.categories, function(index, category){
            $id = window.location.search.replace("?id=", "");
            if($id == category.id){
                $category_link = $('<a class="nav-link category active" href="./category_articles.html?id=' + category.id + '">').text(category.category_name);
            }else{
                $category_link = $('<a class="nav-link category" href="./category_articles.html?id=' + category.id + '">').text(category.category_name);
            }
            $nav_item = $('<li class="nav-item">').append($category_link);
            $('#nav-category').append($nav_item);
            
            $array_category_name[category.id] = category.category_name; //カテゴリーの名前の配列に追加
        });

        $category_name = $('<p class="category-name"></p>').text($array_category_name[data.articles[0].category]); //記事のカテゴリーIDを入力
        $('#wrapper').append($category_name);
        
        $.each(data.articles, function(index, article){
            $article_wrapper = $('<div class="flex-container article-wrapper' + article.id + '"></div>');
            $article_image = $('<img src="http://52.199.100.24/admin/' + article.image_path + '"class="article-image"></div>');
            $article_container = $('<div class="article-container"></div>');
            $article_wrapper.append($article_image).append($article_container);
            $article_title = $('<p class="article-title"></p>').text(article.title);
            // いいねされているか
            $article_like = $('<P></P>');
                    if(sessionStorage.getItem('user_id')){
                        if(data.likes[article.id]){
                            $article_like = $('<p style="color: #F54EA2"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-suit-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"/></svg></p>');
                        }
                    }
            $article_container.append($article_title).append($article_like);
            $('#wrapper').append($('<hr>')).append($article_wrapper);

            $article_wrapper.click(function(){
                $id = article.id;
                window.location.href = "./article.html?id=" + $id;
            })
        });

    }).fail(function(data){
        console.log(data);
        alert("全取得のエラーです！");
    });
    
});