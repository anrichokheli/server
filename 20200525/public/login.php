<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<!DOCTYPE html>
<html>
    <style>
        .center {
            text-align: center;
        }
        input[name=name], input[name=password], select {
          width: 80%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
          font-size: 25;
        }
        input[type=submit] {
          width: 100%;
          background-color: gray;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          font-size: 25;
        }
        input[type=submit]:hover {
          background-color: #404040;
        }
        div {
          border-radius: 5px;
          background-color: #f2f2f2;
          padding: 20px;
        }
        label[for=name], label[for=password]    {
            font-size: 25;
        }
	.typewriter {
		width: 25%;
		overflow: hidden;
		border-right: .15em solid blue;
		white-space: nowrap;
		margin: 0 auto;
		letter-spacing: .15em;
		animation: 
			typing 1s steps(20, end),
			blink-caret .25s step-end infinite;
	}
	@keyframes typing {
		from { width: 0 }
		to { width: 25% }
	}
	@keyframes blink-caret {
		from, to { border-color: transparent }
		50% { border-color: blue; }
	}
	#choseButton	{
		border: none;
		color: white;
		padding: 8px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 1px 1px;
		transition-duration: 0.4s;
		cursor: pointer;
		background-color: white; 
		color: black; 
		border-radius: 8px;
		background-color: rgba(192, 192, 192, 0.25);
	}
	#choseButton:hover    {
		background-color: rgba(224, 224, 224, 0.1);
	}
	#draganddrop	{
		transition: background-color 0.25s ease;
		padding: 14px;
		text-align: center;
		border: 2px dashed #808080;
		border-radius: 8px;
		font-size: 14;
		background-color: rgba(208, 208, 208, 0.25);
	}
    </style>
    <div class=center>
        <font style=font-size:40px>
            <b><font color=blue>ქვეითი </font><font color=red>SOS</font></b>
        </font>
        <br><br>
        <image src=<?php include 'get_web_url.php' ?>/qveitiSOS.jpg height=24%></image>
	<p class="typewriter" style="font-size:1.2vw">რეაგირების სისტემაში შესვლა</p>
        <?php
            if(isset($_GET["mode"]) && $_GET["mode"] === "verify")    {
                echo "<span style=font-size:15px;>დამატებითი უსაფრთხოებისთვის, შეიყვანეთ მონაცემები...</span>";
            }
            if(isset($_GET["mode"]) && $_GET["mode"] === "wrong")    {
                echo "<script>window.location.replace('incorrect.php')</script>";
            }
        ?>
        <br>
        <form action=redirect.php enctype="multipart/form-data" method=post>
            <label for="name">სახელი:</label>
            <input type="text" id="name" name="name"><br><br>
            <label for="password" name="name_and_password">პაროლი:</label>
            <input type="password" id="password" name="password"><br><br>
            <label>დამატებითი უსაფრთხოების ფაილი:</label>
            <span id="fileName"></span>
            <label for="keyfile" id="choseButton">ფაილის არჩევა</label>
            <label>ან</label>
            <span id="draganddrop">ჩააგდეთ ფაილი</span>
            <br><br>
            <input type="submit" value="შესვლა" name="login">
            <input type="file" id="keyfile" name="file" style=display:none>
            <input type="hidden" name="n" id="n">
        </form>
    </div>
</html>
<script>
document.getElementById("n").value = window.location.href.substring(window.location.href.indexOf("&n=") + 3);
document.getElementById("keyfile").onchange = function ()	{
	document.getElementById("fileName").innerHTML = document.getElementById('keyfile').files[0].name;
};

let dropbox;

dropbox = document.getElementById("draganddrop");
dropbox.addEventListener("dragenter", dragenter, false);
dropbox.addEventListener("dragover", dragover, false);
dropbox.addEventListener("drop", drop, false);
dropbox.addEventListener("dragleave", dragleave, false);

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
  
  keyfile.files = files;
  document.getElementById("fileName").innerHTML = document.getElementById('keyfile').files[0].name;
  var file = files[0];
  //document.getElementById("droppedFileURL").value = file;
  document.getElementById("draganddrop").style.backgroundColor = "rgb(16, 255, 32)";
  document.getElementById("draganddrop").style.color = "black";
  setTimeout(function()	{
	setDefaultBackgroundColourOfDragAndDrop();
  },
  250
  );
}
</script>