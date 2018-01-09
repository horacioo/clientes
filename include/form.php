<?php

namespace FormulariosHTml;

class htmlRender extends \DataBase
    {

    public static $js_Plugin = WP_PLUGIN_URL . "/clientes/js/";
    public static $dadosCliente;
    public static $entrada;

    public static function Angular() {
        wp_register_script("angularJs", self::$js_Plugin . "angular.min.js");
        wp_register_script("app", self::$js_Plugin . "app.js");
        wp_register_script("controllerxxx", self::$js_Plugin . "controller.js");
        wp_enqueue_script("angularJs");
        wp_enqueue_script("app");
        wp_enqueue_script("controllerxxx");
    }





    static function Editar() {
        self::Angular();
        if (isset($_POST['dados']))
            {
            $x = self::FormularioCadEdit($_POST['dados']);
            return $x;
        } else
            {
            return self::Listagem();
        }
    }





    static private function FormularioCadEdit($dados = '') {
        $dc = "<div ng-app='app'>";
        $dc .= "<form name='cliente' action='' method='post'>";

        if (isset($dados['cliente'])){
            $dc .= "<input type='hidden' name='funcao' value='update'>";
            $dc .= "<div ng-controller=\"DadosControlador as dc\" ng-init='dc.dataInfo()' >{{dc.dataInfo.dataInfo}}";
            $dc .= "<div ng-model='id' ng-init='dc.dataInfo(" . $dados['cliente'] . ")'> </div>";
            $dc .= "<div ng-model='reload' ng-click='dc.dataInfo(" . $dados['cliente'] . ")'>{{reload}}</div>";
        } else{
            $dc .= "<input type='hidden' name='funcao' value='criar'>";
             }
        $dc .= "<div class='form-group'>{{update}}";
        $dc .= "<label for='nome'>nome</label><input type='text'  required='required' id='nome' ng-model='nome' name=cliente[nome] placeholder='digite seu nome' class='form-control' >";
        $dc .= "</div>";


        $dc .= "<div class='form-group'>";
        $dc .= "<label for='cpf'>cpf</label><input id='cpf' ng-model='cpf' type='text' name=cliente[cpf] placeholder='digite seu cpf' class='form-control' >";
        $dc .= "</div>";

        $dc .= "<div class='form-group'>";
        $dc .= "<label for='rg'>rg</label><input id='rg' ng-model='rg' type='text' name=cliente[rg] placeholder='digite seu rg' class='form-control' >";
        $dc .= "</div>";

        $dc .= "<div class='form-group'>";
        $dc .= "<label for='dtexp'>data de expedição</label><input ng-model='dataExp'  id='dtexp' type='text' name=cliente[dataExpedicao] placeholder='digite a data de expedição' class='form-control' >";
        $dc .= "</div>";

        $dc .= "<div class='form-group'>";
        $dc .= "<label for='nasc'>data de nascimento</label><input ng-model='dataNascimento' id='nasc' type='text'  required='required' name=cliente[dataNascimento] placeholder='digite sua data de nascimento' class='form-control' >";
        $dc .= "</div>";




        $dc .= "<div class='form-group' ng-repeat='item in email'>";
        $dc .= "<label  for='email'>email</label><input id='email' value='{{item.email}}' type='email' required='required' name=cliente[email][] placeholder='digite seu email' class='form-control' >";
        $dc .= "</div>";



        $dc .= "<div class='form-group'  ng-repeat='item in telefone'>";
        $dc .= "<label for='telefone'>telefone</label><input id='telefone' value='{{item.telefone}}'  type='text'  required='required'  name=cliente[telefone][] placeholder='digite seu telefone' class='form-control' >";
        $dc .= "</div>";


        $dc .= "<div class='form-group'>";
        $dc .= "<input  class='btn btn-primary' type='submit' value='salvar'>";
        $dc .= "</div>";

        $dc .= "<br><br></form>";
        if (isset($dados['cliente'])){
            $dc .= "</div>";
        }
        $dc .= "</div>";
        return $dc;
    }





    static private function Listagem() {
        $tb = "";
        $tb .= "<div ng-app='app'>";
        $tb .= " <div ng-controller=\"DadosControlador as dc\" ng-init='dc.info()' >";
        $tb .= "<form method='post' action=''>";
        $tb .= "<input type='text' ng-change='dc.info()' ng-model='nome' value='teste' class='form-control'>";
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
        $tb .= "<td><form action='' name='dados' method='POST'>"
                . "<input type='hidden' name=dados[cliente] value='{{item.id}}'>"
                . "<input type='submit' value='acessar dados do cliente {{item.nome}}' >"
                . "</form></td>";
        $tb .= "</tr>";
        $tb .= "</table>";
        $tb .= "</div>";
        $tb .= "</div>";
        return $tb;
    }





    static function dadosClienteInterno() {
        self::Angular();
        if (isset($_POST['cliente'])){
            /*             * ************************* */
            self::SalvaClientes();
            self::SalvaEmail("cliente");
            self::SalvaTelefone();
            self::clientesemail();
            self::clientestelefone();
            /*             * ************************* */
        } else{
            return self::FormularioCadEdit();
        }
    }





    /*     * *
      informar a entrada de dados do formulario na variável $entrada da classe
     *  */

    public static function SalvaClientes() {
        self::$campos = ['nome', 'cpf', 'rg', 'dataExpedicao', 'dataNascimento', 'ip'];
        self::$tabela = 'clientes';
        $dados        = $_POST[self::$entrada];
        $dados['ip']  = md5($_SERVER["REMOTE_ADDR"]);
        self::Salva($dados);
        print_r($_POST[$entrada]);
    }





    /*     * *
      informar a entrada de dados do formulario na variável $entrada da classe
     *  */

    public static function SalvaEmail() {
        self::$campos = ['email'];
        self::$tabela = 'email';

        if (!is_array($_POST[self::$entrada]['email'])){
            self::Salva($_POST[$entrada]);
        } else
            {
            foreach ($_POST[self::$entrada]['email'] as $x):
                $z['email'] = $x;
                self::Salva($z);
            endforeach;
            }
    }





    /*     * *
      informar a entrada de dados do formulario na variável $entrada da classe
     *  */

    public static function SalvaTelefone($entrada = '') {
        self::$campos = ['telefone'];
        self::$tabela = 'telefone';
        if (!is_array($_POST[self::$entrada]['telefone'])){
            self::Salva($_POST['cliente']);
        } else
            {
            foreach ($_POST[self::$entrada]['telefone'] as $x):
                $z['telefone'] = $x;
                self::Salva($z);
            endforeach;
            }
    }





    /*     * *
      informar a entrada de dados do formulario na variável $entrada da classe
     *  */

    public static function clientesemail($entrada = '') {
        self::$campos = ['clientes', 'email'];
        self::$tabela = 'clientesemail';
        $cliente      = self::$array['clientes'][0];
        foreach (self::$array['email'] as $email):
            $z['email']    = $email;
            $z['clientes'] = $cliente;
            self::Salva($z);
        endforeach;
        //echo "associação " . self::$consulta;
    }





    /*     * *
      informar a entrada de dados do formulario na variável $entrada da classe
     *  */

    public static function clientestelefone() {
        self::$campos = ['clientes', 'telefone'];
        self::$tabela = 'clientestelefone';
        $cliente      = self::$array['clientes'][0];
        //print_r(self::$array);
        foreach (self::$array['telefone'] as $tel):
            $z['telefone'] = $tel;
            $z['clientes'] = $cliente;
            self::Salva($z);

        endforeach;
    }





    }
