

<?php
$roleForHeader = isset($_SESSION["role"]) ? $_SESSION["role"] : "guest";
?>


<header>

    <div class="logo">
        <a href="./index.php">
            <img src="assets/uvodnik.jpg" alt="mnih">
        </a>
    </div>
    
    <nav class="navigation" id="navigation">
        <ul>
            
            <li><a href="offers.php">Semináře</a></li>
            <li><a href="admin/seminars.php">Pořádáme</a></li>
            <li><a href="admin/videos.php">Galerie</a></li>
            <li><a href="contact.php">O&nbsp;nás</a></li>
            <li><a href="signin.php">Přihlásit&nbsp;se</a></li>
            
        </ul>
    </nav>
    <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
    </div>
</header>
