<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>YouTube Player</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../src/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="../src/js/main.js" type="text/javascript"></script>
</head>
<body>
<nav class="navbar navbar-expand-md sticky-top">
    <div class="container-fluid">
        <a href="/" class="navbar-brand"><i class="fab fa-youtube"></i> YouTube Player</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <?php if(stripos($_SERVER['REQUEST_URI'],'auth') !== false): ?>
                    <?php if (isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == 'true'): ?>
                        <li class="nav-item">
                            <a href="/liked" class="nav-link">Понравившиеся видео</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="/auth" class="nav-link active">Вход</a>
                    </li>
                <?php endif; ?>

                <?php if(stripos($_SERVER['REQUEST_URI'],'auth') === false && stripos($_SERVER['REQUEST_URI'],'liked') === false ): ?>
                    <?php if(isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == 'true'): ?>
                        <li class="nav-item">
                            <a href="/liked" class="nav-link">Понравившиеся видео</a>
                        </li>
                    <?php endif; ?>
                    <?php if(!isset($_SESSION['isAuth'])): ?>
                        <li class="nav-item">
                            <a href="/auth" class="nav-link">Вход</a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == 'true'): ?>
                        <li class="nav-item">
                            <a href="/auth/logout" class="nav-link">Выход</a>
                        </li>
                    <? endif; ?>
                <? endif; ?>

                <?php if(stripos($_SERVER['REQUEST_URI'],'liked') !== false): ?>
                    <li class="nav-item">
                        <a href="/liked" class="nav-link active">Понравившиеся видео</a>
                    </li>
                    <?php if (isset($_SESSION['isAuth'])): ?>
                        <li class="nav-item">
                            <a href="/auth/logout" class="nav-link">Выход</a>
                        </li>
                    <? endif; ?>
                <? endif;?>
            </ul>
        </div>
    </div>
</nav>
    <?php include 'src/application/views/'.$content_view; ?>
</body>
</html>