$(document).ready(function() {
    $("#codGenAsignadoCompDurex").hide();
    $("#autorCodDurex").hide();
    $("#des1CodGenericoDurex").blur(function() {

        var des1CodGenerico = $(this);
        if (des1CodGenerico.val() == "") {

            $(des1CodGenerico).attr("class", "form-control is-invalid")
            $("#invalidDes1CodGenerico").html("Campo obligatorio");
            $("#codGenAsignadoCompDurex").hide();
            $("#enviarSoliCodGenBakan").prop('disabled', true);
            $("#autorCodDurex").hide();

        } else {

            var largoDes1CodGenerico = des1CodGenerico.val().length;
            if (largoDes1CodGenerico > 100) {

                $(des1CodGenerico).attr("class", "form-control is-invalid")
                $("#invalidDes1CodGenerico").html("No debe de Revasar mas de 100 caracteres la Descripcion 1,total de caracteres a reducir:" + (largoDes1CodGenerico - 100));
                $("#codGenAsignadoCompDurex").hide();
                $("#enviarSoliCodGenBakan").prop('disabled', true);
                $("#autorCodDurex").hide();

            } else {

                $(des1CodGenerico).attr("class", "form-control is-valid")
                $("#enviarSoliCodGenBakan").prop('disabled', false);
                $("#codGenAsignadoCompDurex").show();
                $("#autorCodDurex").show();

            }

        }
    });
    // codigos genericos de Bakan agregar input

    var maxComponentes = 110;
    var agregarCasco = $('.add_buttonCasco'); //Add button selector
    var agregarEstruc = $('.add_buttonEstructura');
    var divCasco = $('.field_wrapperCascoDurex'); //Input field wrapper
    var divEstruc = $('.field_wrapperEstructuraDurex');
    var x = 0; //Initial field counter is 0
    var y = 0;
    var incrementoCasco = 19;
    var incrementoEstruc = 29;

    $(agregarCasco).click(function() {
        $.ajax({
            url: 'http://200.30.30.177/codigogenerico/getRutas',
            type: 'GET',
            success: function(response) {

                if (x < maxComponentes) {

                    codigo = $('#codGenericoDurex').val();
                    x++;
                    incrementoCasco++;
                    var campoCasco = '<div class="input-row md-9"><label>Codigo:</label><input type="text" name="codigoComponCascoDurex[]" class="form-control" value="' + incrementoCasco + codigo + '" readonly><label>Descripcion:</label><input type="text" name="codigoCompoCascoDurexDescrip[]" class="form-control cascosInput UpperCase" placeholder="Casco / Estructura en Crudo" required style="text-transform: uppercase;" aria-describedby="cascoHelpBlock" maxlength="100"><small id="cascoHelpBlock" class="form-text text-muted text-left">Ejemplos:<br>CASCO ASIENTO...<br>ESTRUCTURA EN CRUDO DE...</small><div id="Rutas"><label for="ruta">Ruta:</label>' + response + '</div><br><button class="btn btn-outline-secondary eliminarInput" type="button" id="button-addon2" title="Quitar Componente"><img src="public/images/menos.png" style="width: 20px; height: 20px;" /></button></div>';
                    console.log("incremento", incrementoCasco);
                    if (incrementoCasco == 30) {
                        incrementoCasco = 40;
                        var campoCasco = '<div class="input-row md-9"><label>Codigo:</label><input type="text" name="codigoComponCascoDurex[]" class="form-control" value="' + incrementoCasco + codigo + '" readonly><label>Descripcion:</label><input type="text" name="codigoCompoCascoDurexDescrip[]" class="form-control cascosInput UpperCase" placeholder="Casco / Estructura en Crudo" required style="text-transform: uppercase;" aria-describedby="cascoHelpBlock" maxlength="100"><small id="cascoHelpBlock" class="form-text text-muted text-left">Ejemplos:<br>CASCO ASIENTO...<br>ESTRUCTURA EN CRUDO DE...</small><div id="Rutas"><label for="ruta">Ruta:</label>' + response + '</div><br><button class="btn btn-outline-secondary eliminarInput" type="button" id="button-addon2" title="Quitar Componente"><img src="public/images/menos.png" style="width: 20px; height: 20px;" /></button></div>';
                    }
                    if (incrementoCasco >= 99) {
                        alert('Ya no puedes agregar mas compomentes de este tipo');
                    }
                    $(divCasco).append(campoCasco);
                }
                
            }
        });
    });

    $(divCasco).on('click', '.eliminarInput', function(e) {

        e.preventDefault();
        $(this).parent('div').remove();
        x--;
        incrementoCasco--;

    });

    $(agregarEstruc).click(function() {

        if (y < maxComponentes) {

            codigo = $('#codGenericoDurex').val();

            y++;
            incrementoEstruc++;

            var campoEstruc = '<div class="input-row md-9"><label>Codigo:</label><input type="text" name="codigoComponOANDurex[]" class="form-control" value="' + incrementoEstruc + codigo + '" readonly><label>Descripcion:</label><input type="text" name="codigoCompoAONDurexDescrip[]" class="form-control cascosInput UpperCase" placeholder="Estructura en Obra Negra" required style="text-transform: uppercase;" aria-describedby="AONHelpBlock" maxlength="100"><small id="AONHelpBlock" class="form-text text-muted text-left">Ejemplos:<br>ESTRUCTURA EN OBRA NEGRA SILLA...<br>ESTRUCTURA EN OBRA NEGRA BOTE...</small><br><button class="btn btn-outline-secondary eliminarInput" type="button" id="button-addon2" title="Quitar Componente"><img src="public/images/menos.png" style="width: 20px; height: 20px;" /></button></div>';
            if (incrementoEstruc >= 39) {
                alert('Ya no puedes agregar mas compomentes de este tipo');
            }
            $(divEstruc).append(campoEstruc);

        }

    });

    $(divEstruc).on('click', '.eliminarInput', function(e) {

        e.preventDefault();
        $(this).parent('div').remove();
        y--;
        incrementoEstruc--;

    });
});