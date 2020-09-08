<!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes </title>
            <link rel = "stylesheet" type="text/css" href="Menu.css">
            <link rel = "stylesheet" type="text/css" href="Servicio_Cliente.css">
            <link rel = "stylesheet" type="text/css" href="Registrar_ServicioCliente.css">
            <script src="menu.js"></script>
        </head>
        <body>
        <?php
                    require_once 'login.php';
                    $conexion = new mysqli($hn, $un, $pw, $db);
                                    
                    if ($conexion->connect_error) die ("Fatal error");

                    if(!empty($_POST['dni']) && !empty($_POST['servicio']) && !empty($_POST['plan']) && !empty($_POST['fecha_inicio'])
                    && !empty($_POST['fecha_pagar'])){ 

                        if(isset($_POST['dni']) && isset($_POST['servicio']) && isset($_POST['plan']) && isset($_POST['fecha_inicio'])
                        && isset($_POST['fecha_pagar']))
                        {
                            $dni = mysql_fix_string($conexion, $_POST['dni']);
                            $servicio = mysql_fix_string($conexion, $_POST['servicio']);
                            $plan = mysql_fix_string($conexion, $_POST['plan']);
                            $fecha_inicio =mysql_fix_string($conexion, $_POST['fecha_inicio']);
                            $fecha_pagar = mysql_fix_string($conexion, $_POST['fecha_pagar']);

                                $query = "INSERT INTO servicio VALUES('$servicio','$fecha_inicio','$fecha_pagar','$plan')";
                                $result = $conexion->query($query);

                                $query2 = "INSERT INTO cliente_servicio  VALUES( '$dni','$servicio')";
                                $result2 = $conexion->query($query2);

                            if (!$result || !$result2) die ("Falló registro");
                            header('location: Servico_Cliente.php');          
                        }
                    }else{
                    
                    ?>
                    <div id="openModal" class="modalDialog">
                        <div>
                            <form id ="principal" method="post" action="Registrar_ServicioCliente.php" >
                            <h2>Registro De Servicios</h2>
                                <input type="text" name="dni" placeholder="DNI DEL CLIENTE" >
                                <input type="text" name="servicio" placeholder="SERVICIO">
                                <input type="text" name="plan" placeholder="PLAN">
                                <input type="date" name="fecha_inicio">
                                <input type="date" name="fecha_pagar">
                                <input type="hidden" name="reg" value="yes">
                                <input id ="registro" type="submit" value = "Registrar">
                                <a id ="vuelve" href='Servico_Cliente.php'>Volver Anterior</a>
                            </form>
                            <section id="container2">
                                <h1>Lista de Clientes</h1> 
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
                            <section id="container3">
                                <h1>Lista de Planes</h1> 
                                <table>
                                    <tr>
                                        <th>PLAN</th>
                                        <th>COSTO</th>
                                        <th>MIN. TODO DESTINO</th>
                                        <th>VELOCIDAD (MB)</th>
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
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </table>
                            </section>
                        </div>
                    </div>
                <?php    
                }

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
            <section id="container1">
                <h1>Lista de Usuarios</h1> 
                <a href='Registrar_Cliente.php' class="nota">Registrar</a>

                <form action="Buscar_Cliente.php" method="get" class="form_seach" >
                <input type ="text" placeholder="Buscador... " name = "busqueda" id = "busqueda">
                <input type="submit" value="Buscar" class="btn_search">
                </form>
                <table>
                    <tr>
                        <th>DNI</th>
                        <th>SERVICIO</th>
                        <th>PLAN</th>
                        <th>FECHA DE INICIO</th>
                        <th>FECHA A PAGAR</th>
                        <th>Cambios</th>
                    </tr>
                    <?php
                        require_once 'login.php';
                        $conexion = new mysqli($hn, $un, $pw, $db);
                    
                        if ($conexion->connect_error) die ("Fatal error");

                        $query = "SELECT cs.dniClie, cs.numeServ, s.idPlan,
                                    s.fechInicServ, s.fechPagoServ FROM cliente_servicio as cs 
                                    INNER JOIN servicio as s on cs.numeServ = s.numeServ";

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
                        <td>
                            <a class="link_edit" href = "Actualizar_Cliente.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Editar</a>
                            <a class="link_elimin" href = "Eliminar_Cliente.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Eliminar</a>
                        </td>                        
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
        </body>
        </html>