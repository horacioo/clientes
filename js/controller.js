angular.module("app", []).controller("DadosControlador", fnctControler);

DadosControlador.$inject = ['$scope', '$http']

function fnctControler($scope, $http) {
    $scope.reload = "recarregar";
    var vm = this;
    vm.dados;
    $scope.nome = "*";
    $scope.id;
    vm.info = function () {

        console.log("nome = " + $scope.nome);
        //vm.httpDados = "http://localhost/corretorawp/wp-content/plugins/clientes/api/api_lista.php?param=" + $scope.nome;
        vm.httpDados = "http://regisepennaseguros.com.br/wp-content/plugins/clientes/api/api_lista.php?param=" + $scope.nome;
        $http.get(vm.httpDados)
                .then(function (response) {
                    console.log(response.data);
                    vm.dados = response.data;
                })

    }

 
    vm.dataInfo = function (info) {
        $scope.reload = "recarregando, aguarde";
        $scope.id = info;
        //vm.httpDados = "http://localhost/corretorawp/wp-content/plugins/clientes/api/api_lista.php?param=" + $scope.id;
        vm.httpDados="http://regisepennaseguros.com.br/wp-content/plugins/clientes/api/api_lista.php?param=" + $scope.id;
        $http.get(vm.httpDados)
                .then(function (response) {
                    vm.dados = response.data;
                    $scope.nome = vm.dados.nome;
                    $scope.rg = vm.dados.rg;
                    $scope.cpf = vm.dados.cpf;
                    $scope.dataNascimento = vm.dados.dataNascimento;
                    $scope.dataExp = vm.dados.dataExpedicao;
                    $scope.telefone = vm.dados.telefone;
                    $scope.email = vm.dados.email;
                    console.log(""+$scope.info+"Dados carregados a distância " + vm.httpDados);
                })
        $scope.reload = "recarregar";
    }

    vm.update = function () {
        /***************************************/
        var dadosUpdate = {
            nome: $scope.nome,
            cpf: $scope.cpf,
            rg: $scope.rg,
            expedicao: $scope.dataExp,
            nascimento: $scope.dataNascimento,
            email: $scope.email,
            telefone: $scope.telefone
        }
        $scope.update = dadosUpdate;
        /***************************************/
    }

}
