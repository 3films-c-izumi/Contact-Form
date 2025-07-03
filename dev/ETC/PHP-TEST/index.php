<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">

<?php
    $name = '';
    $email = '';
    $message = '';
    $type1 = '';
    $type2 = '';
    $type3 = '';
    $type4 = '';
    $email_pattern = '~^[a-zA-Z0-9._?+-/]{0,63}@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$~';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $type1 = isset($_POST['type1']) ? 'checked' : '';
    $type2 = isset($_POST['type2']) ? 'checked' : '';
    $type3 = isset($_POST['type3']) ? 'checked' : '';
    $type4 = isset($_POST['type4']) ? 'checked' : '';
    $to = 'c-izumi@3films.com';
    $subject = 'お問合せがありました';
    $headers = 'From: '.$email;
}

$ar_def_mode = [
    'first',
    'confirm',
    'finish',
];

$mode = 'first';
if (isset($_POST['mode']) && in_array($_POST['mode'], $ar_def_mode)) {
    $mode = $_POST['mode'];

    $name = isset($_POST['name']) ? trim($_POST['name']) : false;
    if (! $name) {
        $name_error = 'お名前は必須です。';
        $mode = 'first'; }
    $email = isset($_POST['email']) ? trim($_POST['email']) : false;
    if (! $email) {
        $email_error = 'メールアドレスは必須です。';
        $mode = 'first'; } elseif (! preg_match($email_pattern,$email)) {
            $email_error = 'メールアドレスは正しい書式で入力してください。';
            $mode = 'first'; }
    $message = isset($_POST['message']) ? trim($_POST['message']) : false;
    if (! $message && ($type4 == 'checked')) {
        $message_error = 'その他を選択した場合、詳細の入力は必須です。';
        $mode = 'first'; }
}

if ($mode == "first") { ?>
    <title>お問合せフォーム</title>
</head>
<body>
    <form method="post">
        <label for="name">お名前</label>
        <label class="error_message"><?php if (isset($name_error)) {echo $name_error;} ?></label><br>
        <textarea name="name" id="name"><?php echo isset($name) ? htmlspecialchars($name, ENT_QUOTES, "UTF-8") : '' ; ?></textarea><br>
        <label for="email">メールアドレス</label>
        <label class="error_message"><?php if (isset($email_error)) {echo $email_error;} ?></label><br>
        <textarea type="textarea" name="email" id="email"><?php if(isset($email)) {echo $email;} ?></textarea><br>
        <label for="type">お問い合わせ内容</label><br>
        <input type="checkbox" name="type1" id="type1" <?php echo $type1 ?>><label for="type1">賃貸について</label>
        <input type="checkbox" name="type2" id="type2" <?php echo $type2 ?>><label for="type2">物件の売買について</label>
        <input type="checkbox" name="type3" id="type3" <?php echo $type3 ?>><label for="type3">求人について</label>
        <input type="checkbox" name="type4" id="type4" <?php echo $type4 ?>><label for="type4">その他</label><br>
        <label for="message">詳細</label>
        <label class="error_message"><?php if (isset($message_error)) {echo $message_error;} ?></label><br>
        <textarea type="textarea" name="message" id="message" rows="5"><?php if(isset($message)) {echo $message;} ?></textarea><br>
        <input type="hidden" name="mode" value="confirm">
        <input type="submit" value="確認">
    </form>

<?php 
$type1 = 'type1';
} elseif ($mode == 'confirm') { ?>

    <title>お問合せ内容の確認</title>
</head>
<body>
    <form method="post">
        <label for="name">お名前</label><br>
        <textarea name="name" id="name" readonly class="confirm_textarea"><?php echo $name ?></textarea><br>
        <label for="email">メールアドレス</label><br>
        <textarea  type="email" name="email" id="email" readonly class="confirm_textarea"><?php echo $email ?></textarea><br>
        <label for="type">お問い合わせ内容</label><br>
        <input type="checkbox" name="type1" id="type1" disabled <?php echo $type1 ?>><label for="type1">賃貸について</label>
        <input type="checkbox" name="type2" id="type2" disabled <?php echo $type2 ?>><label for="type2">物件の売買について</label>
        <input type="checkbox" name="type3" id="type3" disabled <?php echo $type3 ?>><label for="type3">求人について</label>
        <input type="checkbox" name="type4" id="type4" disabled <?php echo $type4 ?>><label for="type4">その他</label><br>
        <label for="message">詳細</label><br>
        <textarea type="textarea" name="message" id="message" rows="5" readonly class="confirm_textarea"><?php echo $message ?></textarea><br>
        <input type="hidden" name="mode" value="finish"><br>
        <input type="submit" value="送信">
    </form>
    <form method="post">
        <input type="hidden" name="mode" value="first">
        <input type="submit" value="戻る">
        <input type="hidden" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="message" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>">

<?php
$array = [1, 2, 3, 4];
foreach ($array as $value) {
    $typeVar = 'type' . $value;
    if (isset($$typeVar) && $$typeVar === 'checked') {
        echo '<input type="hidden" name="type' . $value . '" value="on">';
    }
}
?>

    </form>

<?php
} elseif ($mode == 'finish' and mb_send_mail($to,
$subject,
$message,
$headers
)) { ?>

        <title>お問合せ完了</title>
    </head>
    <body>
    <h1><?php echo $name ?>様 お問合せいただきありがとうございました</h1>
        <form method="post">
            <input type="hidden" name="mode" value="first">
            <input type="submit" value="戻る">
        </form>
    </body>
    </html>

<?php
} else { ?>

    <title>エラー</title>
</head>
<body>
    <h1>メールの送信ができませんでした。大変申し訳ありませんが、最初からお試しください。</h1>
    <form method="post">
        <label for="name">お名前</label><br>
        <textarea name="name" id="name"><?php echo isset($name) ? htmlspecialchars($name, ENT_QUOTES, "UTF-8") : '' ; ?></textarea><br>
        <label for="email">メールアドレス</label><br>
        <textarea type="textarea" name="email" id="email"><?php if(isset($email)) {echo $email;} ?></textarea><br>
        <label for="message">お問合せ内容</label><br>
        <textarea type="textarea" name="message" id="message" rows="5"><?php if(isset($message)) {echo $message;} ?></textarea><br>
        <input type="hidden" name="mode" value="confirm">
        <input type="submit" value="確認">
    </form>

<?php } ?>

</body>
</html>
