<?php
if(session_status() != PHP_SESSION_ACTIVE)	{
	session_start();
}
$logged_in = (isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true);
include 'more.php';
if(!$logged_in)    {
	session_destroy();
	exit;
}
?>
<html>
<div id="notice" class="modal">

  <!-- Modal content -->
  <div class="modal-content" id="rounded">
    <span onclick="document.getElementById('notice').style.display='none'" class="close" title="დახურვა">×</span>
    <div class="container">
      <h1><font class="samecolourindarkmode" color="blue">ქვეითი</font> <font class="samecolourindarkmode" color="red">SOS</font></h1>
      <p>რეაგირების შესახებ ინფორმაცია უნდა შეიცავდეს ტექსტსაც და ფაილსაც</p>
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('notice').style.display='none'" id="ok">გასაგებია</button>
      </div>
    </div>
  </div>

</div>
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="დახურვა">×</span>
  <form class="modal-content">
    <div class="container">
      <h1>გაფრთხილება!</h1>
      <p>ღილაკ "წაშლის დაწყება"-ზე დაჭერის შემთხვევაში, დაიწყება პროცესი, რომლის დასრულების შემთხვევაში, წაიშლება ეს სურათი/ვიდეო და თანდართული მონაცემები</p>
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">გაუქმება</button>
        <button type="button" onclick="openDelete()" class="deletebtn">წაშლის დაწყება</button>
      </div>
    </div>
  </form>
</div>
<div id="id02" class="modal">
  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="დახურვა">×</span>
  <form class="modal-content" id="rounded">
    <div class="container">
      <h1><font color="blue">ქვეითი</font> <font color="red">SOS</font></h1>
      <p id="windowText"></p>
      <p id="reacttext"></p>
      <span id="reactmedia"></span>
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" id="cancel">გაუქმება</button>
        <button type="button" id="upload"></button>
      </div>
    </div>
  </form>
</div>
    <body>
        <audio hidden src="warningsound.wav" id="warningSound"></audio>
        <script>
function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  
  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
        function confirmdelete()   {
            document.getElementById('warningSound').play();
            document.getElementById('id01').style.display='block';
            //if(confirm("გაფრთხილება!\nატვირთული მასალის წაშლა უნდა მოხდეს მხოლოდ იმ შემთხვევაში, თუ ის არის შეუსაბამო ან/და ატვირთულია სერვერის გავსების, მუშაობის შეფერხების მიზნით")) {
                //window.open("/delete.php");
            //}
        }
        function confirmreact() {
            if((document.getElementById("text").value.trim() !== "") && (document.getElementById("preview").innerHTML !== ""))    {
                document.getElementById("reacttext").innerHTML = "რეაგირების ტექსტი:<br>" + escapeHtml(document.getElementById("text").value).replace(/(?:\r\n|\r|\n)/g, '<br>');
		document.getElementById("windowText").innerHTML = "რეაგირების შესახებ ინფორმაციის დართვისთვის, დააჭირეთ ღილაკს - ატვირთვა";
		okButton = document.getElementById("upload");
		okButton.innerHTML = "ატვირთვა";
		okButton.onclick = function(){react()};
                document.getElementById('id02').style.display='block';
            }
            else    {
                document.getElementById("notice").style.display = "block";
            }
            //return confirm("რეაგირების შესახებ ინფორმაციის დართვისთვის, დააჭირეთ ღილაკს - OK");
        }
        </script>
    </body>
</html>
<script>
reactRequest = new XMLHttpRequest();
reactRequest.onreadystatechange = function()	{
	if(this.responseText !== "")	{
		document.getElementById("reactElement").innerHTML = this.responseText;
	}
};
function react()    {
	document.getElementById('id02').style.display='none';
	reactRequest.open("POST", "react_save.php");
	reactRequest.send(new FormData(document.getElementById("react_submit")));
}
function openDelete()    {
    document.getElementById('id01').style.display='none';
    //window.open(window.location.href.replace("react", "delete"));
    var n_id = Date.now() + Math.floor(Math.random() * 1000);
    //document.cookie = "n=\"*" + n_id + "#[" + new URL(window.location.href).searchParams.get("n") + "]\";";
    document.cookie = n_id + '=' + new URL(window.location.href).searchParams.get("n") + ';';
    window.open("delete.php?id=" + n_id);
}
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');
var noticeModal = document.getElementById("notice");
window.onclick = function(event) {
  if (event.target == modal1) {
    modal1.style.display = "none";
  }
  else if (event.target == modal2) {
    modal2.style.display = "none";
  }
  else if(event.target == noticeModal)    {
    noticeModal.style.display = "none";
  }
}
function setPreview(file)	{
	var fileURL = URL.createObjectURL(file);
	var fileType = file.type;
	var fileName = file.name;
	document.getElementById("fileName").innerHTML = fileName;
	if(fileType.includes("image"))	{
		var filePreview = "<img class=preview src=" + fileURL + "></img>";
	}
	else if(fileType.includes("video"))	{
		var filePreview = "<video controls class=preview src=" + fileURL + "></video>";
	}
	else	{
		var filePreview = "<a style=font-size:32px target=_blank href=" + fileURL + ">ატვირთული ფაილის ნახვა</a>";
	}
	document.getElementById("preview").innerHTML = filePreview;
	document.getElementById("reactmedia").innerHTML = filePreview;
}
fileElement = document.getElementById("media");
if(fileElement != null)	{
	fileElement.onchange = function ()	{
		var file = document.getElementById('media').files[0];
		setPreview(file);
	};
}

let dropbox;

dropbox = document.getElementById("draganddrop");
if(dropbox != null)	{
	dropbox.addEventListener("dragenter", dragenter, false);
	dropbox.addEventListener("dragover", dragover, false);
	dropbox.addEventListener("drop", drop, false);
	dropbox.addEventListener("dragleave", dragleave, false);
}
function setDefaultBackgroundColourOfDragAndDrop()	{
  document.getElementById("draganddrop").style.backgroundColor = "rgba(208, 208, 208, 0.25)";
}

function dragenter(e) {
  e.stopPropagation();
  e.preventDefault();
  document.getElementById("draganddrop").style.backgroundColor = "rgb(32, 16, 255)";
  document.getElementById("draganddrop").style.color = "white";
}

function dragleave(e) {
  e.stopPropagation();
  e.preventDefault();
  setDefaultBackgroundColourOfDragAndDrop();
  document.getElementById("draganddrop").style.color = "black";
}

function dragover(e) {
  e.stopPropagation();
  e.preventDefault();
} 

function drop(e) {
  e.stopPropagation();
  e.preventDefault();

  const dt = e.dataTransfer;
  const files = dt.files;

  //handleFiles(files);
  
  media.files = files;
  var file = files[0];
  //document.getElementById("droppedFileURL").value = file;
  setPreview(file);
  document.getElementById("draganddrop").style.backgroundColor = "rgb(16, 255, 32)";
  document.getElementById("draganddrop").style.color = "black";
  setTimeout(function()	{
	setDefaultBackgroundColourOfDragAndDrop();
  },
  250
  );
}
</script>
<?php
//}
//else    {
    //session_destroy();
    //echo "<script>
    //window.location.replace('more.php?n=" . $_GET["n"] . "');
    //</script>";
    //header('location: login.php');
//}
?>