var mode = 1;
var base64dataUrl ;
var base64dataUrl_2;
var dX = 80;
var dY = 80;
var size = 200;
let zIndex = 0;
var current;
const getCanvasVideo = () => document.getElementById("canvasVideo");

window.onload = function () {

    var button = document.getElementById('button');
    var saveButton = document.getElementById('saveButton');
    var increaseButton = document.getElementById('increaseButton');
    var decreaseButton = document.getElementById('decreaseButton');
    var cleanButton = document.getElementById('cleanButton');

    var canvas = document.getElementById('canvas');
    var canvasMasks = document.getElementById('canvasMasks');
    var video = document.getElementById('video');
    var context = canvas.getContext('2d');
    var contextMasks = canvasMasks.getContext('2d');
    var image = document.getElementById('image');
    var masksImage = document.getElementById('masksImage');

    var captureMe = function () {
        if (mode === 1) {
            context.translate(canvas.width, 0);
            context.scale(-1, 1);
            context.drawImage(video, 0, 0, video.width, video.height);
            context.setTransform(1, 0, 0, 1, 0, 0);
        } else {
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(image, 0, 0, image.width, image.height);
        }

        const canvasVideo = getCanvasVideo();

        for (let i = 0; i < canvasVideo.children.length; i++) {
            const currentCanvas = canvasVideo.children[i];
            currentCanvas.getContext('2d');
            contextMasks.drawImage(currentCanvas, 0, 0);
        }

        base64dataUrl = canvas.toDataURL('image/png');
        base64dataUrl_2 = canvasMasks.toDataURL('image/png');
        console.log(mode);
    }

    var saveMe = function () {
        var xhr = new XMLHttpRequest();
        var comment = document.getElementById('comment').value;
        var data = "description=" + comment +
            "&photo=" + encodeURIComponent(base64dataUrl) +
            "&masks=" + encodeURIComponent(base64dataUrl_2);
        console.log(data);
        xhr.open('POST', '/save', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(data);
    }

    button.addEventListener('click', captureMe);
    saveButton.addEventListener('click', saveMe);
    increaseButton.addEventListener('click', increase);
    decreaseButton.addEventListener('click', decrease);
    cleanButton.addEventListener('click', clean);

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then(stream => {
            video.srcObject = stream
            video.play();
        });
};

function addMask(mask) {
    current = mask;
    const imgId = "mask_canvas_" + mask;
    let element = document.getElementById(imgId);

    if (element) {
        element.parentNode.removeChild(element);
        current = "";
    } else {
        showMasks();
    }
}

function showMasks() {
    if (current) {
        const imgId = "mask_canvas_" + current;

        let element = document.getElementById(imgId);
        if (element)
            element.parentNode.removeChild(element);

        let maskElement = document.getElementById(current);
        let canvas = document.createElement('canvas');
        canvas.width = 448;
        canvas.height = 336;
        canvas.draggable = true;
        canvas.id = imgId;
        canvas.style.zIndex = zIndex;
        canvas.style.position = 'absolute'
        canvas.addEventListener("click", getClickPosition, false);;

        getCanvasVideo().appendChild(canvas);

        let img = new Image();
        img.src = maskElement.value;

        let context = canvas.getContext('2d');
        context.drawImage(img, dX, dY, size, size);
        zIndex++;
    }
}

function getClickPosition(e) {
    if (current) {
        let rect = getCanvasVideo().getBoundingClientRect();
        dX = e.clientX - rect.left - (size / 2);
        dY = e.clientY - rect.top - (size / 2);
        showMasks(current);
    }
}

function increase() {
    if (current) {
        size += 20;
        showMasks(current);
    }
}

function decrease() {
    if (current) {
        size -= 20;
        if (size < 20)
            size = 20;
        showMasks(current);
    }
}

function uploadPic(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        let image = document.getElementById('image');
        reader.onload = function(e) {
            var file_type = input.files[0].type;
            if (file_type!='image/jpeg' && file_type!='image/png') {
                alert('только jpg и png');
                return ;
            }

            image.style.display = "";
            image.setAttribute('src', e.target.result);
            image.height = 336;
            image.width = 448;
            document.getElementById('video').style.display = "none";
        };
        reader.readAsDataURL(input.files[0]);
        mode = 2;
    }
}

function clean () {
    let image = document.getElementById('image');
    image.style.display = "none";
    image.removeAttribute('src');

    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    context.clearRect(0, 0, canvas.width, canvas.height);

    var canvasMasks = document.getElementById('canvasMasks');
    var contextMasks = canvasMasks.getContext('2d');
    contextMasks.clearRect(0, 0, canvas.width, canvas.height);

    document.getElementById('comment').value = "";

    for (let i = 0; i <= 21; i++) {
        var name = "mask_id_" + i;
        document.getElementById(name).checked = false;
    }

    getCanvasVideo().innerHTML = "";

    document.getElementById('video').style.display = "";
    mode = 1;
}