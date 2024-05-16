<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Reporting Service</title>
    <link rel="icon" href="../img/nivelesIcon.ico">
    <link href="../css/reportes.css" rel="stylesheet" type="text/css">
    <link href="style/EstiloCuentas.css" rel="stylesheet" type="text/css">
</head>

<body>


    <?php
        //Conexion 
        include_once '../../erpApi/conexion/bd_directa.php';
        //llegada de datos
        $id_empresa = $_GET['id_empresa'];

        $qry = "SELECT nombre_empresa FROM empresas WHERE id_empresa = $id_empresa";
        $run = $conexion -> query($qry);
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_empresa=$row['nombre_empresa'];
            }
        } 

        date_default_timezone_set('America/La_Paz');
        $fecha_actual = date('d/m/Y');
    ?>



<nav>
        <div class="tituloNav"> 
            <div class="tituloPrincipal ">
                <img class="logoNav" src="../img/reportService.PNG">
                <img class="textoNav" src="../img/tituloReporting.png">
            </div>
            <div class="tituloSecundario">
                <hr class="Tiv">
                <div>
                    <img class="ajuste" src="../img/configuraciones.png">
                </div>
                <hr class="Tiv">
                <div>
                    <img class="descarga" src="../img/descargarIcon.png">
                </div>
                <hr class="Tiv">
                <div>
                    <img class="signo" src="../img/signoInterrogacion.png">
                </div>
                <hr class="Tiv">
                <div>
                    <span class="nombre">Cesar</span>
                </div>
                
            </div>
        </div>
        <div class="subtituloNav">
            <div class="PrimeraParte">
                <div class="ParteFavoritos">
                    <img class="estrella" src="../img/estrella.png">
                    <span class="favorito">Favoritos</span>
                </div>
                <div class="ParteExaminar">
                    <img class="cuaderno" src="../img/cuaderno.png">
                    <span class="examinar">Examinar</span>
                </div>
            </div>
            <div class="SegundoParte">
                <div class="Partecomentario">
                    <img class="globo" src="../img/comentario.png">
                    <span class="comentario">Comentarios</span>
                </div>
            </div>
        </div>
        <div class="tertituloNav">
            <span class="inicioText">Inicio</span>
            <img class="flecha_gris"src="../img/flecha_derecha_gris.png">
            <span class="EmpresaErp">report</span>
            <img class="flecha_gris"src="../img/flecha_derecha_gris.png">
            <span class="Nombre_Reporte">reporteCuentas</span> <!--Este el nombre del reporte puede ser cambiado-->
        </div>
        <div class="contenido-funciones">
            <div class="funcionesPrincipales">
                <div class="flechaRetroceder">
                    <img class="flecha_Retroceder" src="../img/reportes_flecha_izquierda.png">
                </div>
                <div class="flechaIzquierda">
                    <img class="flecha_Izquierda" src="../img/flecha_izquierda.png">
                </div>
                <div class="Cantidadpaginas">
                    <input style="width: 3rem;border: 1px solid #b7b3b0; " class="Npagina" value="1" readonly >
                    <span style="padding-left: 5px;">de <span style="padding-left: 3.5px;">1</span></span>
                </div>
                <div class="flechaDerecha">
                    <img class="flecha_Derecha" src="../img/flecha_derecha.png">
                </div>
                <div class="flechaAdelantar">
                    <img class="flecha_Adelantar" src="../img/reportes_flecha_derecha.png">
                </div>
            </div>
            <div class="skill actualizar" style="display: flex;flex-direction: row;">
                <hr style="margin-left: 20px;" class="vertical-line">
                <div style="margin-left:5px;" class="tootlip">
                    <img style="position: relative;right: 4px;" class="flecha_Actualizar" src="../img/flecha_actualizar.png">
                    <h3 style="margin-top:5.5rem;visibility:hidden;">Actualizar</h3>
                </div>
                <hr style="margin-left:5px;" class="vertical-line">
            </div>
            <div class="retroceso">
                <img class="retro" src="../img/flecha_avanzada.png">
            </div>
            <div style="display: flex;flex-direction: row;" class="zoom">
                <hr style="margin-left: 20px;" class="vertical-line">
                <select style="width: 9rem;border: 1px solid #b7b3b0; height: 20px;position: relative;left:10px;top:20px;" name="refZoom" id="refZoom">
                    <option>Ancho de la página</option>
                    <option>Toda la página</option>
                    <option>500%</option>
                    <option>200%</option>
                    <option>150%</option>
                    <option selected>100%</option>
                    <option>75%</option>
                    <option>50%</option>
                    <option>25%</option>
                    <option>10%</option>
                </select>
                <hr style="margin-left: 20px;" class="vertical-line">
            </div>

            <div class="container">
                <div class="guardado" onclick="toggleDropdown(event)">
                    <img class="guardadoSelect" src="../img/guardar_caset.png" alt="Guardar">
                    <img class="flechaAbajo" src="../img/flecha_abajo.png">
                    <div id="dropdown" class="dropdown-content">
                        <a href="#">Word</a>
                        <a href="#">Excel</a>
                        <a href="#">PowerPoint</a>
                        <a href="cuentas/pdf_cuentas.php?id_empresa=<?php echo $id_empresa; ?>">PDF</a>
                        <a href="#">Archivo TIFF</a>
                        <a href="#">MHTML (archivo web)</a>
                        <a href="#">CSV (delimitado por comp...)</a>
                        <a href="#">Fuente de datos</a>
                    </div>
                </div>
            
                <div class="impresora">
                    <hr class="vertical-line">
                    <a href="#" onclick="showPdfPreview('cuentas/pdf_preview_cuentas.php?id_empresa=<?php echo $id_empresa; ?>')"><img class="imprimir" src="../img/impresora.png"></a>
                    <hr class="vertical-line">
                </div>
                <div id="pdfModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:100;">
                    <iframe id="pdfPreview" style="position:relative; top:10%; left:10%; width:80%; height:80%; border:1px solid #ccc;"></iframe>
                </div>


                <div class="busqueda">
                    <input style="width: 6.8rem; border: 1px solid #b7b3b0;position: relative;padding-left: 3.5px;"class="InputBuscar">
                    <span style="color:#b7b3b0;cursor: pointer;" class="Buscar">Buscar</span>
                    <span style="color:#b7b3b0;" class="separetor">|</span>
                    <span style="color:#b7b3b0;cursor: pointer;" class="next">Siguiente</span>
                </div>

            </div>
            
            
        </div>

    </nav>

    <article>
        <div class="contenedor">
            <div class="titulo">
                <h1>Reporte de Plan de Cuentas</h1>
                <h2>Empresa: <?php echo $nombre_empresa; ?> </h2>
            </div>
            <div class="subtitulos">
                <h3>Fecha Rep:<?php echo $fecha_actual ?></h3>
                <h3>Usuario: Administrador</h3>
            </div>
        
            <?php

            function mostrarCuentas($conexion, $id_empresa, $id_cuenta_padre = null, $nivel = 0) {
                // Preparar la consulta SQL
                $sql = "SELECT * FROM cuentas WHERE id_empresa_cuenta = $id_empresa ";
                $sql .= is_null($id_cuenta_padre) ? "AND (id_cuenta_padre IS NULL OR id_cuenta_padre = 0) " : "AND id_cuenta_padre = $id_cuenta_padre ";
                $sql .= "ORDER BY codigo";

                // Ejecutar la consulta
                $result = mysqli_query($conexion, $sql);
                
                // Si no se encuentran cuentas, salir de la función
                if (mysqli_num_rows($result) == 0) {
                    return;
                }

                // Para cada cuenta encontrada...
                while ($row = mysqli_fetch_assoc($result)) {?>

                    <span class="cuentas"><?php echo str_repeat('&nbsp;', $nivel * 4) . $row['codigo'] . ' ' . $row['nombre_cuenta'] . "<br/>\n";?></span>
                    <?php
                    // ...y luego buscar y mostrar sus subcuentas
                    mostrarCuentas($conexion, $id_empresa, $row['id_cuenta'], $nivel + 1);
                }
            }

            mostrarCuentas($conexion, $id_empresa);
            ?>
        </div>
    </article>


    <script src="../js/imprimir.js"></script>
    <script src="../js/reporte.js"></script>
    
    <script src="pdfjs/build/pdf.js"></script>
    <script src="pdfjs/web/viewer.js"></script>
    
</body>
</html>