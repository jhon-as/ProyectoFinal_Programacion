<!DOCTYPE html>
<html lang = "es">
<head>
<title>Menu</title>
<link rel = "stylesheet" type="text/css" href="Menu.css">
<link rel = "stylesheet" type="text/css" href="PaginaPrincipal.css">
<script src="menu.js"></script>
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
        <li><a href="Servico_Cliente.php">Registro De Servicio</a></li>
        <li><a href="Cargar_Informe.php">Plan / Pago</a></li>

    </ul>
</nav>
<section id="container1">
                <?php

                $buscar = strtolower($_REQUEST['busqueda']);

                if(empty($buscar)){
                    header("location: Cliente_Usuario.php");
                }
                ?>
                <h1>Informe General</h1> 
                <a href='SesionServicio.php' class="nota">Salir</a>

                <form action="Buscar_PaginaPrincipal.php" method="get" class="form_seach" >
                <input type ="text" placeholder="Buscador... " name = "busqueda" id = "busqueda" value="<?php echo $buscar ?> ">
                <input type="submit" value="Buscar" class="btn_search">
                </form>
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
                                    inner join plan as p on s.idPlan = p.idPlan
                                    where(
                                        c.dniClie like '%$buscar%' OR
                                        c.nombClie LIKE '%$buscar%' OR 
                                        c.apelClie LIKE '%$buscar%' OR 
                                        s.numeServ LIKE '%$buscar%'OR 
                                        p.idPlan LIKE '%$buscar%' OR
                                        p.costPan LIKE '%$buscar%' OR
                                        s.fechInicServ LIKE '%$buscar%' OR
                                        s.fechPagoServ LIKE '%$buscar%' 
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

</body>
</html>