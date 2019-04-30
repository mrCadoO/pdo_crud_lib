<?php
require_once("class.database.php");
require_once("database_object.php");

if(isset($_POST['submit'])){

    $arr[] = $_POST['user_name'];
    $arr[] = $_POST['password'];
    if(empty($_POST['user_name']) || empty($_POST['password'])){
        redirect_to('test_form.php');
    } else {
        $database = new Database_object();
        $database->fill($arr);
        $database->save();
    }




   /* $sql = "INSERT INTO user (user_name, password) VALUES (:user_name, :password)";
    $query = new Database();
    $query->Execute($sql, [':user_name' => $user_name, ':password' => $password]); */
}


/* $sql = "SELECT * FROM user";
$results = Database::GetInstance()->FetchAllClass($sql);
foreach($results as $result) {
    echo $result->user_name . "<br />";
} */


$result = Database_object::GetInstance()->get('*', 'password', '1234');
foreach($result as $item) {
    echo $item['password'] ."<br >". $item['user_name'];
}

?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<form action="test_form.php" method="post" style="margin-left: 320px; margin-top: 50px;">
    <label for="text_1">For user_name</label>
    <input type="text" id="text_1" name="user_name"><br /><br />
    <label for="text_2">For password</label>
    <input type="text" id="text_2" name="password"><br /><br />
    <input type="submit" name="submit">
</form>


</body>
</html>

<?php
function redirect_to($location){
    header('Location:'.$location);
}
?>
