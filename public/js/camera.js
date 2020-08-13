
window.onload = function () {
    var canvas = document.getElementById('canvas');
    var video = document.getElementById('video');
    var button = document.getElementById('button');
    var context = canvas.getContext('2d')
    var img = new Image();

    var captureMe = function () {
        context.translate(canvas.width, 0);
        context.scale(-1, 1);
        context.drawImage(video, 0, 0, video.width, video.height);
        var base64dataUrl = canvas.toDataURL('image/png');
        context.setTransform(1, 0, 0, 1, 0, 0);

        // отправить на сервер в этом месте
        img.src = base64dataUrl; // window.document.body.appendChild(img);
    }

    var saveMe = function () {
        var xhr = new XMLHttpRequest();


        xhr.open('POST', '/photo/save', false);


        xhr.open("POST", '/submit', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


    }

    button.addEventListener('click', captureMe);
    saveButton.addEventListener('click', saveMe);

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then(stream => {
            video.srcObject = stream
            video.play();
        });
};
