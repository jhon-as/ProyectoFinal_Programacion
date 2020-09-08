<!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes </title>
            <link rel = "stylesheet" type="text/css" href="Menu.css">
            <link rel = "stylesheet" type="text/css" href="Cliente_Usuario.css">
            <link rel = "stylesheet" type="text/css" href="Eliminar_Cliente.css">
            <script src="menu.js"></script>
        </head>
        <body>
            <?php 
                require_once 'login.php';
                $conexion = new mysqli($hn, $un, $pw, $db);

                if ($conexion->connect_error) die ("Fatal error");

                if (isset($_POST['dni']))
                {
                    $dni = $_POST['dni'];

                        $query = "DELETE FROM rol_usuario WHERE dni = '$dni'";
                        $query2  = "DELETE FROM cliente WHERE dniClie = '$dni'";
                        $result = $conexion->query($query);
                        $result2 = $conexion->query($query2);
                        header('location: Cliente_Usuario.php');
                    if (!$result || !$result2) echo "UPDATE falló <br><br>";
                }

                if(empty($_GET['id'])){
                    header('location: Cliente_Usuario.php');
                }
                $dni = $_GET['id'];

                echo <<<_END
                    <div id="openModal" class="modalDialog">
                        <div>
                            <form id ="principal" method="post" action="Eliminar_Cliente.php" >
                            <h2>¿Desea eliminar?</h2>
                                <input type="hidden" name="dni" value = "$dni">
                                <input id ="inicio" type="submit" value = "Eliminar">
                                <a id ="cuenta" href='Cliente_Usuario.php'>Volver Anterior</a>
                            </form>
                        </div>
                    </div>
                _END;
                $conexion->close();
            ?>                
            <nav>
                <input type="checkbox" id = "check">
                <label for ="check" class="checkbtn">
                    <i class = "fas fa-bars"></i>
                </label>
                <label class ="logo">Lifinet</label>
                <ul>
                    <li><a class ="active" href="PaginaPrincipal.php">Inicio</a></li>
                    <li><a href="Cliente_Usuario.php">Cliente / Usuario</a></li>
                    <li><a href="#">Registro De Servicio</a></li>
                    <li><a href="Cargar_Informe.php">Plan / Pago</a></li>
                </ul>
            </nav>
            <section id="container">
                <h1>Lista de Clientes</h1> 

                <form action="buscar.php" method="get" class="form_seach" >
                <input type ="text" placeholder="Buscador... " name = "busqueda" id = "busqueda">
                <input type="submit" value="Buscar" class="btn_search">
                </form>
                <table>
                    <tr>
                        <th>DNI</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>CELULAR</th>
                    </tr>
                    <?php
                        require_once 'login.php';
                        $conexion = new mysqli($hn, $un, $pw, $db);
                    
                        if ($conexion->connect_error) die ("Fatal error");

                        $query = "SELECT dniClie,nombClie, apelClie, celuClie FROM cliente";
                        $result = $conexion->query($query);
                        if (!$result) die ("Consulta falló");

                        $filas = $result->num_rows;

                        for ($j = 0; $j < $filas; $j++){

                            $fila = $result->fetch_array(MYSQLI_NUM);
                    ?>            
                    <tr>
                        <td><?php echo htmlspecialchars($fila[0]); ?></td> 
                        <td><?php echo htmlspecialchars($fila[1]); ?></td> 
                        <td><?php echo htmlspecialchars($fila[2]); ?></td>
                        <td><?php echo htmlspecialchars($fila[3]); ?></td>                        
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
            <section id="container1">
                <h1>Lista de Usuarios</h1> 
                <a href='#' class="nota">Registrar</a>

                <form action="buscar.php" method="get" class="form_seach" >
                <input type ="text" placeholder="Buscador... " name = "busqueda" id = "busqueda">
                <input type="submit" value="Buscar" class="btn_search">
                </form>
                <table>
                    <tr>
                        <th>DNI</th>
                        <th>ROL</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>CONTRASEÑA</th>
                        <th>TELEFONO</th>
                        <th>Cambios</th>
                    </tr>
                    <?php
                        require_once 'login.php';
                        $conexion = new mysqli($hn, $un, $pw, $db);
                    
                        if ($conexion->connect_error) die ("Fatal error");

                        $query = "SELECT dni,rol, nombre, apellido,contrasena,telefono FROM rol_usuario";
                        $result = $conexion->query($query);
                        if (!$result) die ("Consulta falló");

                        $filas = $result->num_rows;

                        for ($j = 0; $j < $filas; $j++){

                            $fila = $result->fetch_array(MYSQLI_NUM);
                    ?>            
                    <tr>
                        <td><?php echo htmlspecialchars($fila[0]); ?></td> 
                        <td><?php echo htmlspecialchars($fila[1]); ?></td> 
                        <td><?php echo htmlspecialchars($fila[2]); ?></td>
                        <td><?php echo htmlspecialchars($fila[3]); ?></td> 
                        <td><?php echo htmlspecialchars($fila[4]); ?></td>
                        <td><?php echo htmlspecialchars($fila[5]); ?></td>
                        <td>
                            <a class="link_edit" href = "actualizar.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Editar</a>
                            <a class="link_elimin" href = "eliminar.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Eliminar</a>
                        </td>                        
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
        </body>
        </html>