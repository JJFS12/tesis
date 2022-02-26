# Descripción

## Levantar servicios FIWARE

Paso 1 en el servidor de linux se ingresa el siguiente comando:
docker-compose -f docker-compose-demo.yml up -d

donde docker-compose-demo.yml es el nombre del archivo yml que se deescargo del sistema web

Paso 2 Una vez que los servicios se despliegan correctamente, podemos verificar su funcionamiento accediendo a ellos a través de los puertos indicados en el docker-compose y verificando que los servicios están ejecutándose con el comando:

docker ps


## Conexión con GRAFANA

Grafana es una herramienta de visualización de datos open source comúnmente usada en monitoreo de infraestructura como sensores, automatización, condiciones ambientales y control de procesos. Ofrece una interfaz web para la creación de componentes gráficos basadas en series tiempo utilizando distintas bases de datos con sus respectivos lenguajes y sentencias.

Accedemos al servicio desde un navegador a Grafana en http://localhost:3000/

Las credenciales por default son:

user :admin password: admin

Posteriormente, solicitará cambiar la contraseña de administrador e ingresaremos al panel de administración.

para realizar la conexion entre grafana y la aplicacion web es necesarion cambiar un parametro dentro del archivo de configuracion de grafana, para esto en la consola de comandos del servidor ponemos el siguiente comando.

docker exec --user root ..workdir / -it 31b7ea366df7 sh

posteriormente aplicamos el siguiente comando 

cd etc

para despues aplicar el siguiente comando 

cd grafana

y finalmente poner el comando para ingresar al archivo de grafana 

vi grafan.ini

Una vez en el archivo de grafana utilizamos el comando para buscar el parametro allow_embedding

/allow_embedding


Una vez encontrado el parametro  utilizamos la tecla a para editar el archivo removiendo el ; y cambion el parametro de false a true como se muestra en la imagen y oprimimos esc.

despues buscamos el parametro enable anonymous access

/auth.anonymous

de igual forma con la tecla a editamos el parametro a true y removemos el ; y oprimimos esc para dejar de editar el archivo.


Con la teclas :w  guardamos los cambios y finalmente con las teclas :q salimos del archivo.

una vez fuera del archivo tilizamos el comando exit para salir de la carpeta de grafana.

Finalmente reiniciamos el archivo con el comando 

docker restart 31b7ea366df7

Si nois dirigimos al sistema web en al apartado de grafica del dispositivo podemos ver que se muestra el componente de grafana.