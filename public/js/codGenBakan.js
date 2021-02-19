$(document).ready(function(){
/*===================================================
=            submenu de codigos de Bakan            =
===================================================*/
$( "#codGenAsignado" ).hide();
$( "#codGenAsignadoComp" ).hide();
$( "#autor" ).hide();
$( "#enviarSoliCodGenBakan" ).prop('disabled', true);
/*----------  validar que no tenga codigo generico asignado a pt  ----------*/

$( "#ptxAsignado" ).blur(function(){

  var ptxAsignado = $(this).val();
  if(ptxAsignado == ""){

    $(this).attr("class","form-control is-invalid")
    $( "#invalid" ).html("Campo obligatorio");
    $( "#desc1PtxAsignado" ).val("");
    $( "#desc2PtxAsignado" ).val("");
    $( "#enviarSoliCodGenBakan" ).prop('disabled', true);
    $( "#codGenAsignado" ).hide();
    $( "#des1CodGenerico" ).val("");
    $( "#des2CodGenerico" ).val("");

  }else{
    //console.log(ptxAsignado);
    $.ajax({
      url: 'http://200.30.30.177/codigogenerico/getArticulo',
      type: 'GET',
      data: { ptxAsignado : ptxAsignado},
      success: function(response){
        
        if (response.length == 0) {

          $( "#ptxAsignado" ).attr("class","form-control is-invalid");
          $( "#invalid" ).html("PT no Existe en sistema");
          console.log('cesar');
          $( "#desc1PtxAsignado" ).val("");
          $( "#desc2PtxAsignado" ).val("");
          $( "#enviarSoliCodGenBakan" ).prop('disabled', true);
          $( "#codGenAsignado" ).hide();
          $( "#codGenAsignadoComp" ).hide();
          $( "#des1CodGenerico" ).val("");
          $( "#des2CodGenerico" ).val("");

        }else{

          var Articulo = response[0].Articulo;
          var Descripcion1 = response[0].Descripcion1;
          var Descripcion2 = response[0].Descripcion2;
          var ClaveFabricante = response[0].ClaveFabricante;
          var CodigoAlterno = response[0].CodigoAlterno;
          //console.log("Articulo:"+Articulo+", Descripcion1:"+Descripcion1+", Descripcion2:"+Descripcion2+", ClaveFabricante:"+ClaveFabricante+", CodigoAlterno:"+CodigoAlterno);

          if(/GBAKAN/.test(ClaveFabricante)){

            $( "#ptxAsignado" ).attr("class","form-control is-invalid");
            $( "#invalid" ).html("PT ya cuenta con Codigo Generico Asignado:" +ClaveFabricante);
            $( "#desc1PtxAsignado" ).val("");
            $( "#desc2PtxAsignado" ).val("");
            $( "#enviarSoliCodGenBakan" ).prop('disabled', true);
            $( "#codGenAsignado" ).hide();
            $( "#codGenAsignadoComp" ).hide();
                    
          }
          else{

            $( "#ptxAsignado" ).attr("class","form-control is-valid");
            var desc1PtxAsignado = $( "#desc1PtxAsignado" ).val(response[0].Descripcion1);
            var indices = [];
            var desc1PtxAsignadoValor = $( "#desc1PtxAsignado" ).val();
            for(var i = 0; i < desc1PtxAsignadoValor.length; i++) {
              if (desc1PtxAsignadoValor[i]=== "(") indices.push(i);
            }
            //console.log('total de caracteres encontrados',indices.length);
            var arregloCadenas = desc1PtxAsignado.val().split("(");
            //console.log("todas las subcadenas",arregloCadenas);
            //console.log("ultima subcadena",arregloCadenas[indices.length]);
            var nuevoValor = desc1PtxAsignadoValor.replace(arregloCadenas[indices.length],')BAKAN');
            //console.log("nuevo valor",nuevoValor);
            $( "#des1CodGenerico" ).val(nuevoValor);
            $( "#desc2PtxAsignado" ).val(response[0].Descripcion2);
            $( "#enviarSoliCodGenBakan" ).prop('disabled', false);
            $( "#codGenAsignado" ).show();
            $( "#codGenAsignadoComp" ).hide();

            $( "#des1CodGenerico" ).blur(function(){

                var des1CodGenerico = $( this );
                if (des1CodGenerico.val() =="") {

                  $(des1CodGenerico).attr("class","form-control is-invalid")
                  $( "#invalidDes1CodGenerico" ).html("Campo obligatorio");
                  $( "#codGenAsignadoComp" ).hide();
                  $( "#enviarSoliCodGenBakan" ).prop('disabled', true);
                  $( "#autor" ).hide();

                }else{

                  var largoDes1CodGenerico = des1CodGenerico.val().length;
                  if (largoDes1CodGenerico >100) {

                    $(des1CodGenerico).attr("class","form-control is-invalid")
                    $( "#invalidDes1CodGenerico" ).html("No debe de Revasar mas de 100 caracteres la Descripcion 1,total de caracteres a reducir:"+(largoDes1CodGenerico-100));
                    $( "#codGenAsignadoComp" ).hide();
                    $( "#enviarSoliCodGenBakan" ).prop('disabled', true);
                    $( "#autor" ).hide();                  

                  }else{

                    $(des1CodGenerico).attr("class","form-control is-valid")
                    $( "#enviarSoliCodGenBakan" ).prop('disabled', false);
                    $( "#codGenAsignadoComp" ).show();
                    $( "#autor" ).show();  

                  }

                }  
            });

          }
    
        }
      }
    });

  }

});
var addCompBakan = $( ".add_buttonCascoAdd" ).click(function(){


  $.each($( ".codGen" ),function(){
    
    // var comp = [parseInt($($(this)).val().substr(0,2),10)];
    // console.log(comp.length);

    if ($(this).val().substr(0,1).indexOf('2') !=-1) {

      var cascoEstr = [parseInt($(this).val().substr(0,2),10)];
      //console.log('casco o estructura en crudo',cascoEstr);
      //numeromayor = cascoEstr[0];
      var pos = 0, hastaPos = 1;

      var elementosEliminados = cascoEstr.splice(pos, hastaPos);
      console.log(elementosEliminados);
  // ["Nabo", "Rábano"] ==> Lo que se ha guardado en "elementosEliminados"
      // for (var i = 0; i <cascoEstr.length; i++) {

      //     // if (cascoEstr[i] >numeromayor) {
      //     //   numeromayor = cascoEstr[i];
      //     //   console.log(numeromayor);
      //     // }
      // }
       
    }else{
      //console.log('estructura en obra negra',parseInt($(this).val().substr(0,2),10));  
    }

  });

});


// codigos genericos de Bakan agregar input

var maxComponentes = 100;
var agregarCasco = $('.add_buttonCasco'); //Add button selector
var agregarEstruc = $('.add_buttonEstructura');
var divCasco = $('.field_wrapperCasco'); //Input field wrapper
var divEstruc = $('.field_wrapperEstructura');
var x = 0; //Initial field counter is 0
var y = 0;
var incrementoCasco = 19;
var incrementoEstruc = 29;

$(agregarCasco).click(function(){

  if(x < maxComponentes){ 

    codigo = $('#codGenerico').val();
    x++; 
    incrementoCasco++;
    var campoCasco = '<div class="input-row md-9"><label>Codigo:</label><input type="text" name="codigoComponCasco[]" class="form-control" value="'+incrementoCasco+codigo+'" readonly><label>Descripcion:</label><input type="text" name="codigoCompoCascoDescrip[]" class="form-control cascosInput UpperCase" placeholder="Casco / Estructura en Crudo" required style="text-transform: uppercase;" aria-describedby="cascoHelpBlock" maxlength="100"><small id="cascoHelpBlock" class="form-text text-muted text-left">Ejemplos:<br>CASCO ASIENTO...<br>ESTRUCTURA EN CRUDO DE...</small><br><button class="btn btn-outline-secondary eliminarInput" type="button" id="button-addon2" title="Quitar Componente"><img src="public/images/menos.png" style="width: 20px; height: 20px;" /></button></div>';
    console.log("incremento",incrementoCasco);
    
    if (incrementoCasco == 30) {
      incrementoCasco = 40;
      var campoCasco = '<div class="input-row md-9"><label>Codigo:</label><input type="text" name="codigoComponCascoDurex[]" class="form-control" value="'+incrementoCasco+codigo+'" readonly><label>Descripcion:</label><input type="text" name="codigoCompoCascoDurexDescrip[]" class="form-control cascosInput UpperCase" placeholder="Casco / Estructura en Crudo" required style="text-transform: uppercase;" aria-describedby="cascoHelpBlock" maxlength="100"><small id="cascoHelpBlock" class="form-text text-muted text-left">Ejemplos:<br>CASCO ASIENTO...<br>ESTRUCTURA EN CRUDO DE...</small><br><button class="btn btn-outline-secondary eliminarInput" type="button" id="button-addon2" title="Quitar Componente"><img src="public/images/menos.png" style="width: 20px; height: 20px;" /></button></div>';
    }
    if (incrementoCasco >= 99) {
      alert('Ya no puedes agregar mas compomentes de este tipo');
    }
    $(divCasco).append(campoCasco); 
  }

});

$(divCasco).on('click', '.eliminarInput', function(e){ 

  e.preventDefault();
  $(this).parent('div').remove(); 
  x--; 
  incrementoCasco--;

});

$(agregarEstruc).click(function(){

  if(y < maxComponentes){

    codigo = $('#codGenerico').val();
    y++;
    incrementoEstruc++;
    var campoEstruc = '<div class="input-row md-9"><label>Codigo:</label><input type="text" name="codigoComponOAN[]" class="form-control" value="'+incrementoEstruc+codigo+'" readonly><label>Descripcion:</label><input type="text" name="codigoCompoAONDescrip[]" class="form-control cascosInput UpperCase" placeholder="Estructura en Obra Negra" required style="text-transform: uppercase;" aria-describedby="AONHelpBlock" maxlength="100"><small id="AONHelpBlock" class="form-text text-muted text-left">Ejemplos:<br>ESTRUCTURA EN OBRA NEGRA SILLA...<br>ESTRUCTURA EN OBRA NEGRA BOTE...</small><br><button class="btn btn-outline-secondary eliminarInput" type="button" id="button-addon2" title="Quitar Componente"><img src="public/images/menos.png" style="width: 20px; height: 20px;" /></button></div>';
    $(divEstruc).append(campoEstruc);

  }

});

$(divEstruc).on('click', '.eliminarInput', function(e){ 

  e.preventDefault();
  $(this).parent('div').remove(); 
  y--; 
  incrementoEstruc--;

});

/*=====  End of submenu de codigos de Bakan  ======*/
/*=======================================================
=            revision de descripciones            =
=======================================================*/
  $( ".guardarDesc" ).hide();  
  $(".checkCorrectoDesc").click(function() {  

      if($(this).is(':checked')) {

          var idCheck = $(this).attr('id');
          console.log('id',idCheck);
          var td= $(this).parent().parent().parent();
          var guardar = td.find("a.guardarDesc");
          guardar.show();
          td.find("a.editarDesc").hide();

          guardar.click(function(e){
            e.preventDefault();
            $.ajax({
              url:'http://200.30.30.177/codigogenerico/updateRevisionBakan',
              type:'get',
              data:{idCheck:idCheck},
              success:function(response){
                console.log('respuesta desde el controller',response);
                location.reload();
              }
            });
          });

      } else {  

          var td= $(this).parent().parent().parent();
          td.find("a.guardarDesc").hide();
          td.find("a.editarDesc").show();

      }  
  }); 
/*=====  End of revision de descripciones  ======*/

});

