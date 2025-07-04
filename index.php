<?php
session_cache_limiter('none');
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = uniqid("",true);
}
$token = $_SESSION['token'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="confirm.php">
        <label for="name">お名前   <label class="error" for="name"><?php echo isset($_SESSION['name_error']) ? $_SESSION['name_error'] : ''; ?></label></label><br>
        <textarea name="name" id="name"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?></textarea><br>
        <label for="email">メールアドレス   <label class="error" for="email"><?php echo isset($_SESSION['email_error']) ? $_SESSION['email_error'] : ''; ?></label></label><br>
        <textarea name="email" id="email"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?></textarea><br>
        <label for="check">お問合せ内容   <label class="error" for="check"><?php echo isset($_SESSION['check_error']) ? $_SESSION['check_error'] : ''; ?></label></label><br>
        <input type="checkbox" name="check1" id="check1" <?php echo isset($_SESSION['check1']) ? $_SESSION['check1'] : ''; ?>><label for="check1">賃貸について</label>
        <input type="checkbox" name="check2" id="check2" <?php echo isset($_SESSION['check2']) ? $_SESSION['check2'] : ''; ?>><label for="check2">売買について</label>
        <input type="checkbox" name="check3" id="check3" <?php echo isset($_SESSION['check3']) ? $_SESSION['check3'] : ''; ?>><label for="check3">採用について</label>
        <input type="checkbox" name="check4" id="check4" <?php echo isset($_SESSION['check4']) ? $_SESSION['check4'] : ''; ?>><label for="check4">その他</label><br>
        <label for="message">詳細   <label class="error" for="message"><?php echo isset($_SESSION['message_error']) ? $_SESSION['message_error'] : ''; ?></label></label><br>
        <textarea name="message" id="message"><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?></textarea><br>
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <input type="submit" value="確認"" action="index.php">
    </form>
</body>
</html>