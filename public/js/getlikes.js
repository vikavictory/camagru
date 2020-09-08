function getLikes() {
    var xmlhttp = new XMLHttpRequest();
    var photo_id = document.getElementById('photo_id').value;
    console.log(photo_id);
    xmlhttp.open('post', '/getlikes', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send('photo_id=' + photo_id);
    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4) {
            if(xmlhttp.status == 200) {
                var data = xmlhttp.responseText;
                if(data) {
                    data = JSON.parse(data);
                    console.log(data);
                    var element = document.getElementById("likesCount");
                    element.innerText = data.likesCount;
                    var element = document.getElementById("like");
                    if (data.usersLike === true) {
                        element.style.color = "red";
                    } else {
                        element.style.color = "black";
                    }
                    console.log(parent.hasChildNodes())
                }
            }
        }
    };

}

window.addEventListener("load", getLikes);