<!doctype html>
<html lang="en">
  <head>
  	<title>Login 01</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/login.css">
    <!--TOASTER-->
    <link href="css/toastr.min.css" rel="stylesheet">
    <!--quitar validacion de check en formulario-->
    <link href="css/validacionForm.css" rel="stylesheet">
    

	</head>
    <h1 style="color:#fff;font-size:22px;padding:20px">Este Sistema no esta disponible en móvil :c<h1>

	<body style="background:#4B4341">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 style="visibility: hidden;" class="heading-section">Administración de Empresas</h2>
				</div>
			</div>
			<div style="position: relative;<?php if(isset($_GET['loguearse'])){
            echo '';
            }else{
                echo 'bottom:3rem;';
            }   
            ?>" class="row justify-content-center">
				<div style="margin-bottom:3.1rem;" class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div style="background-color:#343a40;" class="icon d-flex align-items-center justify-content-center">
		      		<span class="fa fa-user-o"></span>
		      	</div>
		      	<h3 class="text-center mb-4">Bienvenido</h3>
                  <form id="formLoguear" method="POST" class="login-form needs-validation" novalidate data-offset="70" >
                    <div class="form-group">
                        <input type="text" name="usuario" id="usuario" class="form-control rounded-left" placeholder="Usuario" required>
                        <div class="invalid-feedback d-none">
                            Escriba su usuario
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" name="contrasena" id="contrasena" class="form-control rounded-left" placeholder="Contraseña" required>
                        <div class="invalid-feedback d-none">
                            Escriba su contraseña
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="btnLoguear" style="width: 22rem; height:3rem;" name="loguearse" type="submit" class=" btn btn-dark rounded px-3">Iniciar Sesión</button>
                    </div>
                    <div class="form-group d-md-flex">
                        <div class="w-50">
                            <label style="visibility:hidden;" class="checkbox-wrap checkbox-primary">Remember Me
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div style="visibility:hidden;" class="w-50 text-md-right">
                            <a href="#">Forgot Password</a>
                        </div>
                    </div>
                    <div class="toast-container"></div>
                </form>
	        </div>
				</div>
			</div>
		</div>
	</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<!--Validaciones formulario-->
<script src="js/validarFormulario.js"></script>
<script src="js/controlador.js"></script>
<!--Toaster-->
<script src="js/toastr.min.js"></script>
<!-- Axios js-->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</body>
</html>

