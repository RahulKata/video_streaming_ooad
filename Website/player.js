var commentss       = [];
var commentsInput   = document.getElementById("comments form22");
var messageBox      = document.getElementById("display");
var like            = document.getElementsByClassName('fa fa-thumbs-up');
var count           = document.getElementById('count');
var usr             = document.getElementById("usr");
var like            = document.getElementsByClassName('col-sm-1 shr');
var image           = document.getElementById('output');

var loadFile = function(event) {
	image.src = URL.createObjectURL(event.target.files[0]);
};

function changeColor(e) {
    count.innerHTML++;
}

function insert () {
    var current = new Date();
    var dateTime = current.getFullYear() + '-' + (current.getMonth() + 1) + '-' + current.getDate() + ' ' + current.getHours() + ":" + current.getMinutes() + ":" + current.getSeconds();
    if(commentsInput.value=="")
        alert("Blank Comment");
    if(usr.value=="")
        alert("Input username");
    if(usr.value!=""&&commentsInput.value!=""){
        if(image.src!=""){
            commentss.push("<img class='rounded-circle avatar' style='object-fit: cover;width:100px;height:100px;' src='"+image.src+"'/><h5 class='font-weight-bold'>"+usr.value+"<div class='time'>"+dateTime+"</div></h5>"+"<p class='opin'>"+commentsInput.value+"</p><br/>");
        }
        else{
            commentss.push("<img class='rounded-circle avatar' style='object-fit: cover;width:100px;height:100px;' src='https://mdbootstrap.com/img/Photos/Avatars/avatar-10.jpg'/><h5 class='font-weight-bold'>"+usr.value+"<div class='time'>"+dateTime+"</div></h5>"+"<p class='opin'>"+commentsInput.value+"</p><br/>");
        }
        clearAndShow();
    }
}
    
function clearAndShow (){
    console.log(image.src);
    commentsInput.value = "";
    usr.value = "";
    messageBox.innerHTML = "";
    messageBox.innerHTML += " <div class='quote'>" + commentss.join("<br/> ") + "<br/></div>"+ "<br/>";
}
