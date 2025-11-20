<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];

require_once 'DAO/storeDAO.php';
$storeDAO = new StoreDAO();
//var_dump(a[] = $storeDAO->get_recommend($goukan))
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ルーレット</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/roulette.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="./js/roulette.js"></script> -->
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?> 
        <div class="container-fulid mt-3">

            <form>
                <div class="d-flex justify-content-around align-items-center botton">

                    <div class="favorite mb-2">
                        <button onclick="drawRoulette()" name="favorite" >お気に入り</button>
                    </div>
                    <div class="recommend mb-2">
                        <button onclick="drawRoulette()" name="recommend">おすすめ</button>
                    </div>
                    <div class="result mb-2">
                        <button onclick="drawRoulette()" name="result" >検索結果</button>
                    </div>

                </div>
            </form>
            <div id="roulette" class="position-relative">
                <div id="pointer" class="position-absolute top-0 start-50 translate-middle"></div>
                <canvas id="canvas" class="d-flex justify-content-center align-items-center position-relative"></canvas>
                <button onclick="spinRoulette()" id="spin" class="position-absolute top-50 start-50 translate-middle">START</button>
            </div>
            <div class="text-center">
                <p id="result" class="fw-bold fs-3"></p>
            </div>
            
        </div>


    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');


        const pointer = document.getElementById('pointer');

        const sectors = [];
        if(isset($_POST["favorite"])){

        }
        if(isset($_POST["recommend"])){
            for($)
        }
        if(isset($_POST["result"])){
            
        }
       
        
        const color = ["#F00", "#00F", "#FF0", "#00CC00", "#9933FF"];
        //ランダムに色を配列に追加
        function random(){
        let element = document.getElementById('id1');
        let x;
        let c;
        const y = Math.floor(Math.random() * 0xFFFFFF).toString(16);
        
        if(y.length <= 6){
            x = y.toString().padStart(6,'0');
        }
             
            
            c = element.style.color = '#'+ x;

            c = color.push;
        }
        let angle = 0;
        let canvasSize = Math.min(window.innerWidth, window.innerHeight) * 0.8; // キャンバスのサイズを端末に合わせる
        canvas.width = canvasSize;
        canvas.height = canvasSize;
        const sectorAngle = 2 * Math.PI / sectors.length;

        // キャンバスサイズに合わせてポインタの位置を調整
        // pointer.style.top = `${-canvasSize * 0.030}px`; // キャンバスの上に表示
        // pointer.style.left = `calc(50% - ${canvasSize * 0.05}px)`; // 中央に配置

        // ルーレットを描画
        function drawRoulette() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // 前の描画をクリア
            ctx.save(); // 現在の状態を保存
            ctx.translate(canvasSize / 2, canvasSize / 2); // キャンバスの中心に移動
            ctx.rotate(angle); // キャンバス全体を回転

            sectors.forEach((sector, index) => {
                ctx.beginPath();
                ctx.moveTo(0, 0);
                ctx.arc(0, 0, canvasSize / 2, index * sectorAngle, (index + 1) * sectorAngle);
                ctx.fillStyle = color[index];
                ctx.fill();


                //テキストを描く
                ctx.save();
                ctx.rotate((index + 0.5) * sectorAngle);
                ctx.textAlign = "right";
                ctx.font = `${canvasSize * 0.05}px Arial`; // サイズに応じてフォントサイズ変更
                ctx.fillStyle = "#000";
                ctx.fillText(sector, canvasSize * 0.45, 0); // テキストをキャンバスサイズに合わせて配置
                ctx.restore();
            });
            ctx.restore();
        }

        // スピンのアニメーション
        function spinRoulette() {
            const spinButton = document.getElementById('spin');
            spinButton.disabled = true;
            const targetAngle = Math.random() * 2 * Math.PI + 10 * Math.PI; // ランダムな回転
            const spinDuration = 5000; //5秒回転
            const startTime = performance.now();

            function animate(time) {
                const elapsed = time - startTime;
                if (elapsed < spinDuration) {
                    angle = (targetAngle * (elapsed / spinDuration)) % (2 * Math.PI);
                    drawRoulette();
                    requestAnimationFrame(animate);
                } else {
                    angle = targetAngle % (2 * Math.PI);

                    // ルーレットの停止位置に基づいて結果を計算
                    const correctedAngle = (angle + Math.PI / 2) % (2 * Math.PI); // 矢印は上にあるため、90度補正
                    const sectorIndex = Math.floor(correctedAngle / sectorAngle) % sectors.length;
                    document.getElementById('result').textContent = `結果： ${sectors[sectors.length - 1 - sectorIndex]}`;
                    spinButton.disabled = false;

                }
            }
            requestAnimationFrame(animate);
        }
        // 画面サイズ変更時にキャンバスのサイズを再調整
        window.addEventListener('resize', () => {
            canvasSize = Math.min(window.innerWidth, window.innerHeight) * 0.8;
            canvas.width = canvasSize;
            canvas.height = canvasSize;
            //pointer.style.top = `${-canvasSize * 0.1}px`; // キャンバスの上に表示
            //pointer.style.left = `calc(50% - ${canvasSize * 0.05}px)`; // 中央に配置
            drawRoulette(); // 再描画
        });

        document.getElementById('spin').addEventListener('click', spinRoulette);

        drawRoulette();
    </script>
</body>

</html>