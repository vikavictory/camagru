function getComments(count = 0) {
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
                    for(var i = 0; i < data.length; i++) {
                        var parent = document.getElementsByTagName('body')[0];
                        var elem = document.createElement('div');
                        elem.className = 'comments';
                        parent = parent.appendChild(elem);
                        elem = document.createElement('span');
                        parent.appendChild(elem);
                        var text = data[i].name;
                        var textNode = document.createTextNode(text);
                        elem.appendChild(textNode);
                        elem = document.createElement('hr');
                        parent.appendChild(elem);
                        elem = document.createElement('div');
                        elem.className = 'comment';
                        parent.appendChild(elem);
                        text = data[i].comment;
                        textNode = document.createTextNode(text);
                        elem.appendChild(textNode);
                        var max = data[i].id;
                    }
                    count = max;
                }
            }
        }
    };
    setTimeout(function() {
        getComments(count);
    }, 3000);
}