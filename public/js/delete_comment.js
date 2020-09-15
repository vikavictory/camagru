function deleteComment(obj) {
   // var string = document.getElementById()
    //var comment_id = document.getElementById('comment_id');
    //var user_id = document.getElementById('comment_user_id');

    var comment_id = obj.value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/deletecomment', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send("comment_id=" + encodeURIComponent(comment_id));
    deleteCommentElement(comment_id);

}

function deleteCommentElement(comment_id){
    var el = document.getElementById('comment_id_' + comment_id);
    el.parentNode.removeChild(el);
}

