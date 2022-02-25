<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="media/2f9f7ab1ef9b775ba93e08d27cc127c5.jpg" type="image/text">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <form method="post">
        <button name="refresh" id="refresh">
            <ion-icon name="refresh-outline"></ion-icon>
        </button>
    </form>
    <button class="userButton" onclick="userPanel()">Login/Register</button>
    <script>
        var userManagement = document.getElementById('userManagement');

        var isOpened1 = false;

        function userPanel() {
            console.log("apple")
            if (isOpened1 == false) {
                isOpened1 = true
                userManagement.style.display = "none"
            } else if (isOpened1 == true) {
                isOpened1 = false
                userManagement.style.display = "block"
            }
        }
    </script>
    <div class="userManagement" id="userManagement">
        <form method="post" enctype="multipart/form-data">
            <div class="userManagement_content" id="userManagementConetnt">
                <h1>Register</h1>
                name: <input type="text" name="userName" id="userName">
                password: <input type="password" name="userPass"></input>
                profile pics:
                <input name="fileInput" type="file"></input>
                <button type="" name="submit">Register user</button>
                <hr>
                <h1>Login</h1>
                name: <input name="LoginuserName"></input>
                password: <input type="password" name="loginuserPass"></input>
                <button name="loginSubmit">login</button>
        </form>
    </div>
    </div>
    <form class="messager" method="post">
        <textarea name="userComment" class="userComment" type="text" id="userComment"></textarea>
        <button name="submitButton">
            <ion-icon name="paper-plane-outline"></ion-icon>
        </button>
    </form>
</body>

</html>
<script src="chat.js">
</script>
<?php





$file;
if (isset($_POST['refresh'])) {
    header('location: http://ggsitechat.42web.io/');
}
if (isset($_POST['submit'])) {
    createUser();
}

if (isset($_POST['nameCheckButton'])) {
    if (file_exists("users/" .$_POST['checkName'].".json")) {
        echo $_POST['checkName']." exsist";
    } else {
        echo "this user is not created yet";
    }
}

function checkUsers() {

}

function createUser() {
    move_uploaded_file($_FILES['fileInput']['tmp_name'], "userimages/" .$_POST['userName'] . ".jpg");

    if (file_exists("users/" .$_POST['userName'].".json")) {
        echo "This name is already taken";
    } else {
        $file = fopen("users/" . $_POST['userName'] . ".json","w");
        $regData  = "{
            ".'"'. "name" .'"' .":". '"' . $_POST['userName'] . '",' . "\n".
            '"' . "pass" . '"'. ":" . '"' . $_POST['userPass'] . '"'."
        }";
        if (strlen($_POST['userPass']) > 0){
            fwrite($file, $regData);
			$userPage = fopen("userPages/" . $_POST['userName'].".php","w");

      $pageText = '
      <head>
      <link rel="stylesheet" href="../stat.css">
      <title>'. $_POST['userName'] .' user page</title>
      </head>
      <div class="stats">
        <b>Name</b>:' . $_POST['userName'] . '
        <br>
        <hr>
        <b>Role</b>:member
      </div>
      <img src=' . "../userimages/" .$_FILES['fileInput']['name'] . '>
      ';
      fwrite($userPage,$pageText);
            include "/chat.php";
			setcookie("name",$_POST['userName']);
        } else {
            echo "password is too short";
        }
    }
}
if (isset($_POST['loginSubmit'])) {
   $loginData = json_decode(file_get_contents('users/'.$_POST['LoginuserName'].'.json'), true);
   //echo $loginData['name'];
    if (file_exists("users/" .$_POST['LoginuserName'].".json")) {
        if ($_POST['loginuserPass'] == $loginData['pass']) {
           setcookie("name",$loginData['name']);
           global $loginData;
            echo "login succes" . $ChatuserName;
        }else {
            echo "wrong name or password";
        }
    }
}
?>
<?php

error_reporting(E_ERROR | E_PARSE);



$Commentfile = fopen("comments.public","a");


function comment($ChatuserName) {
    if (strlen($ChatuserName) > 0) {
        $filename = getcwd() . "\comments.public";
        $line_i_am_looking_for = 123;
        $lines = file( $filename , FILE_IGNORE_NEW_LINES );

        $text = "<div class='message'><img style='width: 2.5vw;height: 2.5vw;'  id='userPics' src=userimages/". $_COOKIE['name'] . ".jpg".">" . '[' . '<b><a href="/buttonArts/userPages/'.$ChatuserName.'.php">' .$ChatuserName . '</b></a>' . ']' . "<ion-icon name='caret-forward-outline'></ion-icon>" . "<div class='messageFrame'><u>" . $_POST['userComment'] . "</u>" . "</div><b class='messageTime'>" . date("Y/m/d:h:i:sa") . "</b></div><hr>";
        $line_i_am_looking_for = $line_i_am_looking_for + 1;
        $lines[$line_i_am_looking_for] = $text;
        if (strlen($_POST['userComment']) > 0) {
          file_put_contents( $filename , implode( "\n", $lines ) );
        }
    } else {

    }
}

        if (isset($_POST['submitButton'])) {

            comment($_COOKIE["name"]);
        }
    $file2 = fopen("comments.public", "r");
    //Output lines until EOF is reached

    fclose($Commentfile);
    include "license.html";
?>
    <div class="messagesPanel">
    <?php
            while(! feof($file2)) {
                $line = fgets($file2);
                echo $line. "<br>";
              }
    ?>        
    </div>