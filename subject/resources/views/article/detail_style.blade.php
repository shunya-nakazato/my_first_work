<style>
    /* 画像 */
    .user-icon-dnd-wrapper {
        position: relative;
        width: 100%;
        height: 300px;
        border-radius: 0.25rem;
    }

    #preview_field {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 300px;
        text-align: center;
        border-radius: 0.25rem;
    }

    #drop_area {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 300px;
        border: 1px dashed #aaa;
        cursor: pointer;
        background-color: #fff;
        border-radius: 0.25rem;
    }

    #drop_area:hover {
        background-color: #EEEEEE;
    }

    #drag_and_drop {
        text-align: center;
        line-height: 300px;
    }

    #image_clear_button {
        position: absolute;
        top: -4px;
        right: 0px;
        width: 40px;
        height: 40px;
        cursor: pointer;
    }

    .material-icons {
        width: 100%;
        height: auto;
        color: #9A9FB6;
    }

    .material-icons:hover {
        color: #403E4E;
    }

    #input_file {
        width: 100%;
        height: 300px;
        opacity: 0;
        border-radius: 0.25rem;
    }

    #input_file:focus {
        opacity: 1; 
    }

    .image {
        height: 300px;
        width: auto;
    }

    .error-message {
        color: red;
    }
</style>