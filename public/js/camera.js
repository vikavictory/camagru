
window.onload = function () {
    var canvas = document.getElementById('canvas');
    var video = document.getElementById('video');
    var button = document.getElementById('button');
    var context = canvas.getContext('2d')
    var img = new Image();
    var base64dataUrl ;

    var captureMe = function () {
        context.translate(canvas.width, 0);
        context.scale(-1, 1);
        context.drawImage(video, 0, 0, video.width, video.height);
        base64dataUrl = canvas.toDataURL('image/png');
        console.log(base64dataUrl);
        context.setTransform(1, 0, 0, 1, 0, 0);

        // отправить на сервер в этом месте
        img.src = base64dataUrl; // window.document.body.appendChild(img);
    }

    var saveMe = function () {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/save', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send("photo=" + encodeURIComponent(base64dataUrl));
    }

    button.addEventListener('click', captureMe);
    saveButton.addEventListener('click', saveMe);

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then(stream => {
            video.srcObject = stream
            video.play();
        });
};
