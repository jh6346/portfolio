<?php include 'lib.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        $(document).ready(function() {
            $currentSlideidx = 0;

            $('.img').on('click', function() {
                $currentSlideidx = $(this).index();
                $('.slideimg_wrapper').css('transform', 'translateX(-' + ($currentSlideidx * 20) + '%)');
            });

            $('.prev').on('click', function() {
                if ($currentSlideidx == 0) { $currentSlideidx = 4; } else { $currentSlideidx--; }

                $('.slideimg_wrapper').css('transform', 'translateX(-' + ($currentSlideidx * 20) + '%)');
            });
            $('.next').on('click', function() {
                if ($currentSlideidx == 4) { $currentSlideidx = 0; } else { $currentSlideidx++; }

                $('.slideimg_wrapper').css('transform', 'translateX(-' + ($currentSlideidx * 20) + '%)');
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="gallery">
        <div class="imgs">
            <div class="img">
                <img src="img/gallery/1.jpg" alt="">
                <div class="overlay"><div class="text">S</div></div>
            </div>
            <div class="img">
                <img src="img/gallery/2.jpg" alt="">
                <div class="overlay"><div class="text">J</div></div>
            </div>
            <div class="img">
                <img src="img/gallery/3.jpg" alt="">
                <div class="overlay"><div class="text">C</div></div>
            </div>
            <div class="img">
                <img src="img/gallery/4.jpg" alt="">
                <div class="overlay"><div class="text">O</div></div>
            </div>
            <div class="img">
                <img src="img/gallery/5.jpg" alt="">
                <div class="overlay"><div class="text">M</div></div>
            </div>
        </div>

        <div class="slides">
            <div class="slidebtn">
                <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
            </div>

            <div class="slideimg">
                <div class="slideimg_wrapper">
                    <img src="img/gallery/1.jpg" alt="">
                    <img src="img/gallery/2.jpg" alt="">
                    <img src="img/gallery/3.jpg" alt="">
                    <img src="img/gallery/4.jpg" alt="">
                    <img src="img/gallery/5.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    
    <div class="slide_modal"></div>
</body>
</html>