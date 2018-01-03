<?php

namespace FormulariosHTml;

class htmlRender extends \DataBase
    {

    public static $js_Plugin = WP_PLUGIN_URL . "/clientes/js/";
    

    private static function Angular() {
        wp_register_script("angularJs", self::$js_Plugin . "angular.min.js");
        wp_register_script("app", self::$js_Plugin . "app.js");
        wp_register_script("controllerxxx", self::$js_Plugin . "controller.js");
        
        wp_enqueue_script("angularJs");
        wp_enqueue_script("app");
        wp_enqueue_script("controllerxxx");
    }







    static function Editar() {
        self::Angular();
        $tb = "";
        $tb .= "<div ng-app=\"app\">";
                $tb .=" <div ng-controller=\"DadosControlador as dc\" >  {{dc.httpDados}}";
                        $tb .= "<form method='post' action=''>";
                        $tb .= "<input type='text' ng-change='dc.info()' name='nome' ng-model='nome' value='teste' class='form-control'>";
                        $tb .= "<input  class='btn btn-primary' type='submit' value='salvar'>";
                        $tb .= "</form>";
                        $tb .= "<table class='table table-striped'>";
                        $tb .= "<thead>";
                        $tb .= "<td>nome</td>";
                        $tb .= "<td>email</td>";
                        $tb .= "<td>cpf</td>";
                        $tb .= "<td></td>";
                        $tb .= "</thead>";

                        $tb .= "<tr ng-repeat='item in dc.dados'>";
                        $tb .= "<td>{{item.nome}}</td>";
                        $tb .= "<td>{{item.email}}</td>";
                        $tb .= "<td>{{item.cpf}}</td>";
                        $tb .= "<td>Detalhes</td>";
                        $tb .= "</tr>";

                        $tb .= "</table>";
                $tb .= "</div>";
        $tb .= "</div>";

       
        return $tb;
    }





    static function dadosClienteInterno() {
        if (isset($_POST['cliente'])){
            /*             * ************************* */
            self::SalvaClientes();
            self::SalvaEmail();
            self::SalvaTelefone();
            self::clientesemail();
            self::clientestelefone();
            /*             * ************************* */
        } else{
            $dc = "<form name='cliente' method='post'>";

            $dc .= "<div class='form-group'>";
            $dc .= "<label for='nome'>nome</label><input type='text'  required='required' id='nome'  name=cliente[nome] placeholder='digite seu nome' class='form-control' >";
            $dc .= "</div>";

            $dc .= "<div class='form-group'>";
            $dc .= "<label  for='email'>email</label><input id='email' type='email' required='required' name=cliente[email][] placeholder='digite seu email' class='form-control' >";
            $dc .= "</div>";

            $dc .= "<div class='form-group'>";
            $dc .= "<label for='telefone'>telefone</label><input id='telefone' type='text'  required='required'  name=cliente[telefone][] placeholder='digite seu telefone' class='form-control' >";
            $dc .= "</div>";

            $dc .= "<div class='form-group'>";
            $dc .= "<label for='cpf'>cpf</label><input id='cpf' type='text' name=cliente[cpf] placeholder='digite seu cpf' class='form-control' >";
            $dc .= "</div>";

            $dc .= "<div class='form-group'>";
            $dc .= "<label for='rg'>rg</label><input id='rg' type='text' name=cliente[rg] placeholder='digite seu rg' class='form-control' >";
            $dc .= "</div>";

            $dc .= "<div class='form-group'>";
            $dc .= "<label for='dtexp'>data de expedição</label><input id='dtexp' type='date' name=cliente[dataExpedicao] placeholder='digite a data de expedição' class='form-control' >";
            $dc .= "</div>";

            $dc .= "<div class='form-group'>";
            $dc .= "<label for='nasc'>data de nascimento</label><input id='nasc' type='date'  required='required' name=cliente[dataNascimento] placeholder='digite sua data de nascimento' class='form-control' >";
            $dc .= "</div>";

            $dc .= "<div class='form-group'>";
            $dc .= "<input  class='btn btn-primary' type='submit' value='salvar'>";
            $dc .= "</div>";

            $dc .= "<br><br></form>";
            return $dc;
        }
    }





    private static function SalvaClientes() {
        self::$campos = ['nome', 'cpf', 'rg', 'dataExpedicao', 'dataNascimento'];
        self::$tabela = 'clientes';
        self::Salva($_POST['cliente']);
    }





    private static function SalvaEmail() {
        self::$campos = ['email'];
        self::$tabela = 'email';

        if (!is_array($_POST['cliente']['email'])){
            self::Salva($_POST['cliente']);
        } else
            {
            foreach ($_POST['cliente']['email'] as $x):
                $z['email'] = $x;
                self::Salva($z);
            endforeach;
            }
    }





    private static function SalvaTelefone() {
        self::$campos = ['telefone'];
        self::$tabela = 'telefone';
        if (!is_array($_POST['cliente']['telefone'])){
            self::Salva($_POST['cliente']);
        } else
            {
            foreach ($_POST['cliente']['telefone'] as $x):
                $z['telefone'] = $x;
                self::Salva($z);
            endforeach;
            }
    }





    private static function clientesemail() {
        self::$campos = ['clientes', 'email'];
        self::$tabela = 'clientesemail';
        $cliente      = self::$array['clientes'][0];
        foreach (self::$array['email'] as $email):
            $z['email']    = $email;
            $z['clientes'] = $cliente;
            self::Salva($z);
        endforeach;
    }





    private static function clientestelefone() {
        self::$campos = ['clientes', 'telefone'];
        self::$tabela = 'clientestelefone';
        $cliente      = self::$array['clientes'][0];
        foreach (self::$array['telefone'] as $tel):
            $z['telefone'] = $tel;
            $z['clientes'] = $cliente;
            self::Salva($z);
            echo"<hr>";
            echo self::$consulta;
        endforeach;
    }





    }
