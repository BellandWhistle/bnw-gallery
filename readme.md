# BnW Gallery

Este plugin ha sido concebido con la intención de navegar por los adjuntos de WordPress (inicialmente imágenes) de la manera más rápida usando bibliotecas Javascript como [Backbone](https://github.com/documentcloud/backbone), [jQuery](https://github.com/jquery/jquery) y la API HTML5 History para hacer la carga asíncrona, mucho más rápida y evitar tener que descargar los archivos fijos como CSS/JS cada vez.

Además se ha tratado de que la navegación sea transparente para el usuario, ya que se usa las mismas URLs que genera WordPres, haciendo que no se pierda la navegación al refrescar la página o al compartir la URL.

## Limitaciones

Este plugin no será muy útil si deseas generar impresiones para aumentar tus ganancias en AdSense, al menos hasta que Google permita la recarga dinámica de Ads.

## Dependencias

Por ahora BnW Gallery necesita tener instalado el plugin [WP-PageNavi](http://wordpress.org/extend/plugins/wp-pagenavi/). Esto será corregido en las próxima actualización para que funcione con la navegación de WordPress que viene incluída por defecto.

## Instrucciones de uso

1. Descargar el archivo .zip o clonar el repositorio en la carpeta de plugin de tu instalación de  WordPress.
2. Cerciorarse de tener instalado el plugin [WP-PageNavi](http://wordpress.org/extend/plugins/wp-pagenavi/).
3. El permalink de WordPress debe estar configurado con la siguiente estructura `/%category%/%postname%.html`
4. Publicar posts bajo el tag "Gallery" (Por ahora no es configurable, pero lo será)
5. Enjoy.

## TODO / Planes
1. Corregir la dependecia de WP-PageNavi o al menos hacerlo opcional.
2. Ofrecer una API JS.
3. Mudar el código a Coffeescript y usar [Chaplin](https://github.com/chaplinjs/chaplin)
4. Mejorar la estética y transiciones, señalar que se está cargando o si algo falla.
5. Manejar cualquier caso de permalink de Wordpress. (Cualquier idea aquí será bienvenida en cómo parsear la estructura elegida por el usuario sería muy apreciado)
6. Ofrecer la alternativa de hacer que una o más tags o categorías sean manejados por BnW Gallery

## Changelog

### 0.1 ###
* Primera liberación


## Créditos

Este plugin ha sido creado y es mantenido por [@asumaran](https://github.com/asumaran), si deseas ser contribuir puedes dejar un "pull request" o reportar un bug.