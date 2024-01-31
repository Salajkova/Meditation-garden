<form action="" method="POST">

<input type="text" 
class="name" 
name="name" 
placeholder="Název semináře" required
value="<?php echo htmlspecialchars($name) ?>">

<input type="text" 
class="lector" 
name="lector" 
placeholder="Lektor semináře" required
value="<?php echo htmlspecialchars($lector) ?>">

<textarea name="description"  placeholder="Popis semináře"><?php echo htmlspecialchars($description) ?> </textarea> 
 
<input type="number" 
class="price" 
name="price" 
placeholder="Cena semináře" required
value="<?php echo htmlspecialchars($price) ?>">

<input type="date" 
class="date" 
name="date" 
placeholder="Datum semináře" required
value="<?php echo htmlspecialchars($date) ?>">

<!-- <label for="newOrder">Nové pořadí:</label>
    <input type="number" name="newOrder" required> -->

<button type="sumbit" name="sumbit" value="Uložit">Uložit</button>

</form>