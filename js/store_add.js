document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.tel input');
    const tel_length = document.getElementById('tel').maxLength;

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 2 && index < inputs.length - 1 && index === 0) {
                inputs[index + 1].focus();
            } else if (e.target.value.length === 4 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
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
});