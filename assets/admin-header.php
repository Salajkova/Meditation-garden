<?php
$roleForHeader = isset($_SESSION["role"]) ? $_SESSION["role"] : "guest";
?>


<header>
    <div class="logo">
        <a href="../index.php">
        <img src="../assets/uvodnik.jpg" alt="mnih hora" id="monk"></a>
        </a>
    </div>
    <nav class="navigation">
        <ul>
            
            <li id="circle_uvod"><a href="../offers.php">Semináře</a></li>
            <li id="circle_uvod"><a href="seminars.php">Pořádáme</a></li>
            <li id="circle_uvod"><a href="videos.php">Galerie</a></li>
            <li id="circle_uvod"><a href="../contact.php">O&nbsp;nás</a></li>
            
            <?php if($roleForHeader === "guest"): ?>
                <li><a href="../signin.php">Přihlásit&nbsp;se</a></li>
            <?php else: ?>
                
                <li><a href="logout.php">Odhlásit&nbsp;se</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
    </div>
</header>
