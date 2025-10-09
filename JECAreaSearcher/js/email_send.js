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