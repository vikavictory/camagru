function getComments() {
    //document.getElementById('comments').innerHTML = "";
    document
    var xmlhttp = new XMLHttpRequest();
    var photo_id = document.getElementById('photo_id').value;
    var activeUserId = get_cookie("user_id")
    console.log(photo_id);
    xmlhttp.open('post', '/getcomments', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send('photo_id=' + photo_id);
    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4) {
            if(xmlhttp.status == 200) {

                var data = xmlhttp.responseText;
                if(data) {
                    data = JSON.parse(data);
                    var i = 0;
                    var childrensLength = document.getElementById('here2').children.length;
                    var dataLength = data.length;
                    if (childrensLength > 0) {
                        i = dataLength - 1;
                    }
                    while( i < dataLength) {
                        var parent = document.getElementsByClassName('here')[0];
                        var elem = document.createElement('div');
                        elem.className = 'comments';
                        elem.id = "comment_id_" + data[i].id;

                        parent = parent.appendChild(elem);
                        elem = document.createElement('span');
                        parent.appendChild(elem);
                        var text = data[i].created_at + " ";
                        var textNode = document.createTextNode(text);
                        elem.appendChild(textNode);
                        elem = document.createElement('span');
                        parent.appendChild(elem);
                        text = data[i].login;
                        textNode = document.createTextNode(text);
                        elem.appendChild(textNode);
                        elem = document.createElement('div');
                        elem.className = 'comment';
                        parent.appendChild(elem);
                        text = data[i].comment_text;
                        textNode = document.createTextNode(text);
                        elem.appendChild(textNode);

                        if (data[i].user_id == activeUserId) {
                            elem = document.createElement('button');
                            elem.className = "btn btn-outline-secondary";
                            elem.id = "deletecomment";
                            elem.value = data[i].id;
                            elem.onclick = function() {
                                deleteComment(this);
                            };
                            elem.innerHTML = "Удалить комментарий";
                            parent.appendChild(elem);
                        }

                        elem = document.createElement('hr');
                        parent.appendChild(elem);
                        i++;
                    }
                }
            }
        }
    };

    function get_cookie(cookie_name)
    {
        var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

        if (results) {
            return (unescape(results[2]));
        } else {
            return null;
        }
    }
    console.log("activeUserId=" + activeUserId);
}

window.addEventListener("load", getComments);