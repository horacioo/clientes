<h2>Editando dados</h2>
<?php

use Planet1\clientes as cli;
use Planet1\DataBase as db;
use Planet1\EstadoCivil as ec;
use Planet1\Emails as em;
use Planet1\endereco as end;
use Planet1\telefone as tel;
use Planet1\grupos as gru;

cli::$IdCliente  = $_GET['clienteId'];
end::$id_cliente = $_GET['clienteId'];
em::$id_cliente  = $_GET['clienteId'];
tel::$id_cliente = $_GET['clienteId'];

if (isset($_POST['cliente'])) {
    cli::Update($_POST['cliente']);
    end::Update($_POST['endereco']);
    em::Update();
    tel::Update();
    end::Create();
}

$d = cli::DadosCliente();
?>


<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.min.js'></script>
<h2>Editar dados do cliente</h2>
<form action="" method="post" name="cliente">
    <div class='container' ng-app="NovoCliente" >
        <div class='row' ng-controller="dados as dd">
            <div class='col-md-6'>
                <p><label><span class="dashicons dashicons-admin-users"></span>Nome</label><input  value="<?php echo cli::$nome; ?>" type="text" required="required" name=cliente[nome] class='form-control'></p>
                <p><label><span class="dashicons dashicons-media-document"></span>cpf</label><input  value="<?php echo cli::$cpf; ?>" type="text" required="required"  name=cliente[cpf] class='form-control' ></p>
                <p><label><span class="dashicons dashicons-id"></span>rg</label><input type="text" name=cliente[rg]  value="<?php echo cli::$rg; ?>" class='form-control' ></p>
                <p><label><span class="dashicons dashicons-calendar-alt"></span>data de nascimento</label><input   value="<?php echo cli::$dataNascimento; ?>"  type="date" name=cliente[dataNascimento] class='form-control' > </p>
                <!---------------------------------------------------------------------->
                <p>Sexo:</p>
                <p><label>masculino</label><input type="radio" name=cliente[sexo] value="m" <?php
                    if (cli::$sexo == "m") {
                        echo "checked=\"checked\"";
                    }
                    ?> ></p>
                <p>
                    <label>feminino</label><input type="radio" name=cliente[sexo] value="f" <?php
                    if (cli::$sexo == "f") {
                        echo "checked=\"checked\"";
                    }
                    ?>>
                </p>

                <!---------------------------------------------------------------------->
                <select name=cliente[estado_civil]>
                    <?php
                    ec::Lista_Estado_Civil();
                    foreach (ec::$Lista_Estado_Civil as $lista):
                        if ($lista['id'] === cli::$estado_civil) {
                            echo "<option selected='selected' value='" . $lista['id'] . "'>" . $lista['estado_civil'] . "</option>";
                        } else {
                            echo "<option  value='" . $lista['id'] . "'>" . $lista['estado_civil'] . "</option>";
                        }
                    endforeach;
                    ?>
                </select>
                <!---------------------------------------------------------------------->




            </div>
            <div class='col-md-6'>



                <!---------------------------------------------------------------------->
                <h2>Endereço</h2>

                <div class="endereco">
                    <p><label><span class="dashicons dashicons-location-alt"></span>endereço</label>
                    <p><label>digite o endereço</label><input   value="" type="text" id="autocomplete" onFocus="geolocate()" class='form-control' ></p>
                    <p><label>numero</label><input class="form-control" id="street_number" name=endereco['numero'] disabled="true"></p>
                    <p><label>rua</label><input class="form-control" id="route" name=endereco['rua']  disabled="true"></p>
                    <p><label>cidade</label><input class="form-control" id="locality" name=endereco['cidade'] disabled="true"></p>
                    <p><label>estado</label><input class="form-control" id="administrative_area_level_1" name=endereco['estado'] disabled="true"></p>
                    <p><label>cep</label><input class="form-control" id="postal_code" name=endereco['cep'] disabled="true"></p>
                    <p><label>pais</label><input class="form-control" id="country" name=endereco['pais'] disabled="true"></p>
                </div>


                <?php
                foreach (end::endereco_cliente(cli::$IdCliente) as $end):
                    ?>
                    <!--<div class='enderecos'>
                        <input type="checkbox" checked="checked" name=endereco[list][] value="<?php echo $end['id'] ?>">
                        <input class="form-control camposTypeText" type='text'  value='<?php echo $end['endereco'] ?>,<?php echo $end['numero'] ?> , <?php echo $end['complemento'] ?> , <?php echo $end['bairro'] ?> , <?php echo $end['cidade'] ?> , <?php echo $end['estado'] ?> <?php echo $end['cep'] ?>'>
                    </div>-->
                    <br>
                <?php endforeach; ?>
                <!---------------------------------------------------------------------->










                <!---------------------------------------------------------------------->
                <h2>E-mail</h2>
                <div class="divForeach">
                    <span class="dashicons dashicons-email"></span>email:</label>
                    <input type="text"   class="form-control" name=email[]  value="<?php echo $e['email']; ?>" >
                </div>
                <?php
                $emails = em::EmailCliente(cli::$IdCliente);
                foreach ($emails as $e):
                    ?>
                    <div class="divForeach">
                        <input type="text"  class="form-control" name=email[<?php echo $e['id']; ?>]  value="<?php echo $e['email']; ?>" >
                    </div>
                <?php endforeach; ?>
                <!---------------------------------------------------------------------->















                <!---------------------------------------------------------------------->
                <h2>Telefone:</h2>
                <div class="divForeach">
                    <span class="dashicons dashicons-phone"></span> telefone
                    <input type="text"  class="form-control" name=telefone[]  >
                </div>
                <?php
                foreach (tel::Telefone_do_cliente(cli::$IdCliente) as $tel):
                    ?>
                    <div class="divForeach">
                        <input type="text"  class="form-control" name=telefone[<?php echo $tel['id']; ?>]  value="<?php echo $tel['telefone']; ?>" >
                    </div>
                <?php endforeach; ?>
                <!---------------------------------------------------------------------->




            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                foreach (gru::listadeGrupos() as $grupos):
                    echo"<br>";
                    print_r($grupos);
                endforeach;
                ?>
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
    .camposTypeText{
        width: 96%!important; 
        float: right;

    }
    .divForeach{
        overflow: auto;
        height: auto;
        margin-bottom: 11px;
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