<!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes </title>
            <link rel = "stylesheet" type="text/css" href="Menu.css">
            <link rel = "stylesheet" type="text/css" href="Cargar_Informe.css">
            <link rel = "stylesheet" type="text/css" href="Registrar_CargarInforme.css">
            <script src="menu.js"></script>
        </head>
        <body>
        <?php
                    require_once 'login.php';
                    $conexion = new mysqli($hn, $un, $pw, $db);
                                    
                    if ($conexion->connect_error) die ("Fatal error");

                    if(!empty($_POST['id']) && !empty($_POST['fecha_pago']) && !empty($_POST['pago']) && !empty($_POST['dni']) && !empty($_POST['plan'])
                    && !empty($_POST['Server'])){ 

                        if(isset($_POST['id']) && isset($_POST['fecha_pago']) && isset($_POST['pago']) && isset($_POST['dni']) && isset($_POST['plan'])
                        && isset($_POST['Server']))
                        {
                            $id =  $_POST['id'];
                            $fecha_pago =  $_POST['fecha_pago'];
                            $pago = $_POST['pago'];
                            $dni =  $_POST['dni'];
                            $plan = $_POST['plan'];
                            $Server = $_POST['Server'];

                            $query = "INSERT INTO informe VALUES('$id', '$fecha_pago' , '$pago', ' $dni' ,'$plan', '$Server')";
                            $result = $conexion->query($query);

                            if (!$result) die ("Falló registro");
                            header('location: Cargar_Informe.php');          
                        }
                    }else{
                    ?>
                    <div id="openModal" class="modalDialog">
                        <div>
                            <form id ="principal" method="post" action="Registrar_CargarInforme.php" >
                            <h2>Registro De Pagos</h2>
                                <input type="text" name="id" placeholder="Identificador de pago">
                                <input type="date" name="fecha_pago" placeholder="FECHA">
                                <input type="number" name="pago" placeholder="COSTO">
                                <input type="text" name="dni" placeholder="DNI DEL CLIENTE" >
                                <input type="text" name="plan" placeholder="PLAN">
                                <input type="text" name="Server" placeholder="SERVICIO">
                                <input id ="registro" type="submit" value = "Registrar">
                                <a id ="vuelve" href='Cargar_Informe.php'>Volver Anterior</a>
                            </form>
                            <section id="container2">
                                <h1>Informe General</h1> 
                                <table>
                                    <tr>
                                        <th>DNI</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>SERVICIO</th>
                                        <th>PLAN</th>
                                        <th>COSTO</th>
                                        <th>FECHA DE INICIO</th>
                                        <th>FECHA A PAGAR</th>
                                    </tr>
                                    <?php
                                        require_once 'login.php';
                                        $conexion = new mysqli($hn, $un, $pw, $db);
                                    
                                        if ($conexion->connect_error) die ("Fatal error");

                                        $query = "SELECT c.dniClie, c.nombClie, c.apelClie, s.numeServ,
                                                    p.idPlan, p.costPan, s.fechInicServ, s.fechPagoServ
                                                    from cliente_servicio as cs 
                                                    inner join cliente as c on cs.dniClie = c.dniClie
                                                    inner join servicio as s on cs.numeServ = s.numeServ
                                                    inner join plan as p on s.idPlan = p.idPlan";

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
                                        <td><?php echo htmlspecialchars($fila[6]); ?></td>
                                        <td><?php echo htmlspecialchars($fila[7]); ?></td>                        
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
                <a href='Registrar_Cliente.php' class="nota">Registrar</a>

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
                            <a class="link_edit" href = "Actualizar_Cliente.php?id=<?php echo htmlspecialchars($fila[0]); ?>">Eliminar</a>
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