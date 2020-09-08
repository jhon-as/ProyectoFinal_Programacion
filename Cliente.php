<!DOCTYPE html>
        <html>
        <head>
            <title>Lifinet </title>
        </head>
        <body>
            <nav>
              <h1>Lifinet</h1> 
            </nav>
            <section id="container1">
            </section>
            <section id="container2"> 
                <a href='SesionServicio.php' class="nota">Salir</a>
                <table>
                    <tr>
                        <th>DNI</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>SERVICIO</th>
                        <th>COSTO</th>
                        <th>FECHA DE INICIO</th>
                        <th>FEECHA A PAGAR</th>
                    </tr>
                    <?php
                        require_once 'login.php';
                        $conexion = new mysqli($hn, $un, $pw, $db);
                    
                        if ($conexion->connect_error) die ("Fatal error");

                        $query  =   "SELECT c.dniClie , c.nombClie, c.apelClie , s.numeServ,
                                    p.idPlan, p.costPan,s.fechInicServ, s.fechPagoServ
                                    from cliente_servicio as cs 
                                    inner join cliente as c on cs.dniClie = c.dniClie
                                    inner join servicio as s on cs.numeServ = s.numeServ
                                    inner join plan as p on s.idPlan = p.idPlan
                                    where c.dniClie = Identicacion";

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
                        <td><?php echo htmlspecialchars($fila[6]); ?></td>                        
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </section>
            <section id="container3">
            </section>
        </body>
        </html>