<!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes </title>
            <link rel = "stylesheet" type="text/css" href="Menu.css">
            <link rel = "stylesheet" type="text/css" href="Cargar_Informe.css">
            <link rel = "stylesheet" type="text/css" href="Actualizar_CargarInforme.css">
            <script src="menu.js"></script>
        </head>
        <body>
        <?php 
                require_once 'login.php';
                $conexion = new mysqli($hn, $un, $pw, $db);

                if ($conexion->connect_error) die ("Fatal error");

                if (isset($_POST['id']) && isset($_POST['fecha_pago']) && isset($_POST['pago']) && isset($_POST['dni']) && isset($_POST['plan'])
                        && isset($_POST['Server']))
                {
                    $id = mysql_fix_string($conexion, $_POST['id']);
                    $fecha_pago = mysql_fix_string($conexion, $_POST['fecha_pago']);
                    $pago = mysql_fix_string($conexion, $_POST['pago']);
                    $dni =mysql_fix_string($conexion, $_POST['dni']);
                    $plan =mysql_fix_string($conexion, $_POST['plan']);
                    $Server =mysql_fix_string($conexion, $_POST['Server']);

                        $query = "UPDATE informe SET FechaPago='$fecha_pago',pago='$pago',dniClie='$dni',
                                   idPlan='$plan', numeServ='$Server' WHERE id = '$id' ";
                        $result = $conexion->query($query);

                    if (!$result ) echo "UPDATE falló <br><br>";
                }

                if(empty($_GET['id'])){
                    header('location: Cargar_Informe.php');
                }
                $id = $_GET['id'];

                $query = "SELECT id, FechaPago, pago, dniClie, idPlan, numeServ FROM informe where id = '$id' ";
                $result = $conexion->query($query);
                if (!$result) die ("Consulta falló");

                $filas = $result->num_rows;

                for ($j = 0; $j < $filas; $j++){
                    $row = $result->fetch_array(MYSQLI_NUM);

                    $r0 = htmlspecialchars($row[0]);
                    $r1 = htmlspecialchars($row[1]);
                    $r2 = htmlspecialchars($row[2]);
                    $r3 = htmlspecialchars($row[3]);
                    $r4 = htmlspecialchars($row[4]);
                    $r5 = htmlspecialchars($row[5]);
                }

                echo <<<_END
                    <div id="openModal" class="modalDialog">
                        <div>
                            <form id ="principal" method="post" action="Actualizar_CargarInforme.php" >
                            <h2>Actualizando Pagos</h2>
                                <input type="hidden" name="id" value="$r0">
                                <input type="date" name="fecha_pago" placeholder="FECHA" value="$r1">
                                <input type="number" name="pago" placeholder="COSTO" value="$r2">
                                <input type="text" name="dni" placeholder="DNI DEL CLIENTE" value="$r3" >
                                <input type="text" name="plan" placeholder="PLAN" value="$r4">
                                <input type="text" name="Server" placeholder="SERVICIO" value="$r5">
                                <input id ="registro" type="submit" value = "Actualizar">
                                <a id ="vuelve" href='Cargar_Informe.php'>Volver Anterior</a>
                            </form>
                        </div>
                    </div>
                _END;

                $result->close();
                $conexion->close();

                function mysql_fix_string($conexion, $string)
                {
                    if (get_magic_quotes_gpc())
                        $string = stripcslashes($string);
                    return $conexion->real_escape_string($string);
                } 
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
                    <li><a href="Servico_Cliente.php">Registro De Servicio</a></li>
                    <li><a href="Cargar_Informe.php">Plan / Pago</a></li>
                </ul>
            </nav>
            <section id="container">
                <h1>Lista de Pagos</h1> 
                <a href='Registrar_CargarInforme.php' class="nota">Registrar</a>

                <form action="#" method="get" class="form_seach" >
                <input type ="text" placeholder="Buscador... " name = "busqueda" id = "busqueda">
                <input type="submit" value="Buscar" class="btn_search">
                </form>
                <table>
                    <tr>
                        <th>DNI</th>
                        <th>PLAN</th>
                        <th>SERVICIO</th>
                        <th>FECHA</th>
                        <th>CANT. PAGO</th>
                        <th>Cambios</th>
                    </tr>
                    <?php
                        require_once 'login.php';
                        $conexion = new mysqli($hn, $un, $pw, $db);
                    
                        if ($conexion->connect_error) die ("Fatal error");

                        $query = "SELECT id, FechaPago, pago, dniClie, idPlan, numeServ FROM informe";
                        $result = $conexion->query($query);
                        if (!$result) die ("Consulta falló");

                        $filas = $result->num_rows;

                        for ($j = 0; $j < $filas; $j++){

                            $fila = $result->fetch_array(MYSQLI_NUM);
                    ?>            
                    <tr>
                        <td><?php echo htmlspecialchars($fila[3]); ?></td>
                        <td><?php echo htmlspecialchars($fila[4]); ?></td>
                        <td><?php echo htmlspecialchars($fila[5]); ?></td> 
                        <td><?php echo htmlspecialchars($fila[1]); ?></td> 
                        <td><?php echo htmlspecialchars($fila[2]); ?></td>  
                        <td>
                            <a class="link_edit" href = "Actualizar_Cliente.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Editar</a>
                            <a class="link_elimin" href = "Eliminar_CargarInforme.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Eliminar</a>
                        </td>                      
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
            <section id="container1">
                <h1>Lista de Planes</h1> 
                <a href='Registrar_InformePlan.php' class="nota">Registrar</a>

                <form action="Buscar_InformePlan.php" method="get" class="form_seach" >
                <input type ="text" placeholder="Buscador... " name = "busqueda" id = "busqueda">
                <input type="submit" value="Buscar" class="btn_search">
                </form>
                <table>
                    <tr>
                        <th>PLAN</th>
                        <th>COSTO</th>
                        <th>MIN. TODO DESTINO</th>
                        <th>VELOCIDAD (MB)</th>
                        <th>Cambios</th>
                    </tr>
                    <?php
                        require_once 'login.php';
                        $conexion = new mysqli($hn, $un, $pw, $db);
                    
                        if ($conexion->connect_error) die ("Fatal error");

                        $query = "SELECT idPlan, costPan, minutDestPlan, BMPlan FROM plan";
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
                        <td>
                            <a class="link_edit" href = "Actualizar_InformePlan.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Editar</a>
                        </td>                        
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
        </body>
        </html>