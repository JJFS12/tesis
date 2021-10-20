<?php
include 'inc/header.php';
Session::CheckSession();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addDevice'])) {

  $deviceAdd = $devices->addNewDevice($_POST);
}
if (isset($deviceAdd)) {
  echo $deviceAdd;
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->

<div class="card ">
  <div class="card-header">
         <h3 class='text-center'>Add New Device</h3>
       </div>
       <div class="cad-body">
           <div style="width:600px; margin:0px auto">
           <form class="" action="" method="post">
               <div class="form-group pt-3">
                 <label for="name">Name</label>
                 <input type="text" name="name"  class="form-control">
               </div>

               <div class="form-group pt-3">
                 <label for="name">Units</label>
                 <input type="text" name="units"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">Max value</label>
                 <input type="text" name="max"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">Min value</label>
                 <input type="text" name="min"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">OCB Address</label>
                 <input type="text" name="ocba"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="protocol">Choose a protocol:</label>
                  <select id="protocol" name="protocol" class="form-control">
                    <option value="">Select</option>}
                    <option value="MQTT">MQTT</option>
                    <option value="COAP">COAP</option>
                  </select>
               </div>
               <div class="form-group pt-3">
                 <label for="agent">Choose an IoT Agent:</label>
                 <select id="agent" name="agent" class="form-control">
                     <option value="">-- select one -- </option>
                 </select>
               </div>


               <script type="text/javascript">

                 // Map your choices to your option value
                 var lookup = {
                    'MQTT': ['IoTAgent-UL', 'IoTAgent-JSON '],
                    'COAP': ['IoTAgent-LWM2M', 'IoTagent-LoraWAN'],
                    'Option 3': ['Option 3 - Choice 1'],
                 };

                 // When an option is changed, search the above for matching choices
                 $('#protocol').on('change', function() {
                    // Set selected option as variable
                    var selectValue = $(this).val();

                    // Empty the target field
                    $('#agent').empty();

                    // For each chocie in the selected option
                    for (i = 0; i < lookup[selectValue].length; i++) {
                       // Output choice in the target field
                       $('#agent').append("<option value='" + lookup[selectValue][i] + "'>" + lookup[selectValue][i] + "</option>");
                    }
                 });
               </script>
               <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
               <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

               <div class="form-group pt-3">
                 <label for="readings">readings</label>
                 <select name="readings[]" class="js-example-basic-multiple js-states form-control"  multiple="multiple">
                   <option value="1">CO en µg/m³</option>
                   <option value="2">O3 en µg/m³</option>
                   <option value="3">NO2 en µg/m³</option>
                   <option value="4">PM1.0 en µg/m³</option>
                   <option value="5">PM10 en µg/m³</option>
                   <option value="6">PM2.5 en µg/m³</option>
                   <option value="7">PM4.0 en µg/m³</option>
                   <option value="8">SO2 en µg/m³</option>
                   <option value="9">Altitud en metros</option>
                   <option value="10">NO en µg/m³</option>
                   <option value="11">Punto de rocí­o en grados celsius</option>
                   <option value="12">Humedad relativa en %</option>
                   <option value="13">Insolación en W/m²</option>
                   <option value="14">Precipitación lí­quida en mm</option>
                   <option value="location">location</option>
                   <option value="16">Temperatura máxima en grados celsius</option>
                   <option value="17">Dirección del viento máxima en grados</option>
                   <option value="18">Velocidad del viento máxima en m/s</option>
                   <option value="19">pH </option>
                   <option value="20">Presión barométrica en hPa</option>
                   <option value="21">radiation en W/m²</option>
                   <option value="22">refTime</option>
                   <option value="23">Temperatura del suelo en grados celsius</option>
                   <option value="24">Precipitación sólida en mm</option>

                   <option value="temperatura">Temperatura</option>
                   <option value="26">Tamaño típico de partí­cula en μm</option>
                   <option value="27">Visibilidad en metros</option>
                   <option value="28">Dirección del viento en grados</option>
                   <option value="29">Velocidad del viento en m/s</option>
                   <option value="humedad">humedad</option>

                 </select>
               </div>

                <script type="text/javascript">
                      $(".js-example-basic-multiple").select2({    tags: true,tokenSeparators: [',', ' ']});
                </script>
               <div class="form-group">
                 <button type="submit" name="addDevice" class="btn btn-success">Register</button>
               </div>
           </form>
         </div>
       </div>
     </div>
<?php

?>

 <?php
 include 'inc/footer.php';

 ?>
