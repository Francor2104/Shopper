<?php
session_start();
class Producto {
    private $nombre;
    private $monto;

    public function __construct($nombre, $monto) {
        $this->nombre = $nombre;
        $this->monto = $monto;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function obtenerMonto() {
        return $this->monto;
    }
}

class RegistroProductos {
    private $productos;
    private $cantidadProductos;

    public function __construct() {
        
        $this->productos = isset($_SESSION['productos']) ? $_SESSION['productos'] : array();
        $this->cantidadProductos = isset($_SESSION['cantidadProductos']) ? $_SESSION['cantidadProductos'] : 0;
    }

    public function registrarProducto($nombre, $monto) {
        $resultado = array(
            'exito' => false,
            'mensaje' => ''
        );

        if (!empty($nombre) && is_numeric($monto) && $monto <= 3500) {
            $producto = new Producto($nombre, $monto);

            $totalAnterior = $this->obtenerTotalProductos();
            $nuevoTotal = $totalAnterior + $monto;

            if ($nuevoTotal <= 50000) {
                $this->productos[] = $producto;
                $this->cantidadProductos++;

                $resultado['exito'] = true;
                $resultado['mensaje'] = "Producto registrado exitosamente.";
            } else {
                $resultado['mensaje'] = "Error: El registro del producto superaría el total máximo permitido (50000Bs).";
            }
        } else {
            $resultado['mensaje'] = "Error: Por favor, ingresa un nombre válido y un monto no mayor a 3500.";
        }

        $_SESSION['productos'] = $this->productos;
        $_SESSION['cantidadProductos'] = $this->cantidadProductos;

        return $resultado;
    }

    public function vaciarCarrito() {
        $this->productos = array();
        $this->cantidadProductos = 0;
        unset($_SESSION['productos']);
        unset($_SESSION['cantidadProductos']);
    }

    public function obtenerProductos() {
        return $this->productos;
    }

    public function obtenerCantidadProductos() {
        return $this->cantidadProductos;
    }

    public function obtenerTotalProductos() {
        $total = 0;

        foreach ($this->productos as $producto) {
            $total += $producto->obtenerMonto();
        }

        return $total;
    }
}

function registrarProducto($nombre, $monto) {
    $registroProductos = new RegistroProductos();
    return $registroProductos->registrarProducto($nombre, $monto);
}

function vaciarCarrito() {
    $registroProductos = new RegistroProductos();
    $registroProductos->vaciarCarrito();
}

function obtenerProductos() {
    $registroProductos = new RegistroProductos();
    return $registroProductos->obtenerProductos();
}

function obtenerCantidadProductos() {
    $registroProductos = new RegistroProductos();
    return $registroProductos->obtenerCantidadProductos();
}

function obtenerTotalProductos() {
    $registroProductos = new RegistroProductos();
    return $registroProductos->obtenerTotalProductos();
}