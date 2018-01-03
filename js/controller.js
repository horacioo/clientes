

angular.module("app", []).controller("DadosControlador", ['$scope', '$http', fnctControler]);

function fnctControler($scope, $http) {
    var vm = this;
    vm.dados;
    $scope.nome = "*";

    vm.info = function () {

        console.log("nome " + $scope.nome);
        vm.httpDados = "http://localhost/corretorawp/?page_id=22&nome=" + $scope.nome;

        $http.get(vm.httpDados)
                .then(function (response) {
                    console.log(response.data);
                    vm.dados = response.data;
                })

    }



}