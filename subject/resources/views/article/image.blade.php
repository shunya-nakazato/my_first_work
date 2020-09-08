@extends('layouts.app')

@section('title', '画像テスト')

@section('content')
    <style>        
        .user-icon-dnd-wrapper {
            position: relative;
            width: 100%;
            height: 300px;
        }

        #preview_field {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 300px;
            text-align: center;
        }

        #drop_area {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 300px;
            border: 1px dashed #aaa;
            cursor: pointer;
            background-color: #fff;
        }

        #drop_area:hover {
            background-color: #EEEEEE;
        }

        #drag_and_drop {
            text-align: center;
            line-height: 300px;
        }

        #image_clear_button {
            display: none;
            position: absolute;
            top: -4px;
            right: -8px;
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        .material-icons {
            width: 100%;
            height: auto;
        }

        #input_file {
            width: 100%;
            height: 300px;
            opacity: 0;
        }

        #input_file:focus {
            opacity: 1; 
        }

        .image {
            height: 300px;
            width: auto;
        }
    </style>

    <div class="container">
        <form action='{{ route("image_confirm") }}' method='POST' enctype="multipart/form-data" id='image-form'>
            @csrf
            <div class="user-icon-dnd-wrapper">
                <input type="file" name="article_image" id="input_file" accept="image/*">
                <div id="preview_field"></div>
                <div id="drop_area"><p id="drag_and_drop">+画像をドロップ、または選択してください</p></div>
                <div id="image_clear_button"><span class="material-icons" style="font-size: 40px;">cancel_presentation</span></div>
            </div>
            <input type="submit" value="送信">
        </form>
    </div>
    <script>
        $(function () {
            // クリックで画像を選択する場合
            $('#drop_area').on('click', function () {
                $('#input_file').click();
            });

            $('#input_file').on('change', function () {
                // 画像が複数選択されていた場合
                if (this.files.length > 1) {
                alert('画像は1つだけ選択してください');
                $('#input_file').val('');
                return;
                }
                handleFiles(this.files);
            });

            // ドラッグで画像を選択
            // ドラッグしている要素がドロップ領域に入ったとき・領域にある間
            $('#drop_area').on('dragenter dragover', function (event) {
                event.stopPropagation();
                event.preventDefault();
                $('#drop_area').css('border', '1px solid #333');  // 枠を実線にする
            });

            // ドラッグしている要素がドロップ領域から外れたとき
            $('#drop_area').on('dragleave', function (event) {
                event.stopPropagation();
                event.preventDefault();
                $('#drop_area').css('border', '1px dashed #aaa');  // 枠を点線に戻す
            });

            // ドラッグしている要素がドロップされたとき
            $('#drop_area').on('drop', function (event) {
                event.preventDefault();
                $('#input_file')[0].files = event.originalEvent.dataTransfer.files;

                // 画像が複数選択されていた場合
                if ($('#input_file')[0].files.length > 1) {
                    alert('画像は1つだけ選択してください');
                    $('#input_file').val('');
                    return;
                }
                handleFiles($('#input_file')[0].files);
            });

            function handleFiles(files) {
                var file = files[0];
                var imageType = 'image.*';

                // ファイルが画像が確認する
                if (! file.type.match(imageType)) {
                    alert('画像を選択してください');
                    $('#input_file').val('');
                    $('#drop_area').css('border', '1px dashed #aaa');
                    return;
                }

                if(file.size > 2000000){
                    alert('ファイルサイズが2MBを越えています' + '(' + file.size + 'バイト' + ')');
                    $('#input_file').val('');
                    $('#drop_area').css('border', '1px dashed #aaa');
                    return;
                }

                $('#drop_area').hide();  // いちばん上のdrop_areaを非表示にします
                $('#image_clear_button').show();  // image_clear_buttonを表示させます

                var img = document.createElement('img');  // <img>をつくります
                var reader = new FileReader();
                reader.onload = function () {  // 読み込みが完了したら
                    img.src = reader.result;  // readAsDataURLの読み込み結果がresult
                    $('#preview_field').append(img);  // preview_filedに画像を表示
                    img.classList.add("image");//ファイルの大きさをかえるためのクラスを追加
                }
                reader.readAsDataURL(file); // ファイル読み込みを非同期でバックグラウンドで開始
            } 

            // アイコン画像を消去するボタン
            $('#image_clear_button').on('click', function () {
                $('#preview_field').empty();  // 表示していた画像を消去
                $('#input_file').val('');  // inputの中身を消去
                $('#drop_area').show();  // drop_areaをいちばん前面に表示
                $('#image_clear_button').hide();  // image_clear_buttonを非表示
                // $('#drop_area').css('border', '1px dashed #aaa');  // 枠を点線に変更
            })

            // drop_area以外でファイルがドロップされた場合、ファイルが開いてしまうのを防ぐ
            $(document).on('dragenter', function (event) {
                event.stopPropagation();
                event.preventDefault();
            });
            $(document).on('dragover', function (event) {
                event.stopPropagation();
                event.preventDefault();
            });
            $(document).on('drop', function (event) {
                event.stopPropagation();
                event.preventDefault();
            });
        })
    </script>
@endsection
