<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use Carbon\Carbon;
use App\Http\Requests\CreateCodGenBakanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CodGenericoBakanController extends Controller
{
    
    public function create()
    {   


        $codigo = DB::select("SELECT top 1 Articulo FROM Art WHERE Articulo LIKE 'GBAKAN%' ORDER BY Articulo DESC");
        $string = $codigo[0]->Articulo;
        //return $string;
        $parteLetras = substr($string,-14,9);
        //return $parteLetras;
        $parteNumero = substr($string, -6, 7)+1; 
        //return $parteNumero;
        $codigoAsignado = $parteLetras.$parteNumero;
        //return $codigoAsignado;
        $rutas = DB::TABLE('ProdRuta')
                ->SELECT('Ruta','Descripcion')
                ->WHERE('Categoria','CARPINTERIA')
                ->GET();

        return view('codGenBakan.create',compact('codigoAsignado','rutas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();

        $ptxAsignado = strtoupper($request->input('ptxAsignado'));
        $codGenerico = strtoupper($request->input('codGenerico'));
        $des1CodGenerico = strtoupper($request->input('des1CodGenerico'));
        $des2CodGenerico = strtoupper($request->input('des2CodGenerico'));
        $codigoComponCasco = $request->input('codigoComponCasco');
        $codigoCompoCascoDescrip = $request->input('codigoCompoCascoDescrip');
        $codigoComponOAN = $request->input('codigoComponOAN');
        $codigoCompoAONDescrip = $request->input('codigoCompoAONDescrip');
        $rutaCasco = $request->input('ruta');
        //$solicito = strtoupper($request->input('solicito'));
        $solicito = Auth::user()->name;
        $user = Auth::user();
        $rol = $user->roles->implode('name',', ');

        $insertCodGenMetodo = $this->insertCodGen($codGenerico,$des1CodGenerico,$des2CodGenerico,$solicito,$rol);
        $updatePTASignadoMetodo = $this->updatePTAsig($ptxAsignado,$codGenerico);
        $insertCompCascoCodGenMetodo = $this->insertCompCascoCodGen($codGenerico,$codigoComponCasco,$codigoCompoCascoDescrip,$solicito,$rol,$rutaCasco);
        $insertCompAonCodGenMetodo = $this->insertCompAonCodGen($codGenerico,$codigoComponOAN,$codigoCompoAONDescrip,$solicito,$rol);

        $index = db::table('Art')
                ->select('Articulo','Descripcion1','Descripcion2','ClaveFabricante','CodigoAlterno','Linea')
                ->where('ClaveFabricante',$codGenerico)
                ->get();

        Cache::flush();        
        return view('codGenBakan.index',compact('index'));
        
    }

    public function getArticulo()
    {
        $ptxAsignado = $_GET["ptxAsignado"];
        $articulo = DB::table("Art")
            ->select("Articulo","Descripcion1","Descripcion2","ClaveFabricante","CodigoAlterno")
            ->where("Articulo",$ptxAsignado)
            ->where("Grupo","PRODUCTOS TERMINADOS")
            ->get();
            return $articulo;

    }

    public function updatePTAsig($pt,$codGenerico)
    {
        $updatePTAsignado = db::table('Art')->where('Articulo',$pt)->update([
                            'ClaveFabricante'=>$codGenerico,
                            'CodigoAlterno'=>$codGenerico]);

    }

    public function insertCodGen($codGenerico,$des1CodGenerico,$des2CodGenerico,$solicito,$rol)
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
                        'Familia' => 'BAKAN PLANTA',
                        'Linea' => 'BAKAN',
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

    public function insertCompCascoCodGen($codGenerico,$codigoComponCasco,$codigoCompoCascoDescrip,$solicito,$rol,$rutaCasco)
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
                        'Familia' => 'BAKAN PLANTA',
                        'Linea' => 'BAKAN',
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
                        'AlmacenROP' => $rutaCasco[$i],
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

    public function insertCompAonCodGen($codGenerico,$codigoComponOAN,$codigoCompoAONDescrip,$solicito,$rol)
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
                        'Familia' => 'BAKAN PLANTA',
                        'Linea' => 'BAKAN',
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
                        'ProdMovGrupo' => 'PRODUCTO EN PROCESO',
                        'Costo2013' => 0
                    ]);

            }

        }

    }

    public function indexBusqueda()
    {

        // if (Cache::has('codBakan.all')) {
        //     $index = Cache::get('codBakan.all');
        // }else{

            $index = db::table('Art')
                ->select('Articulo','Descripcion1','Descripcion2','ClaveFabricante','CodigoAlterno','Linea','Mensaje')
                ->whereIn('Grupo',['CODIGOS GENERICOS','PRODUCTOS TERMINADOS','CODIGOS GENERICOS COMPONENTES'])
                ->where([
                    ['Linea','BAKAN'],
                    ['Estatus','ALTA'],
                    ['Categoria','FABRICACION EN PLANTA'],
                    ['Familia','BAKAN PLANTA'],
                    ['Tipo','Normal'],
                ])
                ->get();
        //     Cache::put('codBakan.all',$index,7200);
                
        // }                
        // return $index;
        return view ('codGenBakan.indexBusqueda',compact('index'));
    }

    public function revisionBakan()
    {   
        if (Cache::has('revBakan.all')) {
            $index = Cache::get('revBakan.all');
        }else{
            $index = db::table('Art')
                ->select('Articulo','Descripcion1','Descripcion2','Linea')
                ->whereIn('Grupo',['CODIGOS GENERICOS','CODIGOS GENERICOS COMPONENTES'])
                ->where([
                    ['Linea','BAKAN'],
                    ['Estatus','PROTOTIPO'],
                    ['Categoria','FABRICACION EN PLANTA'],
                    ['Familia','BAKAN PLANTA'],
                    ['Tipo','Normal'],
                ])
                ->get();
            Cache::put('revBakan.all',$index, 7200);    
        }        

        return view('codGenBakan.revisionB', compact('index'));
    }

    public function updateRevision(Request $request)
    {
        $idCheck = $request->input('idCheck');
        $solicito = Auth::user()->name;
        $fecha = Carbon::now()->format('d/m/Y');
        $Mensaje = '';

        $articulo = db::table('Art')
                    ->select('Articulo','Descripcion1','Estatus','Mensaje')
                    ->where('Articulo',$idCheck)
                    ->get();
                    
        $mensaje ='REV.'.$solicito.' '.$fecha;
        
        $updateArt = db::table('Art')
                    ->where('Articulo',$idCheck)
                    ->update([
                        'Estatus' => 'ALTA',
                        'Mensaje' => $mensaje
                    ]);
        Cache::flush();                       
        return "ok";

    }

    public function showDescBakan($articulo)
    {
        $art = db::table('Art')
                    ->select('Articulo','Descripcion1','Descripcion2')
                    ->where('Articulo',$articulo)
                    ->get();

        return view('codGenBakan.showDesc',compact('art'));

    }

    public function updateDescBakan(Request $request, $articulo)
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
        Cache::flush();                       
        return redirect()->route('bakan.indexBusqueda');

    }    

    public function indexAddComGenBakan()
    {
        if (Cache::has('AddCodGenBakan.all')) {
            $index = Cache::get('AddCodGenBakan.all');
        }else{

            $index = db::table('Art')
                ->select('Articulo','Descripcion1','Descripcion2','ClaveFabricante','CodigoAlterno','Linea','Grupo')
                ->where([
                    ['Rama','CODIGOSGENERICOS'],
                    ['Grupo','CODIGOS GENERICOS'],
                    ['Linea','BAKAN'],
                    ['Estatus','ALTA'],
                    ['Categoria','FABRICACION EN PLANTA'],
                    ['Familia','BAKAN PLANTA'],
                    ['Tipo','Normal'],
                ])
                ->get();
            Cache::put('AddCodGenBakan.all',$index,7200);
                
        }    

        return view ('codGenBakan.indexAddCompGenBakan',compact('index'));
    }

    public function showAddComGenBakan($art)
    {
        $getArticulo = DB::table('Art')
            ->select('Articulo','Descripcion1','Descripcion2','claveFabricante')
            ->where('Articulo',$art)
            ->get();

        $getCompArticulos = DB::table('Art')
            ->select('Articulo','Descripcion1','Descripcion2','claveFabricante')    
            ->where('Estatus','ALTA')
            ->where('ClaveFabricante',$art)
            ->whereNotIn('Articulo',[$art])
            ->whereNotIn('GRUPO',['PRODUCTOS TERMINADOS'])
            ->get();

            
        return view ('codGenBakan.showAddCompGenBakan',compact('getArticulo','getCompArticulos'));
    }

    public function getRutas()
    {

        $rutas = DB::TABLE('ProdRuta')
                ->SELECT('Ruta','Descripcion')
                ->WHERE('Categoria','CARPINTERIA')
                ->GET();
                

        echo '<select class="form-control form-control-sm" name="ruta[]">
                <option value="">Selecciona una opción...</option>';
                foreach ($rutas as $ruta) {
                    echo '<option value="'.$ruta->Ruta.'">'.$ruta->Ruta.'--'.$ruta->Descripcion.'</option>';
                }
        echo '</select>';

        // return $rutas;        

    }

}
