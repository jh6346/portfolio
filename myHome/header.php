<?php
    // 로그인 정보 저장
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
    $user_idx = isset($_SESSION['user_idx']) ? $_SESSION['user_idx'] : null;
    $is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 0;
?>
<script>
    var user_id = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>";
    var user_idx = "<?php echo isset($_SESSION['user_idx']) ? $_SESSION['user_idx'] : null; ?>";
    var is_admin = <?php echo isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 0; ?>;
    $(function() {
        if (user_id) {
            $('#login').hide();
            $('#join').hide();

            //전문가
            //alert('<?php echo isset($_SESSION['is_admin'])? $_SESSION['is_admin'] : ''; ?>');
        } else {
            $('#logout').hide();
        }
    });
</script>
<div class="header">
    <!-- 심벌로고 -->
    <a href="index.php" class="logo">
        <i class="fa fa-home"></i>
        <span>내집꾸미기</span>
    </a>

    <!-- 메뉴 내비게이션 -->
    <div class="nav">
        <ul>
            <a href="index.php"><li>홈</li></a>
            <a href="housewarming_party.php"><li>온라인 집들이</li></a>
            <a href="store.php"><li>스토어</li></a>
            <a href="specialist.php"><li>전문가</li></a>
            <a href="estimate.php"><li>시공 견적</li></a>
        </ul>
    </div>

    <!-- 로그인, 회원가입 -->
    <div class="login">
        <button id="login">로그인</button>
        <button id="logout">로그아웃</button>
        <button id="join">회원가입</button>
    </div>
</div>

<div class="header_mobile">
    <a href="#" class="logo">
        <i class="fa fa-home"></i>
        <span>내집꾸미기</span>
    </a>

    <div class="menu">
        <i class="fa fa-bars"></i>
    </div>
</div>