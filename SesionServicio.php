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
                require_once 'PaginaPrincipal.php';//Archivo donde se almacenara nuestro diario 
                //echo 'Bienvenido Administrador';
            }
            else{
                echo <<<_END
                 Contraseña mal Administrador
                _END;
           }

        }else{
;
            $query = "SELECT * FROM rol_usuario WHERE rol='$rol' AND dni='$dni' AND contrasena = '$pass'";

            $result = $conexion->query($query);
            if ($result->num_rows >= 1){
                //require_once 'anotar.php';//Archivo donde se almacenara nuestro diario 
                echo 'Bienvenido Cliente';
            }
            else{
                echo <<<_END
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Contraseña Invalida</title>
                    <link rel = "stylesheet" type="text/css" href="estilo_ayuda.css">
                </head>
                <body>
                 Contraseña mal Cliente 
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