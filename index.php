<!DOCTYPE html>
<html>
<head>
    <title>Registro de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Registro de Productos</h1>

    <?php

    require_once 'funciones.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $monto = $_POST['monto'];

        $resultado = registrarProducto($nombre, $monto);

        if ($resultado['exito']) {
            echo "<p class='success'>" . $resultado['mensaje'] . "</p>";
        } else {
            echo "<p class='error'>" . $resultado['mensaje'] . "</p>";
        }
    }
    ?>

    <form id="formulario" action="index.php" method="post">
        <label for="nombre">Nombre del producto:</label>
        <input type="text" name="nombre" class="text-input" required><br><br>

        <label for="monto">Monto del producto (no mayor a 3500Bs):</label>
        <input type="number" name="monto" class="number-input" min="0" max="3500" required><br><br>

        <input type="submit" value="Registrar Producto" class="submit-button">
    </form>

    <h2>Listado de Precios:</h2>
    <ul id="listaPrecios">
        <?php
        $productos = obtenerProductos();

        if (!empty($productos)) {
            foreach ($productos as $producto) {
                echo "<li>" . $producto->obtenerNombre() . " - " . $producto->obtenerMonto() . "Bs</li>";
            }
        } else {
            echo "<li>No hay productos registrados.</li>";
        }

        ?>
    </ul>
    
    <form action="vaciar.php" method="post">
        <input type="submit" value="Vaciar Carrito" class="submit-button">
    </form>
    
    <h2>Total de Productos Registrados:</h2>
    <p id="totalProductos"><?php echo obtenerCantidadProductos(); ?> Productos registrados.</p>
    <?php
    $total = obtenerTotalProductos();
    echo "<p id='totalProductos'>$total Bs.</p>";
    ?>
</body>
</html>