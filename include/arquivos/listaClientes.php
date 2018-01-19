<?php
BootStrap();
echo apiLista;
?>

<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js'></script>
<h2>Lista de clientes</h2>
<div ng-app="App" ng-controller="dadosController as d" >
    <div ng-init="d.start(a)" >
        <br><input type="text"  ng-keyup="d.info()"  ng-model="pesquisa" ><br>
        <ul class="list-group">
            <li ng-repeat="item in d.dadosx"> {{item.nome}}  <>{{item.id}}<a> </li>
        </ul>
    </div>
</div>

<script>
    angular.module("App", []);
    angular.module("App", []).controller("dadosController", functionDados);
    dadosController.$inject = ['$scope', '$http'];
    function functionDados($scope, $http) {
        var vm;
        vm = this;
        vm.start = function () {
            vm.httpDados = "<?php echo apiLista; ?>?param=*";
            $http.get(vm.httpDados)
                    .then(function (response) {
                        vm.dadosx = response.data;
                        console.log(vm.dadosx);
                        console.log(vm.httpDados);
                    })
        }
        /**************************************************/
        vm.info = function () {
            if ($scope.nome = "") {
            } else {
            }
            vm.httpDados = "<?php echo apiLista; ?>?param=" + $scope.pesquisa;// "http://regisepennaseguros.com.br/wp-content/plugins/clientes/api/api_lista.php?param=" + $scope.pesquisa;
            $http.get(vm.httpDados)
                    .then(function (response) {
                        //console.log(response.data);
                        vm.dadosx = response.data;
                        ///console.log(vm.httpDados);
                    })
        }
    }
</script>