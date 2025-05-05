<?php
                        // Conecta a la base de datos
                        $conexion = new mysqli('localhost', 'root', '', 'sistemv_1');
                    
                        if ($conexion->connect_error) {
                            die("Error de conexión: " . $conexion->connect_error);
                        }


