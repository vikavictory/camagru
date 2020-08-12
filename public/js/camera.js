
window.onload = function () {
    var canvas = document.getElementById('canvas');
    var video = document.getElementById('video');
    var button = document.getElementById('button');
    var context = canvas.getContext('2d')

    var captureMe = function () {
        context.translate(canvas.width, 0);
        context.scale(-1, 1);
        context.drawImage(video, 0, 0, video.width, video.height);
        var base64dataUrl = canvas.toDataURL('image/png');
        context.setTransform(1, 0, 0, 1, 0, 0);

        // отправить на сервер в этом месте

        var img = new Image();
        img.src = base64dataUrl;
       // window.document.body.appendChild(img);
    }

    button.addEventListener('click', captureMe);

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then(stream => {
            video.srcObject = stream
            video.play();
        });
};
