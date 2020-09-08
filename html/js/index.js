$(function(){
    $login_id = $app_user_id = sessionStorage.getItem('user_id');
    
    if($login_id == null){
        $app_user_id = 0;
    }
    $.ajax({
        url: "http://52.199.100.24/admin/api/v1/articles/" + $login_id,
        type: "get",
        timeout: 60000,
    }).done(function(data){
        if(data.result != "ok"){
            alert("全取得エラーです！");
            return;
        };
        console.log(data);

        $array_category_name = [];  // 後でカテゴリーの名前を取得しやすいように["id"=>"category_name"]の配列を作っておく
        // ナビバー
        $.each(data.categories, function(index, category){
            $category_link = $('<a class="nav-link category" href="./category_articles.html?id=' + category.id + '">').text(category.category_name);
            $nav_item = $('<li class="nav-item">').append($category_link);
            $('#nav-category').append($nav_item);
            
            $array_category_name[category.id] = category.category_name; //カテゴリーの名前の配列に追加
        });

        // 一番上の4記事
        for(var i=0; i < data.articles.length; i++){
            $latest_article_wrapper = $('<div class="flex-end-container latest-article-image-trim ' + data.articles[i].id + '"></div>'); //classに記事のidを追加
            $latest_article_image = $('<img class="article-image" src="http://52.199.100.24/admin/' + data.articles[i].image_path + '">');
            $latest_article_wrapper.append($latest_article_image);
            $latest_article_title = $('<p style="margin: 5px; z-index: 10; color: #f8f9fa; text-shadow: 0px 0px 3px #000; "></p>').text(data.articles[i].title);
            $latest_article_wrapper.append($latest_article_title);
            $('#latest-articles').append($latest_article_wrapper);
            // 4記事になったらブレイク
            if(i == 3){
                break;
            }
        };

        $.each(data.articles_each_categories, function(index, articles_each_category){
            console.log(articles_each_category);
            $category_other_article_wrapper = $('<div id="'+ index + '" class="flex-container space-between category-other-article-wrapper"></div>');
            $('#wrapper').append($category_other_article_wrapper).append($('<hr>'));

            for(var i=0; i < articles_each_category.length; i++){
                // 各カテゴリー内の最新記事
                if(i == 0){
                    console.log($array_category_name[articles_each_category[i].category] + i + articles_each_category[i].id);
                    $category_name = $('<P class="category-name"></p>').text($array_category_name[articles_each_category[i].category]); //カテゴリーの名前を取得
                    $category_top_article_wrapper = $('<div class="flex-container category-top-article-wrapper ' + articles_each_category[i].id + '"></div>'); //classに記事のidを追加
                    $category_top_article_image = $('<img class="category-top-article-image" src="http://52.199.100.24/admin/' + articles_each_category[i].image_path + '">');
                    $category_top_article_container = $('<div class="category-top-article-container"></div>');
                    $category_top_article_wrapper.append($category_top_article_image).append($category_top_article_container);
                    $category_top_article_title = $('<P></P>').text(articles_each_category[i].title);
                    $category_top_article_like = $('<P></P>');
                    // ログインユーザーにいいねされているか
                    if(sessionStorage.getItem('user_id')){
                        if(data.likes[articles_each_category[i].id]){
                            $category_top_article_like = $('<p style="color: #F54EA2"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-suit-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"/></svg></p>');
                        }
                    }
                    $category_top_article_container.append($category_top_article_title).append($category_top_article_like);
                    $('#' + index).before($category_name).before($category_top_article_wrapper).before($('<hr>'));
                // それ以外の4記事
                }else{
                    $category_each_article_wrapper = $('<div class="flex-container category-each-article-wrapper ' + articles_each_category[i].id + '"></div>');
                    $category_other_article_wrapper.append($category_each_article_wrapper);
                    $category_each_article_image = $('<img class="category-each-article-image" src="http://52.199.100.24/admin/' + articles_each_category[i].image_path + '">');
                    $category_each_article_container = $('<div class="category-each-article-container"></div>');
                    $category_each_article_wrapper.append($category_each_article_image).append($category_each_article_container);
                    $category_each_article_title = $('<p class="category-each-article-title"></p>').text(articles_each_category[i].title);
                    $category_each_article_like = $('<P></P>');
                    if(sessionStorage.getItem('user_id')){
                        if(data.likes[articles_each_category[i].id]){
                            $category_each_article_like = $('<p style="color: #F54EA2"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-suit-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"/></svg></p>');
                        }
                    }
                    $category_each_article_container.append($category_each_article_title).append($category_each_article_like);
                };
            }
        });
        $.each(data.articles, function(index, article){
            $('.' + article.id).click(function(){
                $id = article.id;
                window.location.href = "./article.html?id=" + $id;
            })
        });
    }).fail(function(data){
        console.log(data);
        alert("全取得のエラーです！");
    });
    
});
