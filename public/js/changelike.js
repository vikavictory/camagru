window.onload = function () {
    var button = document.getElementById('likeButton');
    var xmlhttp = new XMLHttpRequest();
    var data;

    var changeLike = function (event) {
       // event.preventDefault();
        console.log('event:', event);
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

    var checkLike = function () {
       alert("here1");
    }

    //button.addEventListener('click', changeLike);
    button.addEventListener('click', checkLike);
};