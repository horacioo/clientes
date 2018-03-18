<?php

namespace Planet1;

use Planet1\DataBase as banco;
use Planet1\documento;
use Planet1\EstadoCivil;
use Planet1\token;








add_shortcode("formulario", function() {
    $x = "<form action='' name='dados' method='POST'>";
    $t = token::Token();
    $x.="<input type='hidden' name='token' value='".$t['token']."'>";
    return $x;
});




add_shortcode("fim_do_formulario", function() {
    $x = "</form>";
    return $x;
});





add_shortcode("nome", function() {
    $x = "\n<label>Nome</label><input id='nome' type='text' name=dados[clientes][nome] class='form-control'>";
    return $x;
});



add_shortcode("tipo_de_pessoa", function() {
    $x = "\n<label>Tipo de pessoa</label>";
    $x .= "<select name=dados[clientes][tipo_de_pessoa] class='form-control'>";
    $x .= "<option value='f'>fisica</option>";
    $x .= "<option value='j'>jurídica</option>";
    $x .= "</select>";
    return $x;
});



add_shortcode("sexo", function() {
    $x = "\n<label>Sexo</label>";
    $x .= "<select name=dados[clientes][sexo] class='form-control'>";
    $x .= "<option value='m'>masculino</option>";
    $x .= "<option value='f'>feminino</option>";
    $x .= "</select>";
    return $x;
});



add_shortcode("cpf", function() {
    $x = "\n<label>Cpf</label><input type='text' id='cpf' name=dados[clientes][cpf] class='form-control'>";
    return $x;
});


add_shortcode("rg", function() {
    $x = "\n<label>Rg</label><input type='text' id='rg' name=dados[clientes][rg] class='form-control'>";
    return $x;
});


add_shortcode("data_de_expedicao", function() {
    $x = "\n<label>Data de expedição</label><input type='date' id='data_de_expedicao' name=dados[clientes][dataExpedicao] class='form-control'>";
    return $x;
});


add_shortcode("data_de_nascimento", function() {
    $x = "\n<label>Data de Nascimento</label><input id='nascimento' type='date' name=dados[clientes][dataNascimento] class='form-control'>";
    return $x;
});




add_shortcode("documento", function() {
    $documento = documento::lista_documento();
    if (!empty($documento)) {
        $x = "\n<label>Documento</label>";
        $x .= "<select name=dados[clientes][documento]>";
        foreach ($documento as $doc):
            $x .= "<option value='" . $doc['id'] . "'>" . $doc['documento'] . "<option>";
        endforeach;
        $x .= "</select>";
        return $x;
    }
});



add_shortcode("estado_civil", function() {
    $estadoCivil = EstadoCivil::Lista_Estado_Civil();

    if (!empty(EstadoCivil::$Lista_Estado_Civil)) {
        $x = "\n<label>Estado civil</label>";
        $x .= "<select name=dados[clientes][documento]>";
        foreach (EstadoCivil::$Lista_Estado_Civil as $ec):
            if (!empty($ec['estado_civil'])) {
                $x .= "<option value='" . $ec['id'] . "'>" . $ec['estado_civil'] . "</option>";
            }
        endforeach;
        $x .= "</select>";
        return $x;
    }
});



add_shortcode("email", function() {
    $x = "\n<label>E-mail</label><input required='required' type='email' id='email' name=dados[email][email][] class='form-control'>";
    return $x;
});

add_shortcode("telefone", function() {
    $x = "\n<label>telefone</label><input required='required' type='text' name=dados[telefone][telefone][] id='telefone' class='form-control'>";
    return $x;
});

add_shortcode("botao", function() {
    $x = "\n<input type='submit' value='concluir' class='btn btn-primary form-control'>";
    return $x;
});

