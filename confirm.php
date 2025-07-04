<?php
session_start();
$token = isset($_POST['token']) ? $_POST['token']: '';
$email_pattern = '~^[a-zA-Z0-9._?+-/]{0,63}@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$~';
$session_token = isset($_SESSION['token']) ? $_SESSION['token']: '';
$_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : '';
$_SESSION['email'] = isset($_POST['email']) ? $_POST['email'] : '';
$_SESSION['message'] = isset($_POST['message']) ? $_POST['message'] : '';
$_SESSION['check1'] = isset($_POST['check1']) ? 'checked' : '';
$_SESSION['check2'] = isset($_POST['check2']) ? 'checked' : '';
$_SESSION['check3'] = isset($_POST['check3']) ? 'checked' : '';
$_SESSION['check4'] = isset($_POST['check4']) ? 'checked' : '';

$confirm = 'confirm';
#正しく入力されているか確認
$_SESSION['name_error'] = empty($_POST['name']) ? 'お名前の入力は必須です。' : '';
if(empty($_POST['email'])) {$_SESSION['email_error'] = 'メールアドレスの入力は必須です。';} elseif (!preg_match($email_pattern, $_POST['email'])) {
    $_SESSION['email_error'] = 'メールアドレスは正しい形式で入力してください。'; } else {$_SESSION['email_error'] = ''; }

if(!isset($_POST['check1']) && !isset($_POST['check2']) && !isset($_POST['check3']) && !isset($_POST['check4'])) {
    $_SESSION['check_error'] = '1つ以上選択してください。';
} else {$_SESSION['check_error'] = '';}
if(isset($_POST['check4']) && empty($_POST['message'])) {
    $_SESSION['message_error'] = 'その他を選択した場合は詳細をご入力ください。';
} else {$_SESSION['message_error'] = ''; }
#入力されていない　又は 形式が正しくない場合はinde.phpに戻す
if(!empty($_SESSION['name_error']) || !empty($_SESSION['email_error']) || !empty($_SESSION['check_error']) || !empty($_SESSION['message_error'])) {
    header('Location: index.php');
    exit();
}
if ($token == $session_token) { ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問合せ内容の確認</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="resoult.php">
        <label for="name">お名前</label><br>
        <textarea name="name" id="name" readonly class="textarea-confirm"><?php echo $_SESSION['name'] ?></textarea><br>
        <label for="email">メールアドレス</label><br>
        <textarea name="email" id="email" readonly class="textarea-confirm"><?php echo $_SESSION['email'] ?></textarea><br>
        <label for="check">お問合せ内容</label><br>
        <input type="checkbox" name="check1" id="check1" disabled <?php echo $_SESSION['check1'] ?>><label for="check1">賃貸について</label>
        <input type="checkbox" name="check2" id="check2" disabled <?php echo $_SESSION['check2'] ?>><label for="check2">売買について</label>
        <input type="checkbox" name="check3" id="check3" disabled <?php echo $_SESSION['check3'] ?>><label for="check3">採用について</label>
        <input type="checkbox" name="check4" id="check4" disabled <?php echo $_SESSION['check4'] ?>><label for="check4">その他</label><br>
        <label for="message">詳細</label><br>
        <textarea name="message" id="message" readonly class="textarea-confirm"><?php echo $_SESSION['message'] ?></textarea><br>
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <input type="submit" value="送信">
    </form>
    <form action="index.php" method="get">
        <input type="submit" value="戻る">
    </form>
</body>
</html>
<?php } else {
    header('Location: resoult.php');
}
?>