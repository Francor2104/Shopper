<?php
function registrarProducto($nombre, $monto) {
    $resultado = array(
        'exito' => false,
        'mensaje' => ''
    );

    if (!empty($nombre) && is_numeric($monto) && $monto <= 3500) {
        $producto = array(
            'nombre' => $nombre,
            'monto' => $monto
        );

        if (!isset($_SESSION['productos'])) {
            $_SESSION['productos'] = array();
        }

        $totalAnterior = obtenerTotalProductos();
        $nuevoTotal = $totalAnterior + $monto;

        if ($nuevoTotal <= 50000) {
            $_SESSION['productos'][] = $producto;
            $_SESSION['cantidadProductos'] = count($_SESSION['productos']);

            $resultado['exito'] = true;
            $resultado['mensaje'] = "Producto registrado exitosamente.";
        } else {
            $resultado['mensaje'] = "Error: El registro del producto superaría el total máximo permitido (50000Bs).";
        }
    } else {
        $resultado['mensaje'] = "Error: Por favor, ingresa un nombre válido y un monto no mayor a 3500.";
    }

    return $resultado;
}

function obtenerProductos() {
    return isset($_SESSION['productos']) ? $_SESSION['productos'] : array();
}

function obtenerCantidadProductos() {
    return isset($_SESSION['cantidadProductos']) ? $_SESSION['cantidadProductos'] : 0;
}

function obtenerTotalProductos() {
    $total = 0;
    $productos = obtenerProductos();

    foreach ($productos as $producto) {
        $total += $producto['monto'];
    }

    return $total;
}

function vaciarCarrito() {
    $_SESSION['productos'] = array();
    $_SESSION['cantidadProductos'] = 0;
}
?>