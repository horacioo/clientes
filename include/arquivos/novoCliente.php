<?php

use FormulariosHTml\htmlRender as save; ?>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js'></script>
<h2>Cadastrar Cliente</h2>
<form action="" method="post" name="cliente">
    <div class='container' ng-app="NovoCliente" >
        <div class='row' ng-controller="dados as dd">
            <div class='col-md-6'>
                <p><label><span class="dashicons dashicons-admin-users"></span>Nome</label><input type="text" required="required" name=cliente[nome] class='form-control'></p>
                <p><label><span class="dashicons dashicons-media-document"></span>cpf</label><input type="text" required="required"  name=cliente[cpf] class='form-control' ></p>
                <p><label><span class="dashicons dashicons-id"></span>rg</label><input type="text" name=cliente[rg] class='form-control' ></p>
                <p><label><span class="dashicons dashicons-calendar-alt"></span>data de nascimento</label><input  ng-model="DataNascimento"  type="date" name=cliente[nascimento] class='form-control' > </p>
            </div>
            <div class='col-md-6'>
                <h2>Contato</h2>
                <p><label><span class="dashicons dashicons-location-alt"></span>endereço</label><input type="text" id="autocomplete" onFocus="geolocate()"  name=cliente[endereco] class='form-control' ></p>
                <!---------------------------------------------------------------------->
                <span ng-click="dd.Email()" class="btn btn-sm btn-success">acescentar email </span>
                <p ng-repeat="item in dd.email"><label><span class="dashicons dashicons-email"></span>email</label><input type="text"  required="required"  name=cliente[email][] class='form-control' ></p>
                <!---------------------------------------------------------------------->
                <p><span ng-click="dd.Telefone()"  class="btn btn-sm btn-success">acrescentar telefone</span></p>
                <p  ng-repeat="item in dd.telefone"><label><span class="dashicons dashicons-phone"></span>telefone</label><input type="text" name=cliente[telefone][] class='form-control' ></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                Grupos<br>
                <ul>
                    <?php
                    $dados = DataBase::ListaGeral(array("tabela" => "grupos"));
                    foreach ($dados as $x):
                        ?> 
                        <li class="gruposCheck"><input type="checkbox" name=cliente[clientegrupos][] value="<?php echo $x['id'] ?>"> <?php echo $x['nome']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    </div>
    <input type="submit" value="Salvar">
</form>

<style>
    .gruposCheck{
        border: 1px solid #dadada;
        width: 24%;
        float: left;
        padding: 1rem;
        margin: 2px;
        border-radius: 3px;
    }
</style>
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

<!--------------------google --------------------------------->
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<script>

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo keyGoogleApi; ?>&libraries=places&callback=initAutocomplete"
async defer></script>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<!------------------------------------------------------------>
<?php
if (isset($_POST['cliente'])):
    
    $_POST['cliente']['dataNascimento']  = $_POST['cliente']['nascimento'];
      
    save::$entrada = 'cliente';
    save::SalvaForm();
    save::clientesGrupos("cliente");//clientesGrupos("cliente");
endif;




/* * ********************** */
?>