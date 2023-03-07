# TiendaApp

## La tienda mas cerca de ti

Aplicacion de manejar la administracion de productos de una compañia con relacion a diferentes marcas.
La aplicacion gestiona.
- Creacion de nuevos productos
- Edicion de productos
- Creacion de nuevas marcas 
- Edicion de marcas
- Eliminar productos 
- Eliminar marcas


## Instalacion
1.Sigue estos pasos para instalar y configurar el proyecto en tu máquina local:

```sh
git clone https://github.com/IngMarcela/TiendaApp
```

2. Accede a la carpeta del proyecto:

```sh
cd tu-proyecto
```

3. Copia el archivo .env.example y renómbralo a .env:

```sh
cp .env.example .env
```

4. Genera la clave de cifrado de la aplicación:

```sh
php artisan key:generate
```

5. Configura las credenciales de la base de datos en el archivo .env:

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tienda_app
DB_USERNAME=root
DB_PASSWORD=
```

6. Instala las dependencias del proyecto:

```sh
composer install
```

7. Ejecuta las migraciones y los seeders para crear las tablas y llenarlas con datos de ejemplo:

```sh
php artisan migrate --seed
```

8. Ejecuta el servidor local:

```sh
php artisan serve
```

9. Ejecuta el comando npm install o yarn install para instalar las dependencias de JavaScript necesarias para el proyecto

```sh
npm install o yarn install
```

Accede a la aplicación en tu navegador web en la URL http://localhost:8000.
Recuerda que para ejecutar la aplicación es necesario tener instalado PHP y MySQL en tu máquina.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


Cordial saludo,

Le envío el reto con el desarrollo de mi prueba realizada en el repositorio https://github.com/IngMarcela/TiendaApp/tree/main.

Teniendo en cuenta la complejidad del reto, no pude hacer inserción de mocks en las pruebas, ya que el reto no lo requería. Además, no se están trabajando con inyección de dependencias ni se están usando servicios externos para hacer uso del patrón repository, aunque quiero destacar que tengo experiencia manejando dichas herramientas.

También quiero disculparme por haber hecho y subido los commits el mismo día. La razón es que presté un ordenador para subir la prueba, ya que en mi empresa actual tengo bloqueadas algunas funcionalidades comunes de un computador y actualmente no cuento con uno personal.

Agradezco la oportunidad brindada para presentar la prueba y quedo a la espera de una pronta respuesta.

Gracias por su atención.
