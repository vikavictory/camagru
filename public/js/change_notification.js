window.onload = function () {
    var button = document.getElementById('notificationButton');
    var xmlhttp = new XMLHttpRequest();

    var changeNotification = function (event) {
        event.preventDefault();
        xmlhttp.open('POST', '/changenotification', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send();
        xmlhttp.onload = () => {
            if (xmlhttp.status != 200) {
                console.log("ошибка!");
            } else {
                console.log(xmlhttp.response);
            }
        }
        showNotification();
    }

    button.addEventListener('click', changeNotification);
}