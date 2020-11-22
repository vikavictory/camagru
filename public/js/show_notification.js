function showNotification() {
    var xmlhttp = new XMLHttpRequest();
    var button = document.getElementById('notificationButton');
    var data;

    xmlhttp.open('post', '/checknotification', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4) {
            if(xmlhttp.status == 200) {
                data = xmlhttp.responseText;
                if(data) {
                    data = JSON.parse(data);
                    if (data.result === true) {
                        button.innerText = "Отключить уведомления";
                    } else {
                        button.innerText = "Включить уведомления";
                    }
                }
            }
        }
    };
}

window.addEventListener("load", showNotification);