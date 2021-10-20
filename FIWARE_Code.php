<?php

use Symfony\Component\Yaml\Yaml;
include 'inc/header.php';
Session::CheckSession();
$i=$_GET['id'];
 ?>


 <div class="card ">
   <div class="card-header">
          <h3>FIWARE Code<span class="float-right"> <a href="index.php" class="btn btn-primary">Back</a> </h3>
        </div>
        <div class="card-body">

    <?php
    $getUinfo = $devices->getDeviceInfoById($i);
    if ($getUinfo) {

     ?>


          <div style="width:600px; margin:0px auto">

          <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].$_SERVER['id='].$i)?>" method="POST">
              <div class="form-group">
                <label for="name">Device name</label>
                <input type="text" name="name" value="<?php echo $getUinfo->name; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">readings</label>
                <input type="text" name="readings" value="<?php echo $getUinfo->readings; ?>" class="form-control">
              </div>

              <div class="form-group">
                <label for="username">readings</label>
                <input type="text" name="username" value="<?php echo $getUinfo->readings; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">Orion Context Broker address</label>
                <input type="text" name="OCB" value="<?php echo $getUinfo->ocba; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">Iot Agent</label>
                <input type="text" name="CBH" value="<?php echo $getUinfo->IoTAgent; ?>" class="form-control">
              </div>



              <?php
              require_once __DIR__ . '/vendor/autoload.php';
              if ($getUinfo->IoTAgent=='MQTT'){
                $data = [
                  'version'=>3,
                  'services'=>[
                      'orion' => [
                        'image' => ['fiware/orion:${ORION_VERSION:-2.0.0}'],
                        'port' => '- "1026:1026"',
                        'comands' => '-logLevel DEBUG -noCache -dbhost mongo',
                        'depends_on' => '- mongo',
                        'healthcheck' => [
                            'test' => '["CMD", "curl", "-f", "http://0.0.0.0:1026/version"]',
                            'interval' => '1m',
                            'timeout' => '10s',
                            'retries' => 3,

                        ],
                    ],
                    'iot-agent' => [
                        'image' => ' fiware/iotagent-ul:latest ',
                        'hostname' => 'iot-agent',
                        'container_name' => 'fiware-iot-agent',
                        'depends_on' =>
                          'mongo-db',
                        'networks' => '- default',
                        'expose' => ["4041",
                                    '7896'],
                        'ports' => ['4041:4041',
                                   '7896:7896'],
                        'environment' => ['IOTA_CB_HOST=orion',
                                          "IOTA_CB_PORT=1026",
                                          "IOTA_NORTH_PORT=4041",
                                          "IOTA_REGISTRY_TYPE=mongodb",
                                          "IOTA_MONGO_HOST=mongodb",
                                          "IOTA_MONGO_PORT=27017",
                                          "IOTA_MONGO_DB=iotagent-json",
                                          "IOTA_HTTP_PORT=7896",
                                          "IOTA_PROVIDER_URL=http://iot-agent:4041",]
                    ],
                    'quantumleap' => [
                        'image' => '${QL_IMAGE:-smartsdk/quantumleap}',
                        'ports' => ['8668:8668',],
                        'depends_on' => ['mongo',
                                         'orion',
                                         'create',],
                        'enviroment' => ['CRATE_HOST=${CRATE_HOST:-crate}',
                                         'USE_GEOCODING=True',
                                         'REDIS_HOST=redis',
                                         'REDIS_PORT=6379',
                                         'LOGLEVEL=DEBUG',]

                    ],
                    'mongo' => [
                        'image' => 'mongo:3.2.19',
                        'ports' => ['27017:27017'],
                        'volumes' => ['mongodata:/data/db'],
                    ],
                    'create' => [
                        'image' => ' crate:${CRATE_VERSION:-4.1.4}',
                        'commands' => 'crate -Cauth.host_based.enabled=false',
                                      ['Ccluster.name=democluster -Chttp.cors.enabled=true -Chttp.cors.allow-origin="*"'],
                        'ports' => '# Admin UI',
                                   ['4200:4200'],
                                   '# Transport protocol',
                                   ['4300:4300'],
                        'volumes' => ['cratedata:/data'],
                    ],
                    'grafana' => [
                        'image' => 'grafana/grafana',
                        'ports' => ['3000:3000' ],
                        'enviroment' => ['GF_INSTALL_PLUGINS=grafana-clock-panel,grafana-worldmap-panel' ],
                        'depends_on' => ['crate' ],
                    ],
                    'redis' => [
                        'image' => 'redis',
                        'ports' => ['6379:6379' ],
                        'volumes' => ['redisdata:/data' ],
                    ],
                  ],
                    'volumes' => [
                        'mongodata' =>'',
                        'createdata' =>'',
                        'redisdata' =>'',
                    ],
                    'networks' => [
                        'default' =>[
                          'driver_opts' =>[
                            'com.docker.network.driver.mtu' =>'${DOCKER_MTU:-1400}',



                          ],

                        ],
                    ],
                ];
              }else{
                $data = [
                  'version'=>3,
                  'services'=>[
                      'orion' => [
                        'image' => ['fiware/orion:${ORION_VERSION:-2.0.0}'],
                        'port' => '- "1026:1026"',
                        'comands' => '-logLevel DEBUG -noCache -dbhost mongo',
                        'depends_on' => '- mongo',
                        'healthcheck' => [
                            'test' => '["CMD", "curl", "-f", "http://0.0.0.0:1026/version"]',
                            'interval' => '1m',
                            'timeout' => '10s',
                            'retries' => 3,

                        ],
                    ],
                    'iot-agent' => [
                        'image' => ' fiware/iotagent-ul:latest ',
                        'hostname' => 'iot-agent',
                        'container_name' => 'fiware-iot-agent',
                        'depends_on' =>
                          'mongo-db',
                        'networks' => '- default',
                        'expose' => ["4041",
                                    '7896'],
                        'ports' => ['4041:4041',
                                   '7896:7896'],
                        'environment' => ['IOTA_CB_HOST=orion',
                                          "IOTA_CB_PORT=1026",
                                          "IOTA_NORTH_PORT=4041",
                                          "IOTA_REGISTRY_TYPE=mongodb",
                                          "IOTA_MONGO_HOST=mongodb",
                                          "IOTA_MONGO_PORT=27017",
                                          "IOTA_MONGO_DB=iotagent-lwm2m",
                                          "LWM2M_PORT=5683",]
                    ],
                    'quantumleap' => [
                        'image' => '${QL_IMAGE:-smartsdk/quantumleap}',
                        'ports' => ['8668:8668',],
                        'depends_on' => ['mongo',
                                         'orion',
                                         'create',],
                        'enviroment' => ['CRATE_HOST=${CRATE_HOST:-crate}',
                                         'USE_GEOCODING=True',
                                         'REDIS_HOST=redis',
                                         'REDIS_PORT=6379',
                                         'LOGLEVEL=DEBUG',]

                    ],
                    'mongo' => [
                        'image' => 'mongo:3.2.19',
                        'ports' => ['27017:27017'],
                        'volumes' => ['mongodata:/data/db'],
                    ],
                    'create' => [
                        'image' => ' crate:${CRATE_VERSION:-4.1.4}',
                        'commands' => 'crate -Cauth.host_based.enabled=false',
                                      ['Ccluster.name=democluster -Chttp.cors.enabled=true -Chttp.cors.allow-origin="*"'],
                        'ports' => '# Admin UI',
                                   ['4200:4200'],
                                   '# Transport protocol',
                                   ['4300:4300'],
                        'volumes' => ['cratedata:/data'],
                    ],
                    'grafana' => [
                        'image' => 'grafana/grafana',
                        'ports' => ['3000:3000' ],
                        'enviroment' => ['GF_INSTALL_PLUGINS=grafana-clock-panel,grafana-worldmap-panel' ],
                        'depends_on' => ['crate' ],
                    ],
                    'redis' => [
                        'image' => 'redis',
                        'ports' => ['6379:6379' ],
                        'volumes' => ['redisdata:/data' ],
                    ],
                  ],
                    'volumes' => [
                        'mongodata' =>'',
                        'createdata' =>'',
                        'redisdata' =>'',
                    ],
                    'networks' => [
                        'default' =>[
                          'driver_opts' =>[
                            'com.docker.network.driver.mtu' =>'${DOCKER_MTU:-1400}',



                          ],

                        ],
                    ],
                ];
              }


              $yaml = Yaml::dump($data,4,2);

              file_put_contents('docker-compose.yaml', $yaml);

              ?>

              <div class="form-group">
              <div class="bg-card dark shadow rounded mb-4 p-4 ng-star-inserted">

                <link rel="stylesheet" href="css/style2.css" />
                <div class="header"> FIWARE CONNECTION CODE</div>
                <div class="control-panel">
                  <select id="languages" class="languages" onchange="changeLanguage()">
                              <option value="yaml"> yaml </option>
                              <option value="node"> Json </option>
                          </select>
                </div>

                <div class="editor" id="editor" > <?php echo " $yaml " ?></div>

                <div class="button-container">
                  <button class="btn" onclick="executeCode()"> download </button>
                </div>

                <div class="output"></div>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="lib/ace.js"></script>
                <script src="lib/theme-monokai.js"></script>
                <script src="ide.js"></script>
              </div>
              </div>




              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">submit</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Delete</a>
              </div>
            <?php } elseif(Session::get("roleid") == '2') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">n</button>

              </div>

              <?php   }else{ ?>
                  <div class="form-group">

                    <a class="btn btn-primary" href="index.php">Submit</a>
                  </div>
                <?php } ?>


          </form>
        </div>




      </div>
    </div>


  <?php
  include 'inc/footer.php';

  ?>
