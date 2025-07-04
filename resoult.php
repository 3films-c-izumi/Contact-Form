<?php
session_start();
$token = isset($_POST['token']) ? $_POST['token'] : '';
$session_token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
unset($_SESSION['token']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php if ($token == $session_token) { ?>
    <title>お問合せ完了</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>お問合せいただきありがとうございました。</h1>
<?php 
$_SESSION = array();
$_POST = array();
} else { ?>
<title>エラー</title>
<h1>不正なリクエスト</h1>
<p>お手数ですが、最初からやり直してください。</p>
<?php } ?>
<form action="index.php" method="get">
    <input type="submit" value="戻る">
</form>
</body>
</html>