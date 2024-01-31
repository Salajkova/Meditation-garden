<form action="" method="POST">

<input type="text" 
class="video_name" 
name="video_name" 
placeholder="Název videa" required
value="<?php echo htmlspecialchars($video_name) ?>">

<input type="text" 
class="video_link" 
name="video_link" 
placeholder="Odkaz na video" required
value="<?php echo htmlspecialchars($video_link) ?>">



<button type="sumbit" name="sumbit" value="Uložit">Uložit</button>

</form>