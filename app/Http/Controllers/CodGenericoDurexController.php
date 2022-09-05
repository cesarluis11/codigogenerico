<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CodGenericoDurexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codigo = DB::select("SELECT top 1 Articulo FROM Art WHERE Articulo LIKE 'GDUREX%' ORDER BY Articulo DESC");
        $string = $codigo[0]->Articulo;
        $parteLetras = substr($string,-11,8);
        $parteNumero = substr($string, -5, 5)+1; 
        $codigoAsignado = $parteLetras.$parteNumero;

        return view('codGenDurex.create',compact('codigoAsignado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codGenericoDurex = strtoupper($request->input('codGenericoDurex'));
        $des1CodGenericoDurex = strtoupper($request->input('des1CodGenericoDurex'));
        $des2CodGenericoDurex = strtoupper($request->input('des2CodGenericoDurex'));
        $codigoComponCascoDurex = $request->input('codigoComponCascoDurex');
        $codigoCompoCascoDurexDescrip = $request->input('codigoCompoCascoDurexDescrip');
        $codigoComponOANDurex = $request->input('codigoComponOANDurex');
        $codigoCompoAONDurexDescrip = $request->input('codigoCompoAONDurexDescrip');
        $solicito = Auth::user()->name;
        $user = Auth::user();
        $rol = $user->roles->implode('name',', ');

        $insertCodGenMetodo = $this->insertCodGenDurex($codGenericoDurex,$des1CodGenericoDurex,$des2CodGenericoDurex,$solicito,$rol);
        $insertCompCascoCodGenDurexMetodo = $this->insertCompCascoCodGenDurex($codGenericoDurex,$codigoComponCascoDurex,$codigoCompoCascoDurexDescrip,$solicito,$rol);
        $insertCompAonCodGenDurexMetodo = $this->insertCompAonCodGenDurex($codGenericoDurex,$codigoComponOANDurex,$codigoCompoAONDurexDescrip,$solicito,$rol);

        $index = db::table('Art')
                ->select('Articulo','Descripcion1','Descripcion2','ClaveFabricante','CodigoAlterno','Linea')
                ->where('ClaveFabricante',$codGenericoDurex)
                ->get();

        return view('codGenDurex.index',compact('index'));
        
    }

    public function indexBusqueda()
    {
        $index = db::table('Art')
                ->select('Articulo','Descripcion1','Descripcion2','ClaveFabricante','CodigoAlterno','Linea','Mensaje')
                ->whereIn('Grupo',['CODIGOS GENERICOS','PRODUCTOS TERMINADOS','CODIGOS GENERICOS COMPONENTES'])
                ->where([
                    ['Linea','DUREX'],
                    ['Estatus','ALTA'],
                    ['Categoria','FABRICACION EN PLANTA'],
                    ['Familia','DUREX PLANTA'],
                    ['Tipo','Normal'],
                ])
                ->get();
        return view ('codGenDurex.indexBusqueda',compact('index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insertCodGenDurex($codGenerico,$des1CodGenerico,$des2CodGenerico,$solicito,$rol)
    {
        $fecha = "";
        $mensaje = "";

        $fecha = Carbon::now()->format('d/m/Y');
        $mensaje = $fecha." ".$solicito;
        if($rol == 'super-admin'){
            $Estatus = 'PROTOTIPO';
        }else{
            $Estatus = 'ALTA';
        }
        $insertCodGen = DB::table('Art')
                    ->insert(['Articulo' => $codGenerico,
                        'Rama' => 'CODIGOSGENERICOS',
                        'Descripcion1' => $des1CodGenerico,
                        'Descripcion2' => $des2CodGenerico,
                        'CodigoAlterno' => $codGenerico,
                        'UltimoCambio' => $fecha,
                        'Alta' => $fecha,
                        'Mensaje' => $mensaje,
                        'ClaveFabricante' => $codGenerico,
                        'Grupo' => 'CODIGOS GENERICOS',
                        'Categoria' => 'FABRICACION EN PLANTA',
                        'Familia' => 'DUREX PLANTA',
                        'Linea' => 'DUREX',
                        'Impuesto1' => '16',
                        'Unidad' => 'pza',
                        'UnidadCompra' => 'pza',
                        'UnidadTraspaso' => 'pza',
                        'TipoCosteo' => 'Promedio',
                        'Tipo' => 'Normal',
                        'TipoOpcion' => 'No',
                        'Accesorios' => '0',
                        'Refacciones' => '0',
                        'Sustitutos' => '0',
                        'Servicios' => '0',
                        'Consumibles' => '0',
                        'MonedaCosto' => 'Pesos',
                        'MonedaPrecio' => 'Pesos',
                        'PrecioLista' => '0',
                        'FactorAlterno' => 1,
                        'Estatus' => $Estatus,
                        'Conciliar' => '0',
                        'Usuario' => 'CCRUZ',
                        'Refrigeracion' => '0',
                        'TieneCaducidad' => '0',
                        'BasculaPesar' => '0',
                        'SeProduce' => 1,
                        'EstatusPrecio' => 'NUEVO',
                        'wMostrar' => 1,
                        'SeCompra' => '0',
                        'SeVende' => 1,
                        'EsFormula' => '0',
                        'MultiplosOrdenar' => '1',
                        'AlmacenROP' => 'AL PT',
                        'CategoriaProd' => 'VARIOS GENERICOS',
                        'ProdCantidad' => '1',
                        'ProdUsuario' => '(Mismo)',
                        'ProdPasoTotal' => '1',
                        'ProdOpciones' => '0',
                        'ProdVerConcentracion' => '0',
                        'ProdVerCostoAcumulado' => '0',
                        'ProdVerMerma' => '0',
                        'ProdVerDesperdicio' => '0',
                        'ProdVerPorcentaje' => '0',
                        'RevisionUsuario' => 'CCRUZ',
                        'ProdMov' => '(por omision)',
                        'EstatusCosto' => 'SINCAMBIO',
                        'SolicitarPrecios' => '0',
                        'Espacios' => '0',
                        'EspaciosEspecificos' => '0',
                        'EspaciosNivel' => 'Dia',
                        'EspaciosMinutos' => '60',
                        'EspaciosBloquearAnteriores' => '1',
                        'SerieLoteInfo' => '0',
                        'FactorCompra' => '1',
                        'ISAN' => '0',
                        'ExcluirDescFormaPago' => '0',
                        'EsDeducible' => '0',
                        'TipoCatalogo' => 'Resurtible',
                        'AnexosAlFacturar' => '0',
                        'Actividades' => '0',
                        'ValidarPresupuestoCompra' => 'No',
                        'SeriesLotesAutoOrden' => '(Empresa)',
                        'LotesFijos' => '0',
                        'LotesAuto' => '0',
                        'TieneDireccion' => '0',
                        'PrecioLiberado' => '0',
                        'ValidarCodigo' => '0',
                        'SincroC' => '1',
                        'CostoIdentificado' => '0',
                        'Impuesto1Excento' => '0',
                        'Excento2' => '0',
                        'Excento3' => '0',
                        'CalcularPresupuesto' => '0',
                        'NivelToleranciaCosto' => '(Empresa)',
                        'Calificacion' => '0',
                        'SAUX' => '0',
                        'SymphonyFamArt' => 'MTO',
                        'ClasificacionInventario' => 'PRODUCTO NACIONAL',
                        'UnidadCantidad' => 1,
                        'FactorGI' => 0,
                        'Temporada' => 'PROYECTO',
                        'ProdMovGrupo' => 'PRODUCTO NACIONAL',
                        'Costo2013' => 0
                    ]);
        if($insertCodGen){
            return "ok";
        }else{
            return "fallo";
        }
    }

    public function insertCompCascoCodGenDurex($codGenerico,$codigoComponCasco,$codigoCompoCascoDescrip,$solicito,$rol)
    {
        $fecha = Carbon::now()->format('d/m/Y');
        $mensaje = $fecha." ".$solicito;
        if($rol == 'super-admin'){
            $Estatus = 'PROTOTIPO';
        }else{
            $Estatus = 'ALTA';
        }
        if($codigoComponCasco == ""){
            //return "variable vacia";
        }else{
            for ($i=0; $i <count($codigoComponCasco) ; $i++) {

                $insertCompCodGen = DB::table('Art')
                    ->insert([
                        'Articulo' => $codigoComponCasco[$i],
                        'Rama' => 'CODIGOSGENERICOS',
                        'Descripcion1' => strtoupper($codigoCompoCascoDescrip[$i]),
                        'CodigoAlterno' => $codigoComponCasco[$i],
                        'UltimoCambio' => $fecha,
                        'Alta' => $fecha,
                        'Mensaje' => $mensaje,
                        'ClaveFabricante' => $codGenerico,
                        'Grupo' => 'CODIGOS GENERICOS COMPONENTES',
                        'Categoria' => 'FABRICACION EN PLANTA',
                        'Familia' => 'DUREX PLANTA',
                        'Linea' => 'DUREX',
                        'Impuesto1' => '16',
                        'Unidad' => 'pza',
                        'UnidadCompra' => 'pza',
                        'UnidadTraspaso' => 'pza',
                        'TipoCosteo' => 'Promedio',
                        'Tipo' => 'Normal',
                        'TipoOpcion' => 'No',
                        'Accesorios' => '0',
                        'Refacciones' => '0',
                        'Sustitutos' => '0',
                        'Servicios' => '0',
                        'Consumibles' => '0',
                        'MonedaCosto' => 'Pesos',
                        'MonedaPrecio' => 'Pesos',
                        'PrecioLista' => '0',
                        'FactorAlterno' => 1,
                        'Estatus' => $Estatus,
                        'Conciliar' => '0',
                        'Usuario' => 'CCRUZ',
                        'Refrigeracion' => '0',
                        'TieneCaducidad' => '0',
                        'BasculaPesar' => '0',
                        'SeProduce' => 1,
                        'EstatusPrecio' => 'NUEVO',
                        'wMostrar' => 1,
                        'SeCompra' => '0',
                        'SeVende' => '0',
                        'EsFormula' => '0',
                        'MultiplosOrdenar' => '1',
                        'AlmacenROP' => 'ACASCO',
                        'CategoriaProd' => 'VARIOS GENERICOS',
                        'ProdCantidad' => '1',
                        'ProdUsuario' => '(Mismo)',
                        'ProdPasoTotal' => '1',
                        'ProdOpciones' => '0',
                        'ProdVerConcentracion' => '0',
                        'ProdVerCostoAcumulado' => '0',
                        'ProdVerMerma' => '0',
                        'ProdVerDesperdicio' => '0',
                        'ProdVerPorcentaje' => '0',
                        'RevisionUsuario' => 'CCRUZ',
                        'ProdMov' => '(por omision)',
                        'EstatusCosto' => 'SINCAMBIO',
                        'SolicitarPrecios' => '0',
                        'Espacios' => '0',
                        'EspaciosEspecificos' => '0',
                        'EspaciosNivel' => 'Dia',
                        'EspaciosMinutos' => '60',
                        'EspaciosBloquearAnteriores' => '1',
                        'SerieLoteInfo' => '0',
                        'FactorCompra' => '1',
                        'ISAN' => '0',
                        'ExcluirDescFormaPago' => '0',
                        'EsDeducible' => '0',
                        'TipoCatalogo' => 'Resurtible',
                        'AnexosAlFacturar' => '0',
                        'Actividades' => '0',
                        'ValidarPresupuestoCompra' => 'No',
                        'SeriesLotesAutoOrden' => '(Empresa)',
                        'LotesFijos' => '0',
                        'LotesAuto' => '0',
                        'TieneDireccion' => '0',
                        'PrecioLiberado' => '0',
                        'ValidarCodigo' => '0',
                        'SincroC' => '1',
                        'CostoIdentificado' => '0',
                        'Impuesto1Excento' => '0',
                        'Excento2' => '0',
                        'Excento3' => '0',
                        'CalcularPresupuesto' => '0',
                        'NivelToleranciaCosto' => '(Empresa)',
                        'Calificacion' => '0',
                        'SAUX' => '0',
                        'SymphonyFamArt' => 'MTO',
                        'ClasificacionInventario' => 'PRODUCTO NACIONAL',
                        'UnidadCantidad' => 1,
                        'FactorGI' => 0,
                        'Temporada' => 'PROYECTO',
                        'ProdMovGrupo' => 'PRODUCTO EN PROCESO',
                        'Costo2013' => 0
                    ]);

            }

        }

    }

    public function insertCompAonCodGenDurex($codGenerico,$codigoComponOAN,$codigoCompoAONDescrip,$solicito,$rol)
    {
        $fecha = Carbon::now()->format('d/m/Y');
        $mensaje = $fecha." ".$solicito;
        if($rol == 'super-admin'){
            $Estatus = 'PROTOTIPO';
        }else{
            $Estatus = 'ALTA';
        }
        if($codigoComponOAN == ""){
            //return "variable vacia";
        }else{
            for ($i=0; $i <count($codigoComponOAN) ; $i++) {

                $insertCompCodGen = DB::table('Art')
                    ->insert([
                        'Articulo' => $codigoComponOAN[$i],
                        'Rama' => 'CODIGOSGENERICOS',
                        'Descripcion1' => strtoupper($codigoCompoAONDescrip[$i]),
                        'CodigoAlterno' => $codigoComponOAN[$i],
                        'UltimoCambio' => $fecha,
                        'Alta' => $fecha,
                        'Mensaje' => $mensaje,
                        'ClaveFabricante' => $codGenerico,
                        'Grupo' => 'CODIGOS GENERICOS COMPONENTES',
                        'Categoria' => 'FABRICACION EN PLANTA',
                        'Familia' => 'DUREX PLANTA',
                        'Linea' => 'DUREX',
                        'Impuesto1' => '16',
                        'Unidad' => 'pza',
                        'UnidadCompra' => 'pza',
                        'UnidadTraspaso' => 'pza',
                        'TipoCosteo' => 'Promedio',
                        'Tipo' => 'Normal',
                        'TipoOpcion' => 'No',
                        'Accesorios' => '0',
                        'Refacciones' => '0',
                        'Sustitutos' => '0',
                        'Servicios' => '0',
                        'Consumibles' => '0',
                        'MonedaCosto' => 'Pesos',
                        'MonedaPrecio' => 'Pesos',
                        'PrecioLista' => '0',
                        'FactorAlterno' => 1,
                        'Estatus' => $Estatus,
                        'Conciliar' => '0',
                        'Usuario' => 'CCRUZ',
                        'Refrigeracion' => '0',
                        'TieneCaducidad' => '0',
                        'BasculaPesar' => '0',
                        'SeProduce' => 1,
                        'EstatusPrecio' => 'NUEVO',
                        'wMostrar' => 1,
                        'SeCompra' => '0',
                        'SeVende' => '0',
                        'EsFormula' => '0',
                        'MultiplosOrdenar' => '1',
                        'AlmacenROP' => 'AON',
                        'CategoriaProd' => 'VARIOS GENERICOS',
                        'ProdCantidad' => '1',
                        'ProdUsuario' => '(Mismo)',
                        'ProdPasoTotal' => '1',
                        'ProdOpciones' => '0',
                        'ProdVerConcentracion' => '0',
                        'ProdVerCostoAcumulado' => '0',
                        'ProdVerMerma' => '0',
                        'ProdVerDesperdicio' => '0',
                        'ProdVerPorcentaje' => '0',
                        'RevisionUsuario' => 'CCRUZ',
                        'ProdMov' => '(por omision)',
                        'EstatusCosto' => 'SINCAMBIO',
                        'SolicitarPrecios' => '0',
                        'Espacios' => '0',
                        'EspaciosEspecificos' => '0',
                        'EspaciosNivel' => 'Dia',
                        'EspaciosMinutos' => '60',
                        'EspaciosBloquearAnteriores' => '1',
                        'SerieLoteInfo' => '0',
                        'FactorCompra' => '1',
                        'ISAN' => '0',
                        'ExcluirDescFormaPago' => '0',
                        'EsDeducible' => '0',
                        'TipoCatalogo' => 'Resurtible',
                        'AnexosAlFacturar' => '0',
                        'Actividades' => '0',
                        'ValidarPresupuestoCompra' => 'No',
                        'SeriesLotesAutoOrden' => '(Empresa)',
                        'LotesFijos' => '0',
                        'LotesAuto' => '0',
                        'TieneDireccion' => '0',
                        'PrecioLiberado' => '0',
                        'ValidarCodigo' => '0',
                        'SincroC' => '1',
                        'CostoIdentificado' => '0',
                        'Impuesto1Excento' => '0',
                        'Excento2' => '0',
                        'Excento3' => '0',
                        'CalcularPresupuesto' => '0',
                        'NivelToleranciaCosto' => '(Empresa)',
                        'Calificacion' => '0',
                        'SAUX' => '0',
                        'SymphonyFamArt' => 'MTO',
                        'ClasificacionInventario' => 'PRODUCTO NACIONAL',
                        'UnidadCantidad' => 1,
                        'FactorGI' => 0,
                        'Temporada' => 'PROYECTO',
                        'ProdMovGrupo' => 'PRODUCTO EN PROCESO',
                        'Costo2013' => 0
                    ]);

            }

        }

    }

    public function revisionDurex()
    {
         $index = db::table('Art')
                ->select('Articulo','Descripcion1','Descripcion2','Linea')
                ->whereIn('Grupo',['CODIGOS GENERICOS','PRODUCTOS TERMINADOS','CODIGOS GENERICOS COMPONENTES'])
                ->where([
                    ['Linea','DUREX'],
                    ['Estatus','PROTOTIPO'],
                    ['Categoria','FABRICACION EN PLANTA'],
                    ['Familia','DUREX PLANTA'],
                    ['Tipo','Normal'],
                ])
                ->get();

        return view('codGenDurex.revisionD', compact('index'));
    }

    public function showDescDurex($articulo)
    {
        $art = db::table('Art')
                    ->select('Articulo','Descripcion1','Descripcion2')
                    ->where('Articulo',$articulo)
                    ->get();

        return view('codGenDurex.showDescD',compact('art'));

    }

    public function updateDescDurex(Request $request, $articulo)
    {
        $solicito = Auth::user()->name;
        $fecha = Carbon::now()->format('d/m/Y');
        $Mensaje = '';
        $mensaje = $fecha." ".$solicito;

        $updateArt = db::table('Art')
                    ->where('Articulo',$articulo)
                    ->update([
                        'Descripcion1' => strtoupper($request->input('desc1Corregida')),
                        'Descripcion2' => strtoupper($request->input('desc2Corregida')),
                        'Estatus' => 'ALTA',
                        'Mensaje' => $mensaje
                    ]);
        return redirect()->route('durex.indexBusqueda');

    }    

       public function eliminarEspaciosDoblesEntrePalabras($cadena)
    {
        $cadenaSindoblesEspacios = preg_replace('/\s+/', ' ', $cadena);
        $largo = strlen($cadenaSindoblesEspacios);
        
        return $cadenaSindoblesEspacios;
    }

}
