<?php

require("../app/functions.php");

createToken();

define("FILENAME", "../app/messages.dat");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    validateToken();

    $name = trim($_POST["name"]);
    $name = $name !== "" ? $name : "匿名";
    $name = str_replace("\t", " ", $name);
    $postedAt = date("Y-m-d H:i:s");
    $message = trim($_POST["message"]);
    $message = str_replace("\t", " ", $message);
    // $message = $message !== "" ? $message : "...";

    if($message !== "") {
        
        $newData = $name . "\t" . $message . "\t" . $postedAt . "\n";
        
        $fp = fopen(FILENAME, "a");
        fwrite($fp, $newData);
        fclose($fp);
        
        header("Location: http://localhost:8080/result.php");
        exit;
    }
}

$messages = file(FILENAME, FILE_IGNORE_NEW_LINES);
$messages = array_reverse($messages);

include("../app/_parts/_header.php");

?>

    <div class="header-box">
        <div class="container header-container">
            <header>
                <a class="logo" href="https://w-fu.com/"><img src="img/fu-logo.png" alt="fu-logo" height="40px"></a>
                <nav class="header-nav">
                    <ul>
                        <li><a href="https://w-fu.com/">HOME</a></li>
                        <li><a href="https://w-fu.com/about-us/">ABOUT US</a></li>
                        <li><a href="https://w-fu.com/category/news/">NEWS</a></li>
                        <li><a href="https://w-fu.com/schedule/">SCHEDULE</a></li>
                        <li><a href="https://w-fu.com/contact/">CONTACT</a></li>
                        <li><a href="https://sc.w-fu.com/?_ga=2.185952042.206240383.1661442475-1408825727.1644558655">SCHOOL</a></li>
                        <li><a><div class="svg-icon header-icon"><img src="img/glass-icon.svg"></div></a></li>
                        <li>
                            <!-- <a><div class="kari-icon"><p>t</p></div></a> -->
                            <a class="sns-link" href="https://twitter.com/funabashiunited"><div class="svg-icon header-icon"><img src="img/twitter-icon.svg"></div></a>
                            <a class="sns-link" href="https://www.facebook.com/FunabashiUnited"><div class="svg-icon header-icon"><img src="img/facebook-icon.svg"></div></a>
                            <a class="sns-link" href="https://www.instagram.com/funabashi.united/"><div class="svg-icon header-icon"><img src="img/instagram-icon.svg"></div></a>
                            <a class="sns-link" href="https://www.youtube.com/channel/UCF1t_w0R_Zd39yaP4VerBZA"><div class="svg-icon header-icon"><img src="img/youtube-icon.svg"></div></a>
                            <a class="sns-link" href="https://www.tiktok.com/@sc_w_fu"><div class="svg-icon header-icon"><img src="img/tictok-icon.svg"></div></a>
                        </li>
                    </ul>
                </nav>
            </header>
    
            <div class="navigate">
                <h1 class="page-title">Bulletin board</h1>
                <div class="route">ここまでのルートを表示</div>
            </div>
        </div>
    </div>

    <div class="main-box">
        <main>
<!-------------------- 掲示板ここから -------------------->
            <div class="container">
                <div class="board-box">
                    <h2>投稿一覧（<?= count($messages); ?>件）</h2>
                    <div class="board">
                        <ul>
                        <?php if(count($messages)) : ?>
                            <?php foreach($messages as $message) : ?>
                                <?php list($name, $message, $postedAt) = explode("\t", $message) ?>
                                <li><?= h($name); ?> : <?= h($message); ?> - <?= h($postedAt); ?></li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li>投稿はまだありません</li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="container">
                    <form action="" method="post">
                        <div class="name">
                            <label for="name">お名前（任意）</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <label for="message">メッセージ</label>
                        <input type="text" name="message" id="message">
                        <!-- <textarea name="message"></textarea> -->
                        <!-- <button class="button">Post</button> -->
                        <input type="submit" value="Post">
                        <input type="hidden" name="token" value="<?= h($_SESSION["token"]); ?>">
                    </form>
                </div>
            </div>
<!-------------------- 掲示板ここまで -------------------->
        </main>
    </div>

    <div class="footer-box">
        <footer>
            <div class="container footer-container">
                <div class="box">
                    <h1 class="footer-menu">Follow Us!</h1>
                    <a class="sns-link" href="https://twitter.com/funabashiunited"><div class="svg-icon footer-icon"><img src="img/twitter-icon.svg"></div></a>
                    <a class="sns-link" href="https://www.facebook.com/FunabashiUnited"><div class="svg-icon footer-icon"><img src="img/facebook-icon.svg"></div></a>
                    <a class="sns-link" href="https://www.instagram.com/funabashi.united/"><div class="svg-icon footer-icon"><img src="img/instagram-icon.svg"></div></a>
                    <a class="sns-link" href="https://www.youtube.com/channel/UCF1t_w0R_Zd39yaP4VerBZA"><div class="svg-icon footer-icon"><img src="img/youtube-icon.svg"></div></a>
                    <a class="sns-link" href="https://www.tiktok.com/@sc_w_fu"><div class="svg-icon footer-icon"><img src="img/tictok-icon.svg"></div></a>
                    <div class="FU-acs">
                        <p><a href="https://sc.w-fu.com/?_ga=2.233603869.206240383.1661442475-1408825727.1644558655">Funabashi United スポーツスクール</a></p>
                    </div>
                </div>
                <div class="box">
                    <h1 class="footer-menu">Latest Post</h1>
                    <ul class="post">
                        <li><a href="https://w-fu.com/2022/07/01/newlogo/">クラブのロゴ刷新について</a></li>
                        <li><a href="https://w-fu.com/2022/06/13/2021%e3%82%b7%e3%83%bc%e3%82%ba%e3%83%b3%e9%80%80%e5%9b%a3%e9%81%b8%e6%89%8b%e3%81%ab%e3%81%a4%e3%81%84%e3%81%a6/">2021シーズン退団選手について</a></li>
                        <li><a href="https://w-fu.com/2022/05/18/fgm/">林堂宏樹氏のFootball Group Manager就任のお知らせ</a></li>
                        <li><a href="https://w-fu.com/2022/04/30/player-hiring2022-2023/">2023年に向けた新規選手募集のお知らせ</a></li>
                        <li><a href="https://w-fu.com/2022/04/20/coaching-staff/">Coaching Staff × 2</a></li>
                    </ul>
                </div>
            </div>
        </footer>
        <small>Copyright &copy; 2022 Funabashi United All Rights Reserved.</small>
    </div>

<?php

include("../app/_parts/_footer.php");