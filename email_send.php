<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// PHPMailerの読み込みパス
require('./helper/PHPMailer/src/PHPMailer.php');
require('./helper/PHPMailer/src/Exception.php');
require('./helper/PHPMailer/src/SMTP.php');

// 文字エンコードを指定
mb_language('uni');
mb_internal_encoding('UTF-8');

// インスタンスを生成（true指定で例外を有効化）
$mail = new PHPMailer(true);

// 文字エンコードを指定
$mail->CharSet = 'utf-8';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $email = $id . '@jec.ac.jp';
        $_SESSION['id'] = $id;
    } else {
        $err = '学籍番号を入力してください';
    }

    if (empty($err)) {
        try {
            // SMTPサーバの設定
            $mail->isSMTP();                          // SMTPの使用宣言
            $mail->Host       = 'smtp.gmail.com';     // SMTPサーバーを指定
            $mail->SMTPAuth   = true;                 // SMTP authenticationを有効化
            $mail->Username   = '24jn0427@jec.ac.jp'; // ★自分の学校メールアドレス
            $mail->Password   = 'dfnb dcil inlc ehir'; // ★アプリ・パスワード
            $mail->SMTPSecure = 'ssl';                // 暗号化を有効（tls or ssl）無効の場合はfalse
            $mail->Port       = 465;                  // TCPポートを指定（tlsの場合は465や587）

            // 送受信先設定（第2引数は省略可）
            $mail->setFrom('24jn0427@jec.ac.jp');                       // ★送信者（省略可）
            $mail->addAddress($id . '@jec.ac.jp');                        // ★宛先1
            // $mail->addAddress('XXXXXX@example.com', '受信者名');      // 宛先2
            // $mail->addReplyTo('replay@example.com', 'お問い合わせ');  // 返信先
            // $mail->addCC('cc@example.com', '受信者名');               // CC宛先
            // $mail->addBCC('bcc@example.com');                        // BCC宛先

            // 送信内容設定（プレーンテキスト用）
            // $mail->Subject = '件名';
            // $mail->Body    = '本文';

            // HTMLメール用
            $mail->isHTML(true);                 // HTMLメール
            $mail->Subject = '認証コード';

            $verify_code = "";
            for ($i = 0; $i <= 5; $i++) {
                $verify_code .= mt_rand(0, 9);
            }

            $mail->Body    = "<p>認証コード：$verify_code</p>";

            // 添付ファイル
            // $mail->addAttachment('子猫.jpg');

            // 送信
            $mail->send();
        } catch (Exception $e) {
            // エラーの場合
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>パスワード再設定</title>
    <link rel="stylesheet" href="./bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sign-in.css">
    <link rel="stylesheet" href="./css/modal.css">
    <script src="./js/email_send.js"></script>
</head>

<body class="d-flex align-items-center py-4">
    <div class="form-signin w-100 m-auto border border-light rounded-3 position-relative">
        <form action="" method="post" id="form">
            <h3 class="fw-bold mb-3 number-center">学籍番号を入力してください</h3>
            <div class="form-floating mb-1">
                <input type="text" name="id" id="idNumber" class="form-control" placeholder="学籍番号" required>
                <label for="idNumber">学籍番号</label>
                <?php if (isset($err)) { ?>
                    <p class="fw-bold number-danger"><?= $err ?></p>
                <?php } ?>
            </div>
            <button type="submit" class="mt-3 btn btn-primary w-100 py-2" id="modalOpen">送信</button>
        </form>
    </div>

    <?php if (isset($id)) { ?>
        <div class="Modal m-auto border border-light rounded-3" id="modal">
            <div class="modal-content" id="content">
                <div class="Modal-header">
                    <h3>認証コードを入力</h3>
                    <p>メールアドレスに送信された6桁のコードを入力してください</p>
                </div>
                <div class="modal-fields">
                    <input type="number" maxlength="1" pattern="[0-9]" id="code1" autofocus>
                    <input type="number" maxlength="1" pattern="[0-9]" id="code2">
                    <input type="number" maxlength="1" pattern="[0-9]" id="code3">
                    <input type="number" maxlength="1" pattern="[0-9]" id="code4">
                    <input type="number" maxlength="1" pattern="[0-9]" id="code5">
                    <input type="number" maxlength="1" pattern="[0-9]" id="code6">
                </div>
                <button id="verify-button" disabled>認証</button>
            </div>
        </div>
    <?php } ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.modal-fields input');
            const verifyButton = document.getElementById('verify-button');

            // 各入力欄に設定
            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    // 現在の入力欄が埋まったら、次の入力欄にフォーカスを移動
                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    checkInputs();
                });

                // Backspaceキーが押されたときの処理
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // 方向キーが押されたときの処理
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft' && index > 0) {
                        inputs[index - 1].focus();
                    } else if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                })
            });

            // 入力状況をチェックし、ボタンの有効/無効を切り替える
            function checkInputs() {
                const allFilled = Array.from(inputs).every(input => input.value.length === 1);
                verifyButton.disabled = !allFilled;
            }

            // 認証ボタンのクリックイベント
            verifyButton.addEventListener('click', () => {
                const code = Array.from(inputs).map(input => input.value).join('');

                // 認証処理
                const verifycode = '<?= $verify_code ?>';
                if (code === verifycode) {
                    window.location.href = './password_reset.php';
                } else {
                    let content = document.getElementById('content');
                    let errmsg = document.createElement('p');
                    errmsg.classList.add("fw-bold", "number-danger", "mt-2");

                    errmsg.numberContent = '認証コードに誤りがあります';

                    content.appendChild(errmsg);
                }
            });
        });
    </script>
</body>

</html>