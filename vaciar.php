<?php
session_start();

require_once 'funciones.php';

vaciarCarrito();

header("Location: index.php");
?>