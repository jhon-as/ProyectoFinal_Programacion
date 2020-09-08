<!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes </title>
            <link rel = "stylesheet" type="text/css" href="Menu.css">
            <link rel = "stylesheet" type="text/css" href="Cargar_Informe.css">
            <script src="menu.js"></script>
        </head>
        <body>
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
                <h1>Lista de Pagos</h1> 
                <a href='Registrar_Cliente.php' class="nota">Importar</a>

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
                        </td>                      
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
            <section id="container1">
                <?php

                    $buscar = strtolower($_REQUEST['busqueda']);

                    if(empty($buscar)){
                        header("location: Cliente_Usuario.php");
                    }
                ?>
                <h1>Lista de Planes</h1> 
                <a href='Registrar_InformePlan.php' class="nota">Registrar</a>

                <form action="Buscar_InformePlan.php" method="get" class="form_seach" >
                <input type ="text" placeholder="Buscador... " name = "busqueda" id = "busqueda" value="<?php echo $buscar ?> ">
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

                        $query = "SELECT idPlan, costPan, minutDestPlan, BMPlan FROM plan
                                        where(
                                            idPlan like '%$buscar%' OR
                                            costPan LIKE '%$buscar%' OR 
                                            minutDestPlan LIKE '%$buscar%' OR 
                                            BMPlan LIKE '%$buscar%'
                                        )";
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