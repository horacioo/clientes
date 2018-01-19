<h2>criar novo grupo</h2>
<form action="" method="POST" name="grupo">
    <label>nome do grupo</label> <input type="text" name=grupo[nome]>
    <input type="submit" value="criar">
</form>


<?php

DataBase::$entrada = "grupo";
DataBase::$campos  =['nome'];
DataBase::$tabela  ="grupos";

DataBase::Salva($_POST['grupo']);

if (isset($_POST['grupo'])):
    print_r($_POST['grupo']);
endif;
?>