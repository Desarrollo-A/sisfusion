<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/pages/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:19 GMT -->
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../../dist/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../../dist/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Ciudad Maderas | Sistema de Contratación</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />
    <!--  Social tags      -->
    <meta name="keywords" content="material dashboard, bootstrap material admin, bootstrap material dashboard, material design admin, material design, creative tim, html dashboard, html css dashboard, web dashboard, freebie, free bootstrap dashboard, css3 dashboard, bootstrap admin, bootstrap dashboard, frontend, responsive bootstrap dashboard, premiu material design admin">
    <meta name="description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template">
    <meta itemprop="description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">
    <meta itemprop="image" content="../../../../s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@creativetim">
    <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template">
    <meta name="twitter:description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">
    <meta name="twitter:creator" content="@creativetim">
    <meta name="twitter:image" content="../../../../s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg">
    <!-- Open Graph data -->
    <meta property="fb:app_id" content="655968634437471">
    <meta property="og:title" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://www.creative-tim.com/product/material-dashboard-pro" />
    <meta property="og:image" content="../../../../s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg" />
    <meta property="og:description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design." />
    <meta property="og:site_name" content="Creative Tim" />
    <!-- Bootstrap core CSS     -->
    <link href="<?=base_url()?>dist/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?=base_url()?>dist/css/material-dashboard.css" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?=base_url()?>dist/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?=base_url()?>dist/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=base_url()?>dist/css/google-roboto-300-700.css" rel="stylesheet" />
    <style>
        .md-form
        {
            margin-bottom: 0rem;
        }
        .error-field
        {
            border-bottom: 1px solid red !important;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">INICIAR SESIÓN</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
				<li class=" active">
					<a href="#">
						<i class="material-icons">lock_outline</i> Login
					</a>
				</li>
                <li class="">
                    <a href="#">
                        <i class="material-icons">settings_backup_restore</i> Recuperar contraseña
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" filter-color="black" data-image="<?=base_url()?>dist/img/img_4.jpeg">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <?=form_open(base_url().'login/new_user')?>
                            <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="goldMaderas">
                                    <h4 class="card-title"><img src="<?=base_url()?>static/images/ciudadmaderas_white_2.png"
																style="width: 70%;margin: 0px;"></h4>
                                </div>
                                <p class="category text-center">
                                    Ingresa tus datos para poder continuar
                                </p>
                                <div class="card-content">
									<div id="msg" style="text-align: center"></div>
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre de usuario</label>
                                            <input type="text" id="usuario" name="usuario" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Contraseña</label>
                                            <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                                            <input type="checkbox" onclick="showPassword()">Mostrar contraseña
                                        </div>
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <?=form_hidden('token',$token)?>
                                    <button type="submit" class="btn btn-green btn-simple btn-wd btn-lg" id="btnEnter">Ingresar</button>
                                    <?=form_close()?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="copyright centered center-block center-align">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="https://www.ciudadmaderas.com/">Ciudad Maderas</a>, Departamento de TI y MKTD
                </p>
            </div>
        </footer>
    </div>
</div>

<?php
if($this->input->get('error')) : ?>
    <script type="text/javascript">
        <?php if($this->input->get('error') == 1) : ?>
        alert("Usuario / Contraseña incorrectos");
        <?php elseif($this->input->get('error') == 2): ?>
        alert("Acces restringido");
        <?php endif; ?>
    </script>
<?php endif; ?>

</body>
<!--   Core JS Files   -->
<script src="<?=base_url()?>dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/material.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?=base_url()?>dist/js/jquery.validate.min.js"></script>
<!-- TagsInput Plugin -->
<script src="<?=base_url()?>dist/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?=base_url()?>dist/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?=base_url()?>dist/js/demo.js"></script>

<script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>

<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

<script>
    <?php
    if($this->session->userdata('errorLogin') == 33)
    {
    $this->session->unset_userdata('errorLogin');
    ?>
    $(function () {
        $('#msg').append('Datos incorrectos, verifica e intenta de nuevo');
        $('#msg').css('color', 'red');
        $('#usuario').addClass('animated shake error-field');
        $('#contrasena').addClass('animated shake error-field');
    });
    $(document).ready(function () {
        setTimeout(function(){
            console.log('adioooss');
            $('#msg').html('');
            $('#msg').css('color', 'black');
            $('#msg').fadeOut();
            $('#usuario').removeClass('animated shake error-field');
            $('#contrasena').removeClass('animated shake error-field');
        }, 2500);
    });
    <?php
    }
    ?>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });

    setTimeout(function() { $("#aviso").hide(); }, 3000);
</script>
<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/pages/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:19 GMT -->
</html>
