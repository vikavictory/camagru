window.onload = function () {
    var comment = document.getElementById('comment');
    var button = document.getElementById('newComment');
    var data;

    var newComment = function () {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/newcomment', true);
        data = "comment_text=" + comment;
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send("photo=" + encodeURIComponent(base64dataUrl));
    }

    button.addEventListener('click', newComment);



};