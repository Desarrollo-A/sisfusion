<!--   Core JS Files   -->
<script src="<?=base_url()?>dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/popper.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<!-- Bootstrap CORE -->
<script src="<?=base_url()?>dist/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Material -->
<script src="<?=base_url()?>dist/js/material.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?=base_url()?>dist/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?=base_url()?>dist/js/moment.min.js"></script>
<!--  Charts Plugin -->
<script src="<?=base_url()?>dist/js/chartist.min.js"></script>
<!--  Plugin for the Wizard -->
<script src="<?=base_url()?>dist/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin    -->
<script src="<?=base_url()?>dist/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<script src="<?=base_url()?>dist/js/jquery.sharrre.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?=base_url()?>dist/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin -->
<script src="<?=base_url()?>dist/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin -->
<script src="<?=base_url()?>dist/js/nouislider.min.js"></script>
<!-- Select Plugin -->
<script src="<?=base_url()?>dist/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin    -->
<script src="<?=base_url()?>dist/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?=base_url()?>dist/js/sweetalert2.js"></script>
<script src="<?=base_url()?>dist/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?=base_url()?>dist/js/fullcalendar.min.js"></script>
<!-- TagsInput Plugin -->
<script src="<?=base_url()?>dist/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?=base_url()?>dist/js/material-dashboard2.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?=base_url()?>dist/js/demo.js"></script>
<script src="<?=base_url()?>dist/js/alerts.js"></script>
<script src="<?=base_url()?>dist/js/funciones-generales.js"></script>
<script src="<?=base_url()?>dist/js/controllers/select2/select2.full.min.js"></script>
<script src="<?=base_url()?>dist/js/fullcalendar/main.js"></script>
<script src="<?=base_url()?>dist/js/fullcalendar/locales-all.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general/main_services.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>

<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script type="text/javascript">
    var url2 = "<?=base_url()?>index.php/";
    var general_base_url = "<?=base_url()?>";
    let id_rol_general = <?= (empty($this->session->userdata('id_rol')) ? 0 : $this->session->userdata('id_rol')) ?>;
    let id_sede_general = '<?= (empty($this->session->userdata('id_sede')) ? 0 : $this->session->userdata('id_sede')) ?>';
    let id_usuario_general =  <?= (empty($this->session->userdata('id_usuario')) ? 0 : $this->session->userdata('id_usuario')) ?>;
    let tipoUsuarioGeneral =  <?=$this->session->userdata('tipo')?>;
    let sede_usuario_general_div = " <?= $this->session->userdata('id_sede') ?> ";
    let lider_general = "<?=$this->session->userdata('id_lider')?> ";

    
    let forma_de_pago_general = <?=$this->session->userdata('forma_pago');?>;


    let sede_usuario_general_array = sede_usuario_general_div.split(",");

    let sede_usuario_general = (sede_usuario_general_div.length > 1 ?  sede_usuario_general_array[0] : sede_usuario_general_div );

    
	$(document).ready(function() {
		//demo.initDashboardPageCharts();
	});

    function validaCheckSession(){
        if($('#no_mostrar_session:checkbox:checked').length > 0){
            $.post('<?=base_url()?>index.php/Login/noShowModalSession',  function(data) {
            });
            <?php echo "console.log(".$this->session->userdata('no_show_modal_info').");";?>
        }
    }

    var id_rol_global = <?= (empty($this->session->userdata('id_rol')) ? 0 : $this->session->userdata('id_rol')) ?>;
</script>

<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>

<script src="<?= base_url() ?>dist/js/components/components.js"></script>
<script src="<?= base_url() ?>dist/js/components/table.js"></script>
<script src="<?= base_url() ?>dist/js/components/dialogs.js"></script>
<script src="<?= base_url() ?>dist/js/components/forms.js?v=3"></script>

<!-- jquery.i18n -->

<script src="<?= base_url() ?>dist/js/jquery.i18n/jquery.i18n.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/jquery.i18n.messagestore.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/jquery.i18n.fallbacks.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/jquery.i18n.parser.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/jquery.i18n.emitter.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/jquery.i18n.language.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/languages/he.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/languages/fi.js"></script>
<script src="<?= base_url() ?>dist/js/jquery.i18n/languages/ml.js"></script>
<script type="text/javascript">
    let locale = localStorage.getItem('locale')

    $.i18n().load('<?= base_url() ?>dist/js/jquery.i18n/langs.json')
    .done(function() {
        $('body').i18n()
        //changeLanguaje()

        triggerLoadFunctions()
    })

    $.i18n( { 
        locale: 'es' // Locale is English 
    });

    // Load locale from config
    if(locale){
        $.i18n().locale = locale;
    }

    $(document).ready(function() {
        changeIcon(locale)
    })

    function changeIcon(lang) {
        $('#lang_icon').attr("src", `<?= base_url() ?>static/images/langs/${lang}.png`)
    }

    function changeLanguaje() {
        let locale = localStorage.getItem('locale')

        if(locale == 'en'){
            new_locale = 'es'
        }else{
            new_locale = 'en'
        }

        $.i18n().locale = new_locale
        localStorage.setItem('locale', new_locale)
        changeIcon(new_locale)

        $('body').i18n()

        triggerChangeFunctions()
    }

    _ = $.i18n

    let load_functions = []
    let change_functions = []

    function onLoadTranslations(callback){
        if (typeof callback === 'function') {
            load_functions.push(callback)
        }
    }

    function onChangeTranslations(callback){
        if (typeof callback === 'function') {
            change_functions.push(callback)
        }
    }

    function triggerLoadFunctions() {
        for (let callback of load_functions) {
            callback()
        }
    }

    function triggerChangeFunctions() {
        for (let callback of change_functions) {
            callback()
        }
    }

</script>
