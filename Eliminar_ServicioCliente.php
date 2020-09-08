<!DOCTYPE html>
        <html>
        <head>
            <title>Lista de Clientes </title>
            <link rel = "stylesheet" type="text/css" href="Menu.css">
            <link rel = "stylesheet" type="text/css" href="Servicio_Cliente.css">
            <link rel = "stylesheet" type="text/css" href="Eliminar_Cliente.css">
            <script src="menu.js"></script>
        </head>
        <body>
        <?php 
                require_once 'login.php';
                $conexion = new mysqli($hn, $un, $pw, $db);

                if ($conexion->connect_error) die ("Fatal error");

                if (isset($_POST['idServi']))
                {
                    $idServi = $_POST['idServi'];

                        $query = "DELETE FROM cliente_servicio WHERE numeServ = '$idServi'";
                        $result = $conexion->query($query);

                        $query2  = "DELETE FROM servicio WHERE numeServ = '$idServi'";
                        $result2 = $conexion->query($query2);

                        header('location: Servico_Cliente.php');
                    if (!$result || !$result2) echo "UPDATE falló <br><br>";
                }

                if(empty($_GET['id'])){
                    header('location: Servico_Cliente.php');
                }
                $idServi = $_GET['id'];

                echo <<<_END
                    <div id="openModal" class="modalDialog">
                        <div>
                            <form id ="principal" method="post" action="Eliminar_ServicioCliente.php" >
                            <h2>¿Desea eliminar?</h2>
                                <input type="hidden" name="idServi" value = "$idServi">
                                <input id ="inicio" type="submit" value = "Eliminar">
                                <a id ="cuenta" href='Servico_Cliente.php'>Volver Anterior</a>
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
                    <li><a href="Servico_Cliente.php">Registro De Servicio</a></li>
                    <li><a href="Cargar_Informe.php">Plan / Pago</a></li>
                </ul>
            </nav>
            <section id="container1">
                <h1>Lista de Usuarios</h1> 
                <a href='Registrar_ServicioCliente.php' class="nota">Registrar</a>

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
                            <a class="link_edit" href = "Actualizar_ServicioCliente.php?id=<?php echo htmlspecialchars($fila[1]); ?>">Editar</a>
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