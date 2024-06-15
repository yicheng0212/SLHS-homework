<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1121405林翼成-首頁</title>
    <?php include "link.php"; ?>
    <style>
        .header-container {
            position: relative;
            text-align: center;
            color: white;
        }

        .header-container img {
            width: 100%;
            height: auto;
            opacity: 0.8;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(51, 51, 51, .2);
        }

        .centered-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        .search-box {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-box input {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .search-box button {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .navbar-nav .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="./index.php" class="navbar-brand">
            <img src="./images/lyc_logo.png" alt="LOGO" height="100">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        目的地
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">北部</a>
                        <a class="dropdown-item" href="#">中部</a>
                        <a class="dropdown-item" href="#">南部</a>
                        <a class="dropdown-item" href="#">東部</a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">交通住宿</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">景點</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">門票</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">伴手禮</a>
                </li>
            </ul>
        </div>
    </nav>

    <header>
        <div class="header-container">
            <img src="./images/header.jpg" alt="header" class="img-fluid">
            <div class="header-overlay"></div>
            <div class="centered-content">
                <h1>全世界最棒的旅遊體驗</h1>
                <p>帶你深入探索有趣又獨特的旅遊體驗行程</p>
                <div class="search-box mt-3">
                    <input type="text" class="form-control" placeholder="搜尋景點、地區或城市" v-model="query">
                    <button class="btn btn-primary"><span class="bi bi-search"></span></button>
                </div>
            </div>
        </div>
    </header>

    <div class="container">

    </div>
    <?php include "footer.php"; ?>
    <script>
        $(document).ready(function() {
            $('.navbar-nav .dropdown').hover(function() {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200);
            }, function() {
                $(this).find('.dropdown-menu').stop(true, true).delay(2000).fadeOut(200);
            });
        });
    </script>
</body>

</html>