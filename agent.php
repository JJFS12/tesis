<?php

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/vendor/autoload.php';

$data = [
  'version'=>3,
  'services'=>[
      'orion' => [
        'image' => 'fiware/orion:${ORION_VERSION:-2.0.0}',
        'port' => '- "1026:1026"',
        'comands' => '-logLevel DEBUG -noCache -dbhost mongo',
        'depends_on' => '- mongo',
        ' healthcheck' => [
            'test' => '["CMD", "curl", "-f", "http://0.0.0.0:1026/version"]',
            'interval' => '1m',
            'timeout' => '10s',
            'retries' => 3,

        ],
    ],
    'iot-agent' => [
        'image' => 'fiware/iotagent-ul:latest',
        'hostname' => 'iot-agent',
        'container_name' => 'fiware-iot-agent',
        'depends_on' =>
          'mongo-db',
        'networks' => '- default',
        'expose' => ['4041',
                    '7896'],
        'ports' => ['041:4041',
                   '7896:7896'],
        'environment' => '- IOTA_CB_HOST=orion',
                         '- IOTA_CB_PORT=1026',
                         '- IOTA_NORTH_PORT=4041',
                         '- IOTA_REGISTRY_TYPE=mongodb',
                         '- IOTA_LOG_LEVEL=DEBUG',
                         '- IOTA_TIMESTAMP=true',
                         '- IOTA_CB_NGSI_VERSION=v2',
                         '- IOTA_AUTOCAST=true',
                         '- IOTA_MONGO_HOST=mongo-db',
                         '- IOTA_MONGO_PORT=27017',
                         '- IOTA_MONGO_DB=iotagentul',
                         '- IOTA_HTTP_PORT=7896',
                         '- IOTA_PROVIDER_URL=http://iot-agent:4041',
    ],
    'quantumleap' => [
        'image' => '${QL_IMAGE:-smartsdk/quantumleap}',
        'ports' => ' - "8668:8668"',
        'depends_on:' => '- mongo',
                         '- orion',
                         '- create',
        'enviroment:' => '- CRATE_HOST=${CRATE_HOST:-crate}',
                         '- USE_GEOCODING=True',
                         '- REDIS_HOST=redis',
                         '- REDIS_PORT=6379',
                         '- LOGLEVEL=DEBUG',

    ],
    'mongo' => [
        'image' => 'mongo:3.2.19',
        'ports' => '- "27017:27017"',
        'volumes' => '- mongodata:/data/db',
    ],
    'create' => [
        'image' => ' crate:${CRATE_VERSION:-4.1.4}',
        'commands' => 'crate -Cauth.host_based.enabled=false',
                      '-Ccluster.name=democluster -Chttp.cors.enabled=true -Chttp.cors.allow-origin="*"',
        'ports' => '# Admin UI',
                   '- "4200:4200"',
                   '# Transport protocol',
                   '- "4300:4300"',
        'volumes' => ' - cratedata:/data',
    ],
    'grafana' => [
        'image' => 'grafana/grafana',
        'ports' => '- "3000:3000"',
        'enviroment' => '- GF_INSTALL_PLUGINS=grafana-clock-panel,grafana-worldmap-panel',
        'depends_on' => '- crate',
    ],
    'redis' => [
        'image' => 'redis',
        'ports' => '- "6379:6379"',
        'volumes' => '- redisdata:/data',
    ],
  ],
    'volumes' => [
        'mongodata' =>'' ,
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

$yaml = Yaml::dump($data,4,2);
file_put_contents('test.yaml', $yaml);
