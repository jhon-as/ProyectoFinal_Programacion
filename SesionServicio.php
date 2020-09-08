<!DOCTYPE html>
    <html>
    <head>
            <title>Servicios </title>
            <link rel = "stylesheet" type="text/css" href="EstiloSesion.css">
    </head>
    <body>

    <?php
        require_once 'login.php';
        $conexion = new mysqli($hn, $un, $pw, $db);
                        
        if ($conexion->connect_error) die ("Fatal error");

    if(isset($_POST['rol']) && isset($_POST['dni']) && isset($_POST['pass']))
    {
        $rol = mysql_fix_string($conexion, $_POST['rol']);
        $dni = mysql_fix_string($conexion, $_POST['dni']);
        $pass = md5($_POST['pass']);

        if('administrador' ==  $rol){

            $query = "SELECT * FROM rol_usuario WHERE rol='$rol' AND dni='$dni' AND contrasena = '$pass' ";

            $result = $conexion->query($query);
            if ($result->num_rows >= 1){
                header("location: PaginaPrincipal.php");
            }
            else{
                echo <<<_END
                <!DOCTYPE html>
                <html>
                <head>
                <title>Servicios </title>
                <link rel = "stylesheet" type="text/css" href="EstiloSesion.css">
                <link rel = "stylesheet" type="text/css" href="modalSesion.css">
                </head>
                <body>
                    <h1>Servicio de Internet LIFINET</h1>
                    <h2>Bienvenido a esta página</h2>
                <div id = "contenedor">
                        <h3>Descripción de la empresa</h3>
                        <p>La empresa de telecomunicaciones “lifinet” brinda servicio de internet 
                        a domicilio para cada cliente que desea una conexión de internet fiable 
                        a su alcance de su economía, la empresa brinda servicios de internet 
                        inalámbrica una distribución de punto a punto para los clientes en lugares 
                        donde no llegan las empresas más grandes como es el caso de fibra óptica de 
                        movistar la cual esta empresa llamada lifinet brinda servicios a los lugares 
                        inaccesibles ya sean urbanizaciones tanto rurales como urbanos.</p>
                </div>
                <div id ="principal">
                <form method="post" action="SesionServicio.php">
                    <select name="rol" size="1">
                        <option value="cliente">CLIENTE</options>
                        <option value="administrador">ADMINISTRADOR</options>
                    </select>
                    <input type="text" name="dni" placeholder="DNI">
                    <input type="password" name="pass" placeholder="Contraseña">
                    <input id ="inicio" type="submit" value = "Iniciar sesión">
                    <a id ="a_segundo" href='#'>¿Olvidaste tu contraseña?</a>
                </form>
                <a id ="cuenta" href='RegistroServicio.php'>Crear cuenta nueva</a>
                </div>
                <div id="openModal" class="modalDialog">
                    <div>
                        <h3 class = "hb">DNI o Contraseña</h3>
                        <h3 class = "hb">Esta mal Registrado</h3>
                        <p id ="pj">Haz click en (Intentar Nuevamente) para empezar</p>
                        <a href="SesionServicio.php" id = 'alo'>Intentar Nuevamente</a>
                    </div>
                </div>
                </body>
                </html>
                _END;
           }

        }else{
            $query = "SELECT * FROM rol_usuario WHERE rol='$rol' AND dni='$dni' AND contrasena = '$pass'";

            $result = $conexion->query($query);
            if ($result->num_rows >= 1){
                //CLIENTE ESTARA AQUI
            ?>    
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Lifinet </title>
                    <link rel = "stylesheet" type="text/css" href="Cliente.css">
                </head>
                <body>
                    <nav>
                        <img src="logos.gif" width="190 " height="150">
                        <h4>Lifinet</h4>
                    </nav>    
                    <section id="container1">
                    <h5>Bienvenido </h5>
                    </section>
                    <section id="container2"> 
                            <?php
                                require_once 'login.php';
                                $conexion = new mysqli($hn, $un, $pw, $db);
                            
                                if ($conexion->connect_error) die ("Fatal error");

                                $query  =   "SELECT c.dniClie , c.nombClie, c.apelClie , s.numeServ,
                                            p.idPlan, p.costPan, p.minutDestPlan, p.BMPlan,s.fechInicServ, 
                                            s.fechPagoServ
                                            from cliente_servicio as cs 
                                            inner join cliente as c on cs.dniClie = c.dniClie
                                            inner join servicio as s on cs.numeServ = s.numeServ
                                            inner join plan as p on s.idPlan = p.idPlan
                                            where c.dniClie = $dni";

                                $result = $conexion->query($query);
                                if (!$result) die ("Consulta falló");

                                $filas = $result->num_rows;

                                for ($j = 0; $j < $filas; $j++){

                                    $fila = $result->fetch_array(MYSQLI_NUM);

                                        $r0 =  htmlspecialchars($fila[0]);  
                                        $r1 =  htmlspecialchars($fila[1]);  
                                        $r2 =  htmlspecialchars($fila[2]);
                                        $r3 =  htmlspecialchars($fila[3]);  
                                        $r4 =  htmlspecialchars($fila[4]);
                                        $r5 =  htmlspecialchars($fila[5]); 
                                        $r6 =  htmlspecialchars($fila[6]);
                                        $r7 =  htmlspecialchars($fila[7]); 
                                        $r8 =  htmlspecialchars($fila[8]);
                                        $r9 =  htmlspecialchars($fila[9]); 

                                        echo <<<_END
                                        <article id = "Informe">
                                        <p id = "comentario"> Felicidades Estimado cliente <b>$r1</b> <b>$r2</b>, usted ha sido
                                        proveedo con el  <b>$r4</b> que cuenta con los seguientes paquetes <br> </p>
                                        </article>
                                        <article id = "paquetes">
                                        <p class = "letra">  <b>SERVICIO:</b>  $r3 </p>
                                        <p class = "letra">  <b>PLAN:</b> $r4 </h6> 
                                        <p class = "letra">  <b>MINUTOS TODO DESTINO:</b> $r6</p> 
                                        <p class = "letra">  <b>VELOCIDAD:</b> $r7</p>
                                        <p class = "letra">  <b>COSTO:</b> $r5</p>
                                        </article>
                                        <article id = "raya">
                                        </article>
                                        <article id = "Informe_personal">
                                        <p class = "letra"> <b>NOMBRE:</b> $r1   </p>
                                        <p class = "letra"> <b>APELLIDO:</b> $r2   </p>
                                        <p class = "letra"> <b>DNI:</b> $r0   </p>
                                        <p class = "letra">  <b>FECHA DE INICIO:</b> $r8 </p> 
                                        <p class = "letra">  <b>FECHA A PAGAR:</b> $r9 </p> 
                                        </article>           
                                        _END;
                                }        
                            ?>
                    </section>
                    <section id="container3">
                    <a href='SesionServicio.php' class="nota">Salir</a>
                    <p id = "jhon">jhon@stuchao</p>
                    </section>
                </body>
                </html>
            <?php    
            }
            else{
                echo <<<_END
                <!DOCTYPE html>
                <html>
                <head>
                <title>Servicios </title>
                <link rel = "stylesheet" type="text/css" href="EstiloSesion.css">
                <link rel = "stylesheet" type="text/css" href="ModalSesion.css">
                </head>
                <body>
                    <h1>Servicio de Internet LIFINET</h1>
                    <h2>Bienvenido a esta página</h2>
                <div id = "contenedor">
                        <h3>Descripción de la empresa</h3>
                        <p>La empresa de telecomunicaciones “lifinet” brinda servicio de internet 
                        a domicilio para cada cliente que desea una conexión de internet fiable 
                        a su alcance de su economía, la empresa brinda servicios de internet 
                        inalámbrica una distribución de punto a punto para los clientes en lugares 
                        donde no llegan las empresas más grandes como es el caso de fibra óptica de 
                        movistar la cual esta empresa llamada lifinet brinda servicios a los lugares 
                        inaccesibles ya sean urbanizaciones tanto rurales como urbanos.</p>
                </div>
                <div id ="principal">
                <form method="post" action="SesionServicio.php">
                    <select name="rol" size="1">
                        <option value="cliente">CLIENTE</options>
                        <option value="administrador">ADMINISTRADOR</options>
                    </select>
                    <input type="text" name="dni" placeholder="DNI">
                    <input type="password" name="pass" placeholder="Contraseña">
                    <input id ="inicio" type="submit" value = "Iniciar sesión">
                    <a id ="a_segundo" href='#'>¿Olvidaste tu contraseña?</a>
                </form>
                <a id ="cuenta" href='RegistroServicio.php'>Crear cuenta nueva</a>
                </div>
                <div id="openModal" class="modalDialog">
                    <div>
                        <h3 class = "hb">DNI o Contraseña</h3>
                        <h3 class = "hb">Esta mal Registrado</h3>
                        <p id ="pj">Haz click en (Intentar Nuevamente) para empezar</p>
                        <a href="SesionServicio.php" id = 'alo'>Intentar Nuevamente</a>
                    </div>
                </div>
                </body>
                </html>
                _END;
           }
        } 
    }
    else{
        ?>
        <h1>Servicio de Internet LIFINET</h1>
        <h2>Bienvenido a esta página</h2>
        <div id = "contenedor">
        <h3>Descripción de la empresa</h3>
        <p>La empresa de telecomunicaciones “lifinet” brinda servicio de internet 
        a domicilio para cada cliente que desea una conexión de internet fiable 
        a su alcance de su economía, la empresa brinda servicios de internet 
        inalámbrica una distribución de punto a punto para los clientes en lugares 
        donde no llegan las empresas más grandes como es el caso de fibra óptica de 
        movistar la cual esta empresa llamada lifinet brinda servicios a los lugares 
        inaccesibles ya sean urbanizaciones tanto rurales como urbanos.</p>

        </div>
        <div id ="principal">
        <form method="post" action="SesionServicio.php">
            <select name="rol" size="1">
                <option value="cliente">CLIENTE</options>
                <option value="administrador">ADMINISTRADOR</options>
            </select>
            <input type="text" name="dni" placeholder="DNI">
            <input type="password" name="pass" placeholder="Contraseña">
            <input id ="inicio" type="submit" value = "Iniciar sesión">
            <a id ="a_segundo" href='#'>¿Olvidaste tu contraseña?</a>
        </form>
        <a id ="cuenta" href='RegistroServicio.php'>Crear cuenta nueva</a>
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
     </body>
    </html>