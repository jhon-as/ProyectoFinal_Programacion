<!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes </title>
            <link rel = "stylesheet" type="text/css" href="Menu.css">
            <link rel = "stylesheet" type="text/css" href="Cliente_Usuario.css">
            <link rel = "stylesheet" type="text/css" href="Registrar_InformePlan.css">
            <script src="menu.js"></script>
        </head>
        <body>
            <?php
                    require_once 'login.php';
                    $conexion = new mysqli($hn, $un, $pw, $db);
                                    
                    if ($conexion->connect_error) die ("Fatal error");

                    if(!empty($_POST['Plan']) && !empty($_POST['costo']) && !empty($_POST['min_destino']) && !empty($_POST['velocidad'])){ 

                        if(isset($_POST['Plan']) && isset($_POST['costo']) && isset($_POST['min_destino']) && isset($_POST['velocidad']))
                        {
                            $plan =  $_POST['Plan'];
                            $costo =  $_POST['costo'];
                            $min_destino = $_POST['min_destino'];
                            $velocidad = $_POST['velocidad'];
                    
                                $query = "INSERT INTO plan VALUES( '$plan','$costo', '$min_destino','$velocidad')";
                                $result = $conexion->query($query);

                            if (!$result) die ("Falló registro");
                            header('location: Cargar_Informe.php');          
                        }
                    }else{
                    echo <<<_END
                    <div id="openModal" class="modalDialog">
                        <div>
                            <form id ="principal" method="post" action="Registrar_InformePlan.php" >
                            <h2>Registro De Planes</h2>
                                <input class = "input1" type="text" name="Plan" placeholder="PLAN (Plan30)">
                                <input type="number" name="costo" placeholder="COSTO">
                                <select name="min_destino" size="1">
                                    <option value="elimitado">ELIMITADO</options>
                                    <option value="limitado">LIMITADO</options>
                                </select>
                                <input class = "input1" type="text" name="velocidad" placeholder="VELOCIDAD (3MB)">
                                <input id ="registrar" type="submit" value = "Registrar">
                                <a id ="vuelver" href='Cargar_Informe.php'>Volver Anterior</a>
                            </form>
                        </div>
                    </div>
                _END;
                
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
                <h1>Lista de Planes</h1> 
                <a href='Registrar_InformePlan.php' class="nota">Registrar</a>

                <form action="Buscar_Cliente.php" method="get" class="form_seach" >
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
                            <a class="link_edit" href = "Actualizar_Cliente.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Editar</a>
                        </td>                        
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
        </body>
        </html>