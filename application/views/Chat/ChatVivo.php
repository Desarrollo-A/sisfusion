<meta charset='utf-8'>

<style type="text/css">
  .chat-list-box{
    width: 100%;
    background: #fff;
    box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
    border-radius: 5px;
  }
  ul.list-inline.text-left.d-inline-block.float-left {
    margin-bottom: 0;
  }
  .head-box{
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .chat-person-list{
    overflow-y: auto;
    background-color: #fff;
    border-radius: 0 0 5px 5px;
  }
  .chat-person-list ul li {
    width:100%;
    padding-left: 15px;
    line-height: 50px;
  }
  .selectedConversation{
    background-color: #eaeaea!important;
  }
  .usersDisconnected .box-s{
    color: red!important;
  }
  .userConnected .box-s{
    color: green!important;
  }
  .selectedDisconnected{
    background-color: #eaeaea !important;
  }
  .box-chat-all{
    box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
  }
  #box-header-chat{
    padding: 5px 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #103f75;
    border-radius: 5px 5px 0 0;
    font-weight: 400;
    color: white;
    height:100%;
  }
  .asesor_message{
    margin: 30px 20px 25px 20%;
    border-radius: 15px;
    background: #3c4858;
    color: #fff;
    padding: 5px 10px;
    display: inline-block;
    position: relative;
    text-align: left;
    max-width: 65%;
    float: right;
    word-wrap: break-word;
  }
  .cliente_message{
    margin: 5px 0px 24px 20px;
    border-radius: 15px;
    background: #0070d0;
    color: #fff;
    padding: 5px 10px;
    display: inline-block;
    position: relative;
    text-align: left;
    max-width: 65%;
    word-wrap: break-word;
  }
  .sb14:before {
    content: "";
    width: 0px;
    height: 0px;
    position: absolute;
    border: 12px solid;
    border-color: #0070d0 transparent transparent transparent;
    left: -10px;
    top: 0px;
  }
  .li_time{
    position: absolute;
    margin: 3px 24px;
    font-size: 0.7em;
    bottom: 0%;
  }
  .sb15:before {
    content: "";
    width: 0px;
    height: 0px;
    position: absolute;
    border: 12px solid;
    border-color: #3c4858 transparent transparent transparent;
    right: -10px;
    top: 0px;
  }
  .right_position{
    right: 0%;
  }
  .selectSede{
    height: 70%;
    width: 100%;
    border-radius: 5px;    
    border:none;
    box-shadow: 0px 10px 30px 0px rgb(50 50 50 / 16%);
    padding: 0 5px;
  }
  .messages-box {
    max-height: 96%;
    overflow: auto;
    padding: 0 12px;
  }
  .feebinfo{
    position:absolute;
    bottom:0;
    font-size: 0.8em;
  }
  .badgep{
    padding: 6px 9px;
    font-size: 13px;
    font-weight: 500;
    background-color: #333;
    border-radius: 50%;
  }
  
  /* Estilo del scroll en DIVS */
  /* El background del scroll */
  .scroll-styles::-webkit-scrollbar-track{
    border-radius: 10px;
    background-color: transparent;
  }
  /* El background del scroll (border)*/
  .scroll-styles::-webkit-scrollbar{
    width: 9px;
    background-color: transparent;
  }
  /* Color de la barra de desplazamiento */
  .scroll-styles::-webkit-scrollbar-thumb{
    border-radius: 10px;
    background-color: #c1c1c1;
  }
  /* Color del HOVER de barra de desplazamiento */
  .scroll-styles::-webkit-scrollbar-thumb:hover{
    background-color: #A8A8A8;
  }
  /* END de estilos del scroll en DIVS */

  /* Estilos generales */
  .height-100{
    height: 100%;
  }
  .height-90{
    height: 90%;
  }
  .height-75{
    height:75%;
  }
  .height-25{
    height:25%;
  }
  .height-10{
    height:10%;
  }
  .d-flex{
    display: flex;
  }
  .d-none{
    display:none;
  }
  .m-0{
    margin: 0px;
  }
  .ml-1{
    margin-left: 10px;
  }
  .padding0 {
    padding: 0px;
  }
  .pl-0{
    padding-left: 0px;
  }
  .pr-0{
    padding-right: 0px;
  }
  .pt-1{
    padding-top:10px;
  }
  .pt-2{
    padding-top:20px;
  }
  .pb-1{
    padding-bottom:10px;
  }
  /* END Estilos generales */

</style>

<div>
  <div class="wrapper">
    <?php
       
    /*-------------------------------------------------------*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
    $this->load->view('template/sidebar', $datos);
    /*--------------------------------------------------------*/
    /*
    if ($this->session->userdata('id_rol') == 7 && empty($permiso)) {
      echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    if($this->session->userdata('id_rol') == 7 && $permiso[0]['estado'] != 1){
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }*/
    ?>

    <div class="container-fluid" style="height:calc(100vh - 188px); margin-top: 70px;">
      <!-- <input type="hidden" name="foto" id="foto" value="<?=$permiso[0]['foto']?>">
      <input type="hidden" name="nom" id="nom" value="<?=$this->session->userdata('nombre')?>">
      <input type="hidden" name="idasesor" id="idasesor" value="<?=$this->session->userdata('id_usuario')?>"> -->

      <div class="container-fluid height-100 pt-1 pb-1">
        <div class="row pb-1 height-100">
          <div class="col-md-4 col-lg-4 height-100 pr-0">
            <div class="container-fluid height-100 padding0">
              <div class="row height-100">
                <div class="col-md-12 height-10">
                  <select id="selectSede" class="selectSede"></select>
                </div><!-- END col-md-12 -->
                <div class="col-md-12 height-90">
                  <div class="chat-list-box height-100">
                    <div class="head-box" style="height:7%">
                      <div class="row">
                        <div class="col-md-12">
                          <p style="margin: 0" id="mischats">TODOS LOS CHATS</p>
                        </div>
                      </div>
                    </div><!-- END head-box-->
                    <div class="row" style="height:1%">
                      <div class="col-md-12" style="display:flex; justify-content:center">
                        <hr style="width: 90%; margin:0 0 5px 0">
                      </div>
                    </div>

                    <div class="row" style="height:92%">
                      <div class="col-md-12 height-100">
                        <div class="chat-person-list scroll-styles height-100   ">
                          <ul class="list-inline" id="chats">
                          </ul>
                        </div>
                      </div>
                    </div><!-- END row -->
                  </div><!-- END chat-list-box -->
                </div><!-- END col-md-12 -->
              </div><!-- END row -->
            </div><!-- END container-fluid -->
          </div> <!-- END col-md-4 -->

          <div class="col-md-8 col-sm-12 height-100">            
            <div class="box-chat-all height-100">
              <div class="row height-100">
                <div class="col-md-12 height-100">
                  <div class="card m-0 height-100" style="border-radius: 6px; box-shadow:none">
                    <div class="row height-100">
                      <div class="col-md-12" style="height:7%">
                        <div id="box-header-chat">
                        </div>
                      </div>
                      <div class="col-md-12" style="height:93%;">
                        <div class="messages-box scroll-styles" id="scrolll" >
                        </div>
                      </div>
                    </div>
                  </div> <!-- END card -->
                </div><!-- END col-md-12 -->
              </div><!-- END row -->
            </div><!-- END box-chat-all -->
          </div><!-- END col-md-8 -->
        </div><!-- END row-->
      </div><!-- END container-fluid -->
      <?php $this->load->view('template/footer_legend');?>
    </div><!-- END container-fluid -->
  </div><!-- END wrapper -->
</div><!-- END div principal -->
</div>
</div>

<?php $this->load->view('template/footer');?>

<script type="text/javascript">
  let url3 = '<?=base_url()?>static/documentos/carpetas/';
  let url = "<?=base_url()?>";
  let valor=0;
  let global =0;
  let id;
</script>

<script src="<?=base_url()?>dist/js/socket.io.js"></script>
<script>
  //consultas al servidor con ajax
  let perfil;
  var mySound = new Audio('../static/tono-mensaje.mp3');
    mySound.load();
  $.ajax({
      type: 'POST',
      url: '<?=base_url()?>index.php/Chat/getInfoPerfil',
      dataType: 'json',
      beforeSend: function(){
          // Actions before send post
      },
      success: function(data) {
        perfil = data;
        console.log(perfil);
      },
      async: false 
    })
    
    let sedes =   perfil[0].id_sede;
    var selectSede = $('#selectSede');
    selectSede.append('<option value="">Selecciona una opción.</option>');        
    sedes.forEach(function(element){
      console.log("entra foreach sedes");
      $.post('<?=base_url()?>index.php/Chat/getSedes/'+element.trim(), function(data2) {                
        var id = data2['id_sede'];
        var nombreSede = data2['nombre']
        selectSede.append('<option value="'+id+'">'+nombreSede+'</option>');        
      }, 'json');
    })

    var socket = io('https://chatcomercial.gphsis.com/',{query:{
          "user":3,
          "maxChats": 0,
          "status": perfil[0].estatus,
          "sede":perfil[0].id_sede,
          "nombre":perfil[0].nombre,
          "customID": perfil[0].id_usuario,
    }});

        socket.on('chat message', function(data) {
          console.log(data);
          var last_msg = (data.time).substr((data.time).indexOf(' ')+1);
          $('#container_'+data.id).html(' ');
          var div_general = document.createElement('div');
          var item = document.createElement('li');
          var time = document.createElement('li');

          item.textContent = data.msg;
          time.textContent = data.time;
          div_general.className = 'col-xs-12 padding0';
          if(data.emisor == 1)
        {
            item.className = 'asesor_message';
            item.className += ' sb15';
            time.className = 'li_time';
            time.className += ' right_position';
        }
        else {
            item.className = 'cliente_message';
            item.className += ' sb14';
            time.className = 'li_time';
        }
          var messages = document.getElementById('mensajes_'+data.id);
          var conversation = document.getElementById(data.id);          
          if(id != data.id || id == undefined){
            // mySound.play();
            let count = conversation.getAttribute('data-unseen');
            count++;
            conversation.textContent = 'Lead:'+data.id+' '+count;
            conversation.setAttribute('data-unseen', count);
            conversation.setAttribute('data-lastmsg', last_msg);
            conversation.innerHTML = "<div class='container-fluid'><div class='row' style='display:flex; align-items: center;'><div class='col-md-3' style='padding: 0; display:flex; justify-content:center'><div><span class='new badgep' style='color: white;background: #416ed2'>"+ count +"</span><i class='fa fa-circle box-s' aria-hidden='true' style='color:green; position: absolute; transform: translate(-8px, 28px);'></i></div></div><div class='col-md-9' style='padding-left:0'><div style='padding-top:15px'><p style='margin: 0; font-size: 16px;'><b>Lead: "+data.id+"</b></p><p style='font-size: 12px; margin:0; margin-top:-28px'><i id='typing_gral_"+data.id+"'>Último mensaje " + last_msg + "</i></p></div></div></div></div></div></div></div>";
          }
          else{
            document.getElementById("typing_gral_"+data.id).innerHTML = "Último mensaje "+last_msg;
          }
          
          div_general.appendChild(item);
          div_general.appendChild(time);
          messages.appendChild(div_general);
          // window.scrollTo(0, document.body.scrollHeight);

          var objDiv = document.getElementById("scrolll");
          objDiv.scrollTop = objDiv.scrollHeight;
        });

        $(document).on('click','.users', function(){
          id = (this).id;

          var header_chat = document.getElementById('box-header-chat');
          header_chat.innerHTML = "<p class='m-0'>Lead: " +id+ "</p>";
          var last_msg = (this).getAttribute('data-lastmsg');
          $('.messages-list').hide();
          $('.users').removeClass('selectedDisconnected');
          $('.users').removeClass('selectedConversation');
          var messages = document.getElementById('mensajes_'+id);
          var conversation = document.getElementById(id);
          if(conversation.getAttribute('data-connected') == 'true'){
            conversation.classList.add("selectedConversation");
            conversation.classList.add("userConnected");
          }else{
            conversation.classList.add("selectedDisconnected");
            conversation.classList.add("usersDisconnected");
          }
          conversation.innerHTML = "<div class='container-fluid'><div class='row' style='display:flex; align-items: center;'><div class='col-md-3' style='padding: 0; display:flex; justify-content:center'><div style='padding-top:2px'><i class='fa fa-user-circle' aria-hidden='true' style='font-size: 26px;'></i><i class='fa fa-circle box-s' aria-hidden='true' style='position: absolute; transform: translate(-8px, 24px);'></i></div></div><div class='col-md-9' style='padding:0'><div><p style='margin: 0; font-size: 16px;'><b>Lead: " +id+ "</b></p><p style='font-size: 12px; margin:0; margin-top:-28px'><i id='typing_gral_"+id+"'>Último mensaje " + last_msg + "</i></p></div></div></div></div>";
          conversation.setAttribute('data-unseen', 0);
          messages.style.display = "block";
        })
      
         socket.on("connect", () => {
             //console.log(socket); 
         });

        socket.on('getRooms', function (data) {
          var elements2 = data.cuartosRedis;
          var elements = elements2.filter(function(e){
            return sedes.includes(e.sede);
          });

          for(var x=0;x<elements.length;x++){
            if(document.getElementById(elements[x].id)){
              var li =  document.getElementById(elements[x].id);
              li.setAttribute('data-connected',elements[x].conectado);
              if(elements[x].conectado == false){
                $("#"+elements[x].id).removeClass("userConnected");
                $("#"+elements[x].id).addClass("usersDisconnected");
              }
              else{
                $("#"+elements[x].id).removeClass("usersDisconnected");
                $("#"+elements[x].id).addClass("usersDisconnected");
              }
            }
          }

          if(document.getElementById(elements[elements.length-1].id)== null && elements[elements.length-1].asesor != 0){
            var li = document.createElement('li');
            var div = document.createElement('ul');
            div.id = 'mensajes_'+elements[elements.length-1].id;
            li.id= elements[elements.length-1].id;
            li.setAttribute("data-connected", elements[elements.length-1].conectado);
            li.setAttribute("sede", elements[elements.length-1].sede);
            li.setAttribute("data-unseen", 0);
            li.classList.add("users");
            li.tabIndex= elements.length;
            div.classList.add("list-unstyled","messages-list");
            div.style.display = "none";
            if($('#selectSede').val() == elements[elements.length-1].sede){
              li.style.display = "block";
            }else{
              li.style.display = "none";

            }
            // Set text of element
            li.textContent = elements[elements.length-1].name;
            
            // Append this element to its parent
            document.getElementById('chats').appendChild(li);
            document.getElementById('scrolll').appendChild(div);

            var typing_container = document.createElement('div');
            typing_container.setAttribute("id", "container_"+elements[elements.length-1].id);
            typing_container.classList.add('feebinfo');
            div.appendChild(typing_container);
          }

        })

        socket.on('getCookiesRooms', function(data){          
          var elements = data.cuartosSuper;
          console.log("elementos: ");
          console.log(elements);
          for(var x=0;x<elements.length;x++){
            if(elements[x].asesor != 0){
            var last_msg = elements[x].messages[(elements[x].messages).length-1].time;
            last_msg = (last_msg).substr((last_msg).indexOf(' ')+1);
            var li = document.createElement('li');
            var div = document.createElement('ul');
            var typing_container = document.createElement('div');
            typing_container.setAttribute("id", "container_"+elements[x].id);
            div.id = 'mensajes_'+elements[x].id;
            li.id= elements[x].id;
            li.setAttribute("data-connected", elements[x].conectado);
            li.setAttribute("data-unseen", 0);
            li.setAttribute('data-lastmsg', last_msg);
            li.setAttribute("sede", elements[x].sede);
            li.classList.add("users");
            li.tabIndex= x+1;
            div.classList.add("list-unstyled","messages-list");
            div.style.display = "none";
            typing_container.classList.add('feebinfo');
            
            // Set text of element
            li.innerHTML = "<div class='container-fluid'><div class='row' style='display:flex; align-items: center;'><div class='col-md-3' style='padding: 0; display:flex; justify-content:center';><div><i class='fa fa-user-circle' aria-hidden='true' style='font-size: 26px;'></i><i class='fa fa-circle box-s' aria-hidden='true' style='position: absolute; transform: translate(-8px, 24px);'></i></div></div><div class='col-md-9' style='padding:0'><div style='padding-top:2px'><p style='margin: 0; font-size: 16px;'><b>" +elements[x].name+ "</b></p><p style='font-size: 12px; margin:0; margin-top:-30px'><i class='typing_gral"+elements[x].id+"'>Último mensaje " + last_msg +"</i></p></div></div></div></div>";
            if(elements[x].conectado == false){
              li.classList.add("usersDisconnected");
            }
            else{
              li.classList.add("userConnected");
            }

            if($('#selectSede').val() == elements[elements.length-1].sede){
              li.style.display = "block";
            }
            else{
              li.style.display = "none";
            }
            // Append this element to its parent
            document.getElementById('chats').appendChild(li);
            document.getElementById('scrolll').appendChild(div);

            for(var y = 0;y<(elements[x].messages).length;y++){
              var div_general = document.createElement('div');
              var item = document.createElement('div');
              var time = document.createElement('li');
              item.textContent = elements[x].messages[y].msg;
              time.textContent = elements[x].messages[y].time;
              div_general.className = 'col-xs-12 padding0';              
              if(elements[x].messages[y].emisor == 1){
                item.className = 'asesor_message';
                item.className += ' sb15';
                time.className = 'li_time';
                time.className += ' right_position';
              }
              else {
                item.className = 'cliente_message';
                item.className += ' sb14';
                time.className = 'li_time';
              }
                var messages = document.getElementById('mensajes_'+elements[x].id);
                div_general.appendChild(item);
                div_general.appendChild(time);
                messages.appendChild(div_general);
            }
            messages.appendChild(typing_container);
            }
          }
        });

        $(document).on('change', '.selectSede', function(){
          $('#box-header-chat').empty();
          let current = $(this).val();
        //  let list = $("#chats").find(`[data-sede='${current}']`);
        //   console.log(list);
          $('.users').removeClass('selectedConversation');
          $('.users').removeClass('selectedDisconnected');
          var div = document.querySelector('#chats');
          var div2 = document.querySelector('#scrolll');
          var list = div2.querySelectorAll(`ul.messages-list`);
          console.log(list);
          id = ''
          Array.from(div.querySelectorAll(`li.users`), e => e.style.display = "none");
          Array.from(div2.querySelectorAll(`ul.messages-list`), e => e.style.display = "none");
          Array.from(div.querySelectorAll(`li[sede='${current}']`), e => e.style.display = "block");

          // list.forEach(function(element){
          //   element.style.display= 'block';
          // });
        })
      </script>
</body>
</html>