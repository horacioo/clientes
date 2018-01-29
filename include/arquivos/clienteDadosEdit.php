<h2>Editando dados</h2>
<?php
use Clientes\clientes as cli;
$dados = cli::EditCliente($_GET['clienteId']);
print_r($dados);
?>