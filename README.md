## PROYECTO CIUDAD MADERAS CRM

### Normativas código CRM

1. Separar la funcionalidad por módulos.
2. Los archivos deben de estar en la carpeta.
3. Estructura de vistas:
   - vista.view.php
   - usuarios-listado-contraloria.view.php => Usarse para vistas específicas.
   - usuarios-listado.view.php => Usarse para vistas generales
4. Estructura del modelo:
   - Modelo_model.php
   - Ejemplo: Usuarios_model
5. Estructura del controlador:
   - Controlador.php
   - Ejemplo: Usuarios.php
6. Variables en camelCase (poner nombres descriptivos)
7. Funciones en camelCase y referentes a lo que hace dicha función
8. Manejar tipo de datos de parámetros y de retorno
   ```php
   function actualizarNombre(int $idUsuario, string $nombre)
   ```
