<!doctype html>
<html lang="es_mx"  ng-app="CRM">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../dist/img/apple-icon.png" />
<!--    <link rel="icon" type="image/png" href="../dist/img/favicon.png" />-->
    <link rel='shortcut icon' type='image/x-icon' href='<?=base_url()?>static/images/img.ico' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>MaderasCRM | Ciudad Maderas</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Canonical SEO -->
    <!--  Social tags      -->
        <!--  -->  <meta name="keywords" content="Sistema de administracion de procesos internos Ciudad Maderas MaderasCRM &reg;">
        <!---->    <meta name="description" content="Sistema de administracion de procesos internos Ciudad Maderas MaderasCRM &reg;">
    <!-- Schema.org markup for Google+ -->
        <!--    <meta itemprop="name" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template">-->
        <!--    <meta itemprop="description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">-->
        <!--    <meta itemprop="image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg">-->
    <!-- Twitter Card data -->
        <!--    <meta name="twitter:card" content="summary_large_image">-->
        <!--    <meta name="twitter:site" content="@creativetim">-->
        <!--    <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template">-->
        <!--    <meta name="twitter:description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">-->
        <!--    <meta name="twitter:creator" content="@creativetim">-->
        <!--    <meta name="twitter:image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg">-->
    <!-- Open Graph data -->
        <!--    <meta property="fb:app_id" content="655968634437471">-->
        <!--    <meta property="og:title" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template" />-->
        <!--    <meta property="og:type" content="article" />-->
        <!--    <meta property="og:url" content="http://www.creative-tim.com/product/material-dashboard-pro" />-->
        <!--    <meta property="og:image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg" />-->
        <!--    <meta property="og:description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design." />-->
        <!--    <meta property="og:site_name" content="Creative Tim" />-->
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
        #canvas {
           border: 1px solid black;
           position: absolute;
           z-index: 10000;
        }

       #flake {
           color: #fff;
           position: absolute;
           font-size: 25px;
           top: -50px;
           z-index: 99999999999999999;
       }

       #page {
           position: relative;
       }
    </style>
</head>

<body>
<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <!-- <div class="navbar-header">
            <a class="navbar-brand" href="#">INICIAR SESIÓN</a>
        </div> -->
        <div class="collapse navbar-collapse hide">
            <ul class="nav navbar-nav navbar-right">
				<!--<li class=" active">
					<a href="#">
						<i class="material-icons">lock_outline</i> Login
					</a>
				</li>

                <li class="">
                    <a href="#">
                        <i class="material-icons">settings_backup_restore</i> Recuperar contraseña
                    </a>
                </li>-->


            </ul>
        </div>
    </div>
</nav>

    <div class="wrapper wrapper-full-page"  id="divSnow"><!--id="divSnow"-->
        <div class="full-page login-page" filter-color="black" data-image="<?=base_url()?>dist/img/banner-principal-terrenos-ciudad-maderas.webp">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                                <?=form_open(base_url().'login/new_user')?>
                                    <div class="card card-login card-hidden">
                                        <!-- <img src="<?=base_url()?>static/images/gorro_navideno.png" width="50px" style="    position: absolute;top: -21%;width: 85px;z-index: 99;left: -4%;"> -->
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
                                            <button type="submit" class="btn btn-green btn-simple btn-wd btn-lg" id="btnEnter">INGRESAR</button>
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
                            <a href="https://www.ciudadmaderas.com/">Ciudad Maderas</a>, Departamento de TI
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
<!-- <div id="flake">&#10052;</div> -->
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
<script src="<?=base_url()?>dist/js/material-dashboard2.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?=base_url()?>dist/js/demo.js"></script>


<script type="text/javascript">
    $(document).ready(function() {

        $('#usuario').focus();
        
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);

        localStorage.removeItem('auth-google-token');
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

<!--snow-->
<script>
                var t = setInterval(
                function () {
                    var documentHeight = $(document).height();
                    var startPositionLeft = Math.random() * $(document).width() - 100;
                    var startOpacity = 0.5 + Math.random();
                    var sizeFlake = 10 + Math.random() * 20;
                    var endPositionTop = documentHeight - 40;
                    var endPositionLeft = startPositionLeft - 100 + Math.random() * 200;
                    var durationFall = documentHeight * 10 + Math.random() * 5000;
                    $('#flake')
                        .clone()
                        .appendTo('body')
                        .css(
                            {
                                left: startPositionLeft,
                                opacity: startOpacity,
                                'font-size': sizeFlake
                            }
                        )
                        .animate(
                            {
                                top: endPositionTop,
                                left: endPositionLeft,
                                opacity: 0.2
                            },
                            durationFall,
                            'linear',
                            function () {
                                $(this).remove()
                            }
                        );
                }, 500);

            var snow = {};
            var snowflex = {};

            snowflex.create = function () {
                var flex = document.createElement('div');
                flex.innerHTML = "&#10052;";
                flex.style.fontSize = 10 + Math.random() * 20 + 'px';
                flex.style.top = - 50 + Math.random() * 20 + 'px';
                flex.style.left = Math.random() * 1500 + 'px';
                flex.style.position = "absolute";
                flex.style.color = "#F3F3F3";
                flex.style.opacity = Math.random();
                document.getElementsByTagName('body')[0].appendChild(flex);
                return flex;
            };

            snow.snowflex = function () {
                var flex = snowflex.create();
                var x = -1 + Math.random() * 2;
                var t = setInterval(
                    function () {
                        flex.style.top = parseInt(flex.style.top) + 5 + 'px';
                        flex.style.left = parseInt(flex.style.left) + x + 'px';
                        if (parseInt(flex.style.top) > 1500) {
                            clearInterval(t);
                            document.getElementsByTagName('body')[0].removeChild(flex);
                        }
                    }, 45 + Math.random() * 20);
            };

            snow.storm = function () {
                var t = setInterval(
                    function () {
                        snow.snowflex();
                    }, 500);
            };

            //snow.storm();

            var fog = {};

            fog.draw = function (ctx, x, y) {

                ctx.fillStyle = "rgba( 255, 255, 255, " + Math.random() + " )";
                ctx.arc(x, y, 10, 0, Math.PI * 2, true);
                ctx.closePath();
                ctx.fill();

            };


            fog.start = function () {
                var ctx = document.getElementById('canvas').getContext("2d");
                var x = 0;
                var y = 0;
                var t = setInterval(
                    function () {

                        x = 300 + 300 * Math.sin(x);
                        y = 300 + 300 * -Math.cos(x);

                        x += 2;
                        fog.draw(ctx, x, y);

                    }, 100);
            };

                function showPassword() {
                    if ($("#contrasena").attr("type") == "password") $("#contrasena").attr("type", "text");
                    else $("#contrasena").attr("type", "password");

                    $("#showPass i").toggle();
                }
</script>
<!---->


</html>
