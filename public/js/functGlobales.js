$(document).ready(function(){
	/*==========================================================
	=            evitar el envio por la tecla enter            =
	==========================================================*/
	  $("form").keypress(function(e) {
	        if (e.which == 13) {
	            return false;
	        }
	    });
	/*=====  End of evitar el envio por la tecla enter  ======*/
/*============================================
  =            funcion de mayuscula            =
  ============================================*/
 $(".UpperCase").on("keypress", function () {
  $input=$(this);
  setTimeout(function () {
   $input.val($input.val().toUpperCase());
  },50);
 })

  /*=====  End of funcion de mayuscula  ======*/

	/*=============================================
	=            permitir solo números            =
	=============================================*/
	$('.solo-numeros').on('input', function () { 
	    this.value = this.value.replace(/[^0-9]/g,'');
	});
	/*=====  End of permitir solo números  ======*/

	/*=====================================================
	=            validar la baja/eliminar            =
	=====================================================*/
	$( ".eliminar" ).click(function(){
		return confirm("Seguro que desea dar de baja al usuario");
	});
	
	
	/*=====  End of validar la baja/eliminar  ======*/
	/*==================================
	=            datatables            =
	==================================*/
	/*----------  datatable de usuarios  ----------*/
	$('#tableUsuarios').DataTable({
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
	});
	/*----------  datatable de BusquedaBakan  ----------*/
	$( "#tableBusquedaBakan" ).DataTable({
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
	});
	/*----------  datatable de BusquedaDurex  ----------*/
	$( "#tableBusquedaDurex" ).DataTable({
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
	});
	/*----------  datatable codigos generados de bakan  ----------*/
	$( "#tableCodBakan" ).DataTable({
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
	});
	/*----------  datatable codigos generados de durex  ----------*/
	$( "#tableCodDurex" ).DataTable({
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
	});
	/*----------  datatable revision de codigos genericos Bakan  ----------*/
	$( "#tableRevisionBakan" ).DataTable({
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
	});
	/*----------  datatable agregar componentes a codigo generico Bakan  ----------*/
	$( "#tableAddCompBakan" ).DataTable({
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	language: {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
	});
	/*=====  End of datatables  ======*/
	
});	