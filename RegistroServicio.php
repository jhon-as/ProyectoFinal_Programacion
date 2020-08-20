<!DOCTYPE html>
    <html>
    <head>
            <title>Registro </title>
            <link rel = "stylesheet" type="text/css" href="EstiloRegistro.css">
    </head>
    <body>
        <?php
        require_once 'login.php';
        $conexion = new mysqli($hn, $un, $pw, $db);
                        
        if ($conexion->connect_error) die ("Fatal error");

        if(!empty($_POST['rol']) && !empty($_POST['dni']) && !empty($_POST['nombre']) && !empty($_POST['apellido'])
        && !empty($_POST['telefono']) && !empty($_POST['pass'])){ 

            if(isset($_POST['rol']) && isset($_POST['dni']) && isset($_POST['nombre']) && isset($_POST['apellido'])
               && isset($_POST['telefono']) && isset($_POST['pass']))
            {
                $rol = mysql_fix_string($conexion, $_POST['rol']);
                $dni = mysql_fix_string($conexion, $_POST['dni']);
                $nombre = mysql_fix_string($conexion, $_POST['nombre']);
                $apellido =mysql_fix_string($conexion, $_POST['apellido']);
                $telefono = mysql_fix_string($conexion, $_POST['telefono']);
                $pass=md5($_POST['pass']);
        
                $query = "INSERT INTO rol_usuario VALUES( '$dni','$rol', '$nombre','$apellido','$pass','$telefono')";
                $query2 = "INSERT INTO cliente VALUES('$dni','$nombre','$apellido','$telefono')";
                $result = $conexion->query($query);
                $result2 = $conexion->query($query2);
                if (!$result && !$result2) die ("Falló registro");
                echo <<<_END
                <!DOCTYPE html>
                <html>
                <head>
                <title>Registrado </title>
                <link rel = "stylesheet" type="text/css" href="EstiloRegistro.css">
                </head>
                <body>
                <h1>Registrado</h1>
                <form id ="principal" method="post" action="RegistroServicio.php" >
                   <select name="rol" size="1">
                        <option value="cliente">CLIENTE</options>
                        <option value="administrador">ADMINISTRADOR</options>
                    </select>
                    <input type="text" name="dni" placeholder="DNI">
                    <input type="text" name="nombre" placeholder="NOMBRE">
                    <input type="text" name="apellido" placeholder="APELLIDO">
                    <input type="text" name="telefono" placeholder="TELEFONO">
                    <input type="password" name="pass" placeholder="CONTRASEÑA">
                    <input type="hidden" name="reg" value="yes">
                    <input id ="inicio" type="submit" value = "Registrar">
                    <a id ="cuenta" href='SesionServicio.php'>Iniciar Sesion</a>
                </form>
                
                </body>
                </html>
                _END;
                
            }
        }else{
        ?>
        <h1>Registro De Usuarios</h1>
        <form id ="principal" method="post" action="RegistroServicio.php" >
           <select name="rol" size="1">
                <option value="cliente">CLIENTE</options>
                <option value="administrador">ADMINISTRADOR</options>
            </select>
            <input type="text" name="dni" placeholder="DNI">
            <input type="text" name="nombre" placeholder="NOMBRE">
            <input type="text" name="apellido" placeholder="APELLIDO">
            <input type="text" name="telefono" placeholder="TELEFONO">
            <input type="password" name="pass" placeholder="CONTRASEÑA">
            <input type="hidden" name="reg" value="yes">
            <input id ="inicio" type="submit" value = "Registrar">
            <a id ="cuenta" href='SesionServicio.php'>Iniciar Sesion</a>
        </form>
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
                                      