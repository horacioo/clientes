<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js'></script>
<h2>Cadastrar Cliente</h2>
<form action="" method="post" name="cliente">
    <div class='container' ng-app="NovoCliente" >
        <div class='row' ng-controller="dados as dd">
            <div class='col-md-6'>

                <p><label><span class="dashicons dashicons-admin-users"></span>Nome</label><input type="text" required="required" name=cliente[nome] class='form-control'></p>
                <p><label><span class="dashicons dashicons-media-document"></span>cpf</label><input type="text" required="required"  name=cliente[cpf] class='form-control' ></p>
                <p><label><span class="dashicons dashicons-id"></span>rg</label><input type="text" name=cliente[rg] class='form-control' ></p>
                <p><label><span class="dashicons dashicons-calendar-alt"></span>data de nascimento</label><input type="date" name=cliente[nascimento] class='form-control' ></p>
            </div>
            <div class='col-md-6'>
                <h2>Contato</h2>
                <p><label><span class="dashicons dashicons-location-alt"></span>endereço</label><input type="text"  name=cliente[endereço] class='form-control' ></p>
                <!---------------------------------------------------------------------->
                <span ng-click="dd.Email()" class="btn btn-sm btn-success">acescentar email </span>
                <p ng-repeat="item in dd.email"><label><span class="dashicons dashicons-email"></span>email</label><input type="text"  required="required"  name=cliente[email][] class='form-control' ></p>
                <!---------------------------------------------------------------------->
                <p><span ng-click="dd.Telefone()"  class="btn btn-sm btn-success">acrescentar telefone</span></p>
                <p  ng-repeat="item in dd.telefone"><label><span class="dashicons dashicons-phone"></span>telefone</label><input type="text" name=cliente[telefone][] class='form-control' ></p>
            </div>
        </div>
    </div>
    <input type="submit" value="Salvar">
</form>
<script>
    angular.module('NovoCliente', []);
    angular.module('NovoCliente').controller('dados', fctnDAdos);

    dados.$inject['$scope']

    function fctnDAdos($scope) {
        var vm = this;
        vm.info = " 2345sdlfsdlf ";

        vm.email = ['1'];
        vm.telefone = ['1'];
        var tell = 1;
        var mail = 1;

        vm.Email = function (i) {
            vm.email.push(mail);
            mail++;
        }

        vm.Telefone = function (i) {
            vm.telefone.push(tell);
            tell++;
            console.log(" novo campo de telefone ");
        }
    }
</script>


<?php 
if(isset($_POST['cliente'])):
    $dados=array();
    print_r($_POST['cliente']);
endif;
?>