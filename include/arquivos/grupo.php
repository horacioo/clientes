<h2>criar novo grupo</h2>
<form action="" method="POST" name="grupos">
    <label>nome do grupo</label> <input type="text" name=grupos[nome]>
    <input type="submit" value="criar">
</form>


<?php
use Planet1\grupos as gr;
gr::Criar();
?>