function getComments() {
    //document.getElementById('comments').innerHTML = "";
    document
    var xmlhttp = new XMLHttpRequest();
    var photo_id = document.getElementById('photo_id').value;
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

                        elem = document.createElement('form');
                        elem.name = "deletecomment";
                        elem.method = "post";
                        parent.appendChild(elem);
                        elem.innerHTML = "<input type=\"hidden\" id=\"comment_id\" value=\"" + data[i].id + "\"/>";
                        elem = document.createElement('hr');
                        parent.appendChild(elem);
                        i++;
                    }
                }
            }
        }
    };

}

window.addEventListener("load", getComments);