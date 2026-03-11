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

    메인 페이지
    
    <div class="slide_modal"></div>
</body>
</html>
