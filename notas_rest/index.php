<!DOCTYPE html>
<!-- Formulario examen PHP Desarrollo aplicación entorno Servidor DAW2
Presenta un formulario que toma los datos para:
Dar de alta una nota de examen
Modificar una nota indicando DNI y fecha_hora del examen
Calcular la nota media indicando DNI y asignatura -->
<html lang="es">
<head>
  <title>Notas</title>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<h1>Gestión de Notas</h1>
<div>
  <form name="cliente" method="POST" action="cliente.php">
    <p><label>Nombre: <input type="text" name="nombre"/></label></p>
    <p><label>DNI: <input type="text" name="dni"/></label></p>
    <p><label>Grupo: <input type="text" name="grupo"/></label></p>
    <p><label>Fecha y Hora (YYYY-MM-DDThh:mm): <input type="datetime-local" name="fecha_hora"/></label></p>
    <p><label>Asignatura: <input type="text" name="asignatura"/></label></p>
    <p><label>Nota: <input type="number" name="nota"/></label></p>
    <div>
      <button type="submit" name="nueva">Nueva</button>
      <button type="submit" name="modificar">Modificar</button>
      <button type="submit" name="media">Nota Media</button>
      <button type="reset" name="cancelar">Cancelar</button>
    </div>
  </form>
</div>
<h3><a href="http://localhost:63342/PHP_V1/index.php">Volver al índice</a></h3>
</body>
</html>