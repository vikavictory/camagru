var canvas = document.getElementById('canvas');
var video = document.getElementById('video');
var button = document.getElementById('button');
var context = canvas.getContext('2d')
var img = new Image();
var base64dataUrl ;
const getCanvasVideo = () => document.getElementById("videoId");
const getCanvasPhoto = () => document.getElementById("canvas");

window.onload = function () {

    var captureMe = function () {
        context.translate(canvas.width, 0);
        context.scale(-1, 1);
        context.drawImage(video, 0, 0, video.width, video.height);
        base64dataUrl = canvas.toDataURL('image/png');
        console.log(base64dataUrl);
        context.setTransform(1, 0, 0, 1, 0, 0);
        img.src = base64dataUrl;
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

function addMask(mask) {

    alert("here")

    var element = document.getElementById(mask);

    let canvas2 = document.createElement('canvas');
    canvas2.width = 320;
    canvas2.height = 240;
    canvas2.draggable = true;
    canvas2.id = mask;
    canvas2.style.zIndex = 3;
    canvas2.style.position = 'absolute';
    getCanvasVideo().appendChild(canvas2);

    var img2 = new Image();
    img2.src = document.getElementById(element).value;

    var context = canvas2.getContext('2d');
    context.drawImage(img2, 100, 100, 100, 100);

    maxZIndex++;

}
