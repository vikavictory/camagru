window.onload = function () {
    //var comment = document.getElementById('comment');
    var button = document.getElementById('commentButton');
    var xmlhttp = new XMLHttpRequest();
    var data;

    var newComment = function () {
        var comment = document.getElementById('comment').value;
        var user_id = document.getElementById('user_id').value;
        var photo_id = document.getElementById('photo_id').value;

        if(comment === '') {
            alert('Введите комментарий');
            return false;
        }
        xmlhttp.open('POST', '/newcomment', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        data = "user_id=" + encodeURIComponent(user_id) +
            "&photo_id=" + encodeURIComponent(photo_id) +
            "&comment=" + encodeURIComponent(comment);
        alert(data);
        xmlhttp.send(data);
    }
    button.addEventListener('click', newComment);
};