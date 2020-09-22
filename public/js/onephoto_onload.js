window.onload = function () {
    var button = document.getElementById('commentButton');
    var deleteButton = document.g
    var xmlhttp = new XMLHttpRequest();
    var data;

    var newComment = function (event) {
        event.preventDefault();
        console.log('event:', event);
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
        console.log('data newcomment',data);
        xmlhttp.send(data);
        xmlhttp.onload = () => {
            if (xmlhttp.status != 200) {
                console.log("аааашибка!");
            } else {
                console.log(xmlhttp.response);
            }
        }
        document.newcomment.reset();
        getComments();
    }
    button.addEventListener('click', newComment);

    var button2 = document.getElementById('likeButton');
    var changeLike = function (event) {
        event.preventDefault();
        var user_id = document.getElementById('user_id').value;
        var photo_id = document.getElementById('photo_id').value;
        xmlhttp.open('POST', '/changelike', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        data = "user_id=" + encodeURIComponent(user_id) +
            "&photo_id=" + encodeURIComponent(photo_id);
        xmlhttp.send(data);
        xmlhttp.onload = () => {
            if (xmlhttp.status != 200) {
                console.log("аааашибка!");
            } else {
                console.log(xmlhttp.response);
            }
        }
        console.log("here");
        getLikes();
    }

    button2.addEventListener('click', changeLike);
    console.log(document.cookie);
};