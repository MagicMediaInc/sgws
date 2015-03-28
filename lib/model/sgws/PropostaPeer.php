<?php


/**
 * Skeleton subclass for performing query and update operations on the 'proposta' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 23/09/2013 18:11:00
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model.sgws
 */
class PropostaPeer extends BasePropostaPeer {
    
    public static function getCodigoVelhio($id)
    {
        $c = new Criteria();
        $c->add(self::CODIGO_VELHIO, $id);
        return self::doSelectOne($c);
    }
    
    public static function lastProposta(){
        $c = new Criteria();
        $c->addDescendingOrderByColumn(self::CODIGO_PROPOSTA);
        
        $rs = self::doSelectOne($c);
        if($rs)
        {
            return $rs->getCodigoSgws();
        }else{
            return false;
        }
        
    }
    
    public static function checkCodigoProjeto($codigoProjeto,$id){
        $c = new Criteria();
        if($id)
        {
            $c->add(self::CODIGO_PROPOSTA, $id, Criteria::NOT_EQUAL);
        }
        $c->add(self::CODIGO_SGWS_PROJETO, $codigoProjeto, Criteria::EQUAL);
        return self::doCount($c);
    }
    
    public static function checkCodigoProposta($codigoProposta,$id){
        $c = new Criteria();
        if($id)
        {
            $c->add(self::CODIGO_PROPOSTA, $id, Criteria::NOT_EQUAL);
        }
        $c->add(self::CODIGO_SGWS, $codigoProposta, Criteria::EQUAL);
        return self::doCount($c);
    }

    public static function getAll()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::CODIGO_PROPOSTA);
        return self::doSelect($c);
    }
    
    public static function getAllOnlyProjetos()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::CODIGO_PROPOSTA);
        $c->add(self::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        return self::doSelect($c);
    }
    
    public static function getFunilVendasProjetos($ano, $sort, $by)
    {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::CODIGO_SGWS_PROJETO);
        $c->addSelectColumn(LxUserPeer::NAME);
        $c->addSelectColumn(CadastroJuridicaPeer::NOME_FANTASIA);
        $c->addSelectColumn(ProjetotipoPeer::TIPO);
        $c->addSelectColumn(self::DATA_IR_PROJETO);
        $c->addSelectColumn(self::VALOR);
        
        if($sort)
        {
            switch ($by) {
                case 'desc':
                    if($sort == 'CODIGO_SGWS_PROJETO')
                    {
                        $c->addDescendingOrderByColumn(self::CODIGO_SGWS_PROJETO);
                    }elseif($sort == 'NAME'){
                        $c->addDescendingOrderByColumn(LxUserPeer::NAME);
                    }elseif($sort == 'NOME_FANTASIA'){
                        $c->addDescendingOrderByColumn(CadastroJuridicaPeer::NOME_FANTASIA);
                    }elseif($sort == 'TIPO'){
                        $c->addDescendingOrderByColumn(ProjetotipoPeer::TIPO);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addDescendingOrderByColumn(self::DATA_IR_PROJETO);
                    }elseif($sort == 'VALOR'){
                        $c->addDescendingOrderByColumn(self::VALOR);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addDescendingOrderByColumn(self::DATA_IR_PROJETO);
                    }                    
                    break;
                default:
                    if($sort == 'CODIGO_SGWS_PROJETO')
                    {
                        $c->addAscendingOrderByColumn(self::CODIGO_SGWS_PROJETO);
                    }elseif($sort == 'NAME'){
                        $c->addAscendingOrderByColumn(LxUserPeer::NAME);
                    }elseif($sort == 'NOME_FANTASIA'){
                        $c->addAscendingOrderByColumn(CadastroJuridicaPeer::NOME_FANTASIA);
                    }elseif($sort == 'TIPO'){
                        $c->addAscendingOrderByColumn(ProjetotipoPeer::TIPO);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addAscendingOrderByColumn(self::DATA_IR_PROJETO);
                    }elseif($sort == 'VALOR'){
                        $c->addAscendingOrderByColumn(self::VALOR);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addAscendingOrderByColumn(self::DATA_IR_PROJETO);
                    }
                    
                    break;
            }
        }else{
            $c->addAscendingOrderByColumn(self::CODIGO_SGWS_PROJETO);
        }
        
        
        
        $c->add(self::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        $c->addJoin(self::GERENTE, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
        // $c->addJoin(self::RESPONSABLE_COMERCIAL, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
        $c->addJoin(self::CLIENTE, CadastroJuridicaPeer::ID_EMPRESA, Criteria::INNER_JOIN);
        $c->addJoin(self::CODIGO_TIPO, ProjetotipoPeer::CODIGOTIPO, Criteria::LEFT_JOIN);
        
        $inicio   = $ano.'-01-01';
        $fim      = $ano.'-12-31';
        $cFecha = $c->getNewCriterion(self::DATA_IR_PROJETO, $inicio,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(self::DATA_IR_PROJETO, $fim, Criteria::LESS_EQUAL));
        $c->add($cFecha);
        
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        
        while($res = $rs->fetch()) {
            // var_dump($res['RESPONSABLE_COMERCIAL']);
            $dato['projeto'] = $res['CODIGO_SGWS_PROJETO'];
            $dato['gerente'] = $res['NAME'] ;
            // $dato['comercial'] = $res['RESPONSABLE_COMERCIAL'] ;
            $dato['cliente'] = $res['NOME_FANTASIA'] ;
            $dato['tipo'] = $res['TIPO'] ;
            $dato['data'] = date("d-m-Y", strtotime($res['DATA_IR_PROJETO'])) ;
            $dato['valor'] = $res['VALOR'] ;
            $datos[] = $dato;
        }
        if(!empty($datos))
        {
            return $datos;
        }else{
            return false;
        }
    }
    
    public static function getPropostasHot($sort,$by)
    {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::CODIGO_SGWS);
        $c->addSelectColumn(LxUserPeer::NAME);
        $c->addSelectColumn(CadastroJuridicaPeer::NOME_FANTASIA);
        $c->addSelectColumn(ProjetotipoPeer::TIPO);
        $c->addSelectColumn(self::VALOR);
        $c->addSelectColumn(self::DATA_INICIO);
        
        
        if($sort)
        {
            switch ($by) {
                case 'desc':
                    if($sort == 'CODIGO_SGWS')
                    {
                        $c->addDescendingOrderByColumn(self::CODIGO_SGWS);
                    }elseif($sort == 'NAME'){
                        $c->addDescendingOrderByColumn(LxUserPeer::NAME);
                    }elseif($sort == 'NOME_FANTASIA'){
                        $c->addDescendingOrderByColumn(CadastroJuridicaPeer::NOME_FANTASIA);
                    }elseif($sort == 'TIPO'){
                        $c->addDescendingOrderByColumn(ProjetotipoPeer::TIPO);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addDescendingOrderByColumn(self::DATA_IR_PROJETO);
                    }elseif($sort == 'VALOR'){
                        $c->addDescendingOrderByColumn(self::VALOR);
                    }elseif($sort == 'DATA_INICIO'){
                        $c->addDescendingOrderByColumn(self::DATA_INICIO);
                    }                    
                    break;
                default:
                    if($sort == 'CODIGO_SGWS')
                    {
                        $c->addAscendingOrderByColumn(self::CODIGO_SGWS);
                    }elseif($sort == 'NAME'){
                        $c->addAscendingOrderByColumn(LxUserPeer::NAME);
                    }elseif($sort == 'NOME_FANTASIA'){
                        $c->addAscendingOrderByColumn(CadastroJuridicaPeer::NOME_FANTASIA);
                    }elseif($sort == 'TIPO'){
                        $c->addAscendingOrderByColumn(ProjetotipoPeer::TIPO);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addAscendingOrderByColumn(self::DATA_IR_PROJETO);
                    }elseif($sort == 'VALOR'){
                        $c->addAscendingOrderByColumn(self::VALOR);
                    }elseif($sort == 'DATA_INICIO'){
                        $c->addAscendingOrderByColumn(self::DATA_INICIO);
                    }
                    
                    break;
            }
        }else{
            $c->addAscendingOrderByColumn(self::CODIGO_SGWS);
        }
        
        $c->add(self::ID_STATUS_PROPOSTA, 1, Criteria::EQUAL); // Proposta
        $c->add(self::ID_NEGOCIACAO, 2, Criteria::EQUAL); // Hot
        
        $c->addJoin(self::GERENTE, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
        $c->addJoin(self::CLIENTE, CadastroJuridicaPeer::ID_EMPRESA, Criteria::INNER_JOIN);
        $c->addJoin(self::CODIGO_TIPO, ProjetotipoPeer::CODIGOTIPO, Criteria::LEFT_JOIN);
        
        
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        
        while($res = $rs->fetch()) {
            $dato['proposta'] = $res['CODIGO_SGWS'];
            $dato['gerente'] = $res['NAME'] ;
            $dato['cliente'] = $res['NOME_FANTASIA'] ;
            $dato['tipo'] = $res['TIPO'] ;
            $dato['valor'] = $res['VALOR'] ;
            $dato['data'] = $res['DATA_INICIO'] ;            
            $datos[] = $dato;
        }
        if(!empty($datos))
        {
            return $datos;
        }else{
            return false;
        }
    }
    
    public static function getPropostasEnNegociacao($ano, $sort, $by)
    {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::CODIGO_SGWS);
        $c->addSelectColumn(LxUserPeer::NAME);
        $c->addSelectColumn(CadastroJuridicaPeer::NOME_FANTASIA);
        $c->addSelectColumn(ProjetotipoPeer::TIPO);
        $c->addSelectColumn(self::VALOR);
        $c->addSelectColumn(self::DATA_INICIO);
        
        
        if($sort)
        {
            switch ($by) {
                case 'desc':
                    if($sort == 'CODIGO_SGWS')
                    {
                        $c->addDescendingOrderByColumn(self::CODIGO_SGWS);
                    }elseif($sort == 'NAME'){
                        $c->addDescendingOrderByColumn(LxUserPeer::NAME);
                    }elseif($sort == 'NOME_FANTASIA'){
                        $c->addDescendingOrderByColumn(CadastroJuridicaPeer::NOME_FANTASIA);
                    }elseif($sort == 'TIPO'){
                        $c->addDescendingOrderByColumn(ProjetotipoPeer::TIPO);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addDescendingOrderByColumn(self::DATA_IR_PROJETO);
                    }elseif($sort == 'VALOR'){
                        $c->addDescendingOrderByColumn(self::VALOR);
                    }elseif($sort == 'DATA_INICIO'){
                        $c->addDescendingOrderByColumn(self::DATA_INICIO);
                    }                    
                    break;
                default:
                    if($sort == 'CODIGO_SGWS')
                    {
                        $c->addAscendingOrderByColumn(self::CODIGO_SGWS);
                    }elseif($sort == 'NAME'){
                        $c->addAscendingOrderByColumn(LxUserPeer::NAME);
                    }elseif($sort == 'NOME_FANTASIA'){
                        $c->addAscendingOrderByColumn(CadastroJuridicaPeer::NOME_FANTASIA);
                    }elseif($sort == 'TIPO'){
                        $c->addAscendingOrderByColumn(ProjetotipoPeer::TIPO);
                    }elseif($sort == 'DATA_IR_PROJETO'){
                        $c->addAscendingOrderByColumn(self::DATA_IR_PROJETO);
                    }elseif($sort == 'VALOR'){
                        $c->addAscendingOrderByColumn(self::VALOR);
                    }elseif($sort == 'DATA_INICIO'){
                        $c->addAscendingOrderByColumn(self::DATA_INICIO);
                    }
                    
                    break;
            }
        }else{
            $c->addAscendingOrderByColumn(self::CODIGO_SGWS);
        }
        
        $c->add(self::ID_STATUS_PROPOSTA, 1, Criteria::EQUAL); // Proposta
        $c->add(self::ID_NEGOCIACAO, 3, Criteria::EQUAL); // Em Negociação
        
        $c->addJoin(self::GERENTE, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
        $c->addJoin(self::CLIENTE, CadastroJuridicaPeer::ID_EMPRESA, Criteria::INNER_JOIN);
        $c->addJoin(self::CODIGO_TIPO, ProjetotipoPeer::CODIGOTIPO, Criteria::LEFT_JOIN);
        
        $inicio   = $ano.'-01-01';
        $fim      = $ano.'-12-31';
        $cFecha = $c->getNewCriterion(self::DATA_INICIO, $inicio,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(self::DATA_INICIO, $fim, Criteria::LESS_EQUAL));
        $c->add($cFecha);
        
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        
        while($res = $rs->fetch()) {
            $dato['proposta'] = $res['CODIGO_SGWS'];
            $dato['gerente'] = $res['NAME'] ;
            $dato['cliente'] = $res['NOME_FANTASIA'] ;
            $dato['tipo'] = $res['TIPO'] ;
            $dato['valor'] = $res['VALOR'] ;
            $dato['data'] = date('d-m-Y', strtotime($res['DATA_INICIO'])) ;            
            $datos[] = $dato;
        }
        if(!empty($datos))
        {
            return $datos;
        }else{
            return false;
        }
    }
    
    public static function getAllProjetos($status = null, $buscador = null)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::CODIGO_PROPOSTA);
        $c->add(self::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        $c->addJoin(self::GERENTE, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
        $c->addJoin(self::CLIENTE, CadastroJuridicaPeer::ID_EMPRESA, Criteria::INNER_JOIN);
        if($status)
        {
            $c->add(PropostaPeer::STATUS, $status, Criteria::EQUAL);
        }
        if($buscador)
        {
            $criterio = $c->getNewCriterion(LxUserPeer::NAME, '%'.$buscador.'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%'.$buscador.'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%'.$buscador.'%', Criteria::LIKE));
            $c->add($criterio);
        }
        $c->addAscendingOrderByColumn(self::CODIGO_SGWS_PROJETO);
        
        return self::doSelect($c);
    }
    
    public static function getAllGerentes()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::GERENTE);
        $c->addGroupByColumn(self::GERENTE);
        return self::doSelect($c);
    }
    
    public static function getAllRegistros()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(self::CODIGO_PROPOSTA);
        
        return self::doSelect($c);
    }
    

    public static function actualizaGerente($cod_velhio, $nvo)
    {
  	$con = Propel::getConnection();

	// select from...
	$c1 = new Criteria();
	$c1->add(self::GERENTE,$cod_velhio, Criteria::EQUAL);

	// update set
	$c2 = new Criteria();
	$c2->add(self::GERENTE, $nvo);

	BasePeer::doUpdate($c1, $c2, $con);
    }
    
    public static function getDataByCodProjeto($codProjeto)
    {
        $c = new Criteria();
        $c->add(self::CODIGO_PROJETO, $codProjeto, Criteria::EQUAL);
        //$c->add(self::CODIGO_PROPOSTA, $codProjeto, Criteria::EQUAL);
        return self::doSelectOne($c);
    }
    
    protected static function inicialize($codProjeto)
    {
        $c = new Criteria();
        //$c->add(self::CODIGO_PROJETO, $codProjeto, Criteria::EQUAL);
        $c->add(self::CODIGO_PROPOSTA, $codProjeto, Criteria::EQUAL);
        return $c;
    }

    public static function getGerenteProjeto($codProjeto)
    {
        $c = self::inicialize($codProjeto);
        $rs = self::doSelectOne($c);
        return $rs->getGerente();
    }
    
    public static function getCodSgwsProjeto($codProjeto)
    {
        $c = new Criteria();
        $c->add(self::CODIGO_PROJETO, $codProjeto, Criteria::EQUAL);
        $rs = self::doSelectOne($c);
        if($rs){
        return $rs->getCodigoSgwsProjeto();
        } else{
            $dato = "";
            return $dato;
        }
    }

    public static function actualizaCliente($cod_velhio, $nvo)
    {
  	$con = Propel::getConnection();

	// select from...
	$c1 = new Criteria();
	$c1->add(self::CLIENTE,$cod_velhio, Criteria::EQUAL);

	// update set
	$c2 = new Criteria();
	$c2->add(self::CLIENTE, $nvo);

	BasePeer::doUpdate($c1, $c2, $con);
    }
    
    public static function getComboProjetosFinanciero() {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::CODIGO_PROJETO);
        $c->addSelectColumn(self::CODIGO_SGWS_PROJETO);
        $c->addSelectColumn(self::NOME_PROPOSTA);
        //Condicion
        $c->add(self::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        $c->add(self::STATUS, 4, Criteria::EQUAL); // En andamento
        $c->addGroupByColumn(self::CODIGO_PROJETO);
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        $c->addDescendingOrderByColumn(self::CODIGO_SGWS_PROJETO);
        $dato = array();
        while($res = $rs->fetch()) {
            $dato[$res['CODIGO_PROJETO']] = $res['CODIGO_SGWS_PROJETO'].' - '.substr($res['NOME_PROPOSTA'], 0, 100) ;
        }
        return $dato;
    }
    
    
        public static function getComboProjetoEntrada($idProjeto) {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::CODIGO_PROJETO);
        $c->addSelectColumn(self::CODIGO_SGWS_PROJETO);
        $c->addSelectColumn(self::NOME_PROPOSTA);
        //Condicion
        $c->add(self::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        $c->add(self::CODIGO_PROJETO, $idProjeto, Criteria::EQUAL);
        $c->add(self::STATUS, 4, Criteria::EQUAL); // En andamento
        $c->addGroupByColumn(self::CODIGO_PROJETO);
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $dato = array();
        $res = $rs->fetch();
            $dato[$res['CODIGO_PROJETO']] = $res['CODIGO_SGWS_PROJETO'].' - '.substr($res['NOME_PROPOSTA'], 0, 100) ;
        return $dato;
    }
    
    public static function getPropostasEmitidas($ano, $mes, $tipoServicio = null) {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::VALOR);
        //Condicion
        $inicio   = $ano.'-'.$mes.'-01';
        $fim      = $ano.'-'.$mes.'-30';
        $cFecha = $c->getNewCriterion(self::DATA_INICIO, $inicio,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(self::DATA_INICIO, $fim, Criteria::LESS_EQUAL));
        $c->add($cFecha);
        if($tipoServicio)
        {
            $c->add(self::CODIGO_TIPO, $tipoServicio, Criteria::EQUAL);
        }
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $total = 0;
        $con = 0;
        while($res = $rs->fetch()) {
            $total = $total + $res['VALOR'];
            $con++;
        }
        if($total)
        {
            $valor_emitido = $total / $con;
        }else{
            $valor_emitido = $total;
        }
        return array('cantidad' => $con, 'total' => $total, 'valor_medio_emitido' => $valor_emitido);
    }
    
    public static function getTipoServicioAnoMes($ano, $mes) {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(ProjetotipoPeer::CODIGOTIPO);
        $c->addSelectColumn(ProjetotipoPeer::TIPO);
        
        //Condicion
        $inicio   = $ano.'-'.$mes.'-01';
        $fim      = $ano.'-'.$mes.'-30';
        $cFecha = $c->getNewCriterion(self::DATA_INICIO, $inicio,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(self::DATA_INICIO, $fim, Criteria::LESS_EQUAL));
        $c->add($cFecha);
        
        $c->addJoin(self::TIPO, ProjetotipoPeer::CODIGOTIPO, Criteria::LEFT_JOIN);
        $c->addGroupByColumn(self::CODIGO_TIPO);
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $total = 0;
        $con = 0;
        while($res = $rs->fetch()) {
            $data['id'] = $res['CODIGOTIPO'];
            $data['tipo'] = $res['TIPO'];
            $datos[] = $data;
        }
        
        return $datos;
    }
    
    public static function getPropostasVendidas($ano, $mes,  $tipoServicio = null) {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::VALOR);
        //Condicion
        $inicio   = $ano.'-'.$mes.'-01';
        $fim      = $ano.'-'.$mes.'-30';
        $cFecha = $c->getNewCriterion(self::DATA_IR_PROJETO, $inicio,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(self::DATA_IR_PROJETO, $fim, Criteria::LESS_EQUAL));
        $c->add($cFecha);
        if($tipoServicio)
        {
            $c->add(self::CODIGO_TIPO, $tipoServicio, Criteria::EQUAL);
        }
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $total = 0;
        $con = 0;
        while($res = $rs->fetch()) {
            $total = $total + $res['VALOR'];
            $con++;
        }
        if($total)
        {
            $valor_emitido = $total / $con;
        }else{
            $valor_emitido = $total;
        }
        
        return array('cantidad' => $con, 'total' => $total, 'valor_medio_vendido' => $valor_emitido);
    }
    
    public static function getMeusProjetos($id_gerente) {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::CODIGO_PROJETO);
        $c->addSelectColumn(self::CODIGO_SGWS_PROJETO);
        $c->addSelectColumn(self::NOME_PROPOSTA);
        //Condicion
        $c->add(self::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        $c->add(self::STATUS, 4, Criteria::EQUAL); // En andamento
        if(!aplication_system::esSocio())
        {
            $c->add(self::GERENTE, $id_gerente, Criteria::EQUAL);
        }
        
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        
        while($res = $rs->fetch()) {
            $dato['id'] = $res['CODIGO_PROJETO'];
            $dato['codigo_sgws_projeto'] = $res['CODIGO_SGWS_PROJETO'];
            $dato['nome'] = $res['NOME_PROPOSTA'] ;
            $datos[] = $dato;
        }
        if(!empty($datos))
        {
            return $datos;
        }else{
            return FALSE;
        }
        
    }
    
    public static function getConsolidadoProjetos($status = null, $buscador = null) {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::CODIGO_PROJETO);
        $c->addSelectColumn(self::CODIGO_SGWS_PROJETO);
        $c->addSelectColumn(LxUserPeer::NAME);
        $c->addSelectColumn(CadastroJuridicaPeer::NOME_FANTASIA);
        $c->addSelectColumn(self::VALOR);
        $c->addSelectColumn(self::VALOR_PREV_HH);
        $c->addJoin(self::GERENTE, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
        $c->addJoin(self::CLIENTE, CadastroJuridicaPeer::ID_EMPRESA, Criteria::INNER_JOIN);
        //Condicion
        if($status)
        {
            $c->add(PropostaPeer::STATUS, $status, Criteria::EQUAL);
        }
        if($buscador)
        {
            $criterio = $c->getNewCriterion(LxUserPeer::NAME, '%'.$buscador.'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%'.$buscador.'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%'.$buscador.'%', Criteria::LIKE));
            $c->add($criterio);
        }
        $c->add(self::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        $c->addAscendingOrderByColumn(self::CODIGO_SGWS_PROJETO);
        //Ejecucion de consulta
        
        //$c->setLimit(4);
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        
        while($res = $rs->fetch()) {
            $dato['id'] = $res['CODIGO_PROJETO'];
            $dato['codigo_sgws_projeto'] = $res['CODIGO_SGWS_PROJETO'];
            $dato['gerente'] = $res['NAME'] ;
            $dato['cliente'] = $res['NOME_FANTASIA'] ;
            $dato['valor'] = $res['VALOR'] ;
            $dato['valor_hh'] = $res['VALOR_PREV_HH'] ;
            $datos[] = $dato;
        }
        if(!empty($datos))
        {
            return $datos;
        }else{
            return false;
        }
        
    }
    
    public static function getNumMeusProjetos($id_gerente) {
        $c =  new Criteria();
        //Condicion
        $c->add(self::GERENTE, $id_gerente, Criteria::EQUAL);
        $c->add(self::STATUS, 4, Criteria::EQUAL);
        return self::doCount($c);
    }
    
    public static function getRelatorioEmitidas($ano, $mes)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::ID_NEGOCIACAO);
        $c->addSelectColumn(self::VALOR);
        
        $inicio   = $ano.'-'.$mes.'-01';
        $fim      = $ano.'-'.$mes.'-30';
        $cFecha = $c->getNewCriterion(self::DATA_INICIO, $inicio,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(self::DATA_INICIO, $fim, Criteria::LESS_EQUAL));
        $c->add($cFecha);
        
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $con = 0;
        $hot = 0;
        $neg = 0;
        $valor = 0;
        while($res = $rs->fetch()) {
            $con = $con + 1;
            $valor = $valor + $res['VALOR'];
            if($res['ID_NEGOCIACAO'] == 2)
            {
                //Hot
                $hot = $hot + 1;
            }
            if($res['ID_NEGOCIACAO'] == 3)
            {
                //Negociacion
                $neg = $neg + 1;
            }
        }
        $datos['emitidas'] = $con;
        $datos['hot'] = $hot;
        $datos['negociacao'] = $neg;
        $datos['valor'] = $valor;
        return $datos;
        
    }
    
    
    
    public static function getRelatorioVendidas($ano, $mes)
    {
        $c = new Criteria();
        $c->clearSelectColumns();
        //Selecciona las columnas
        $c->addSelectColumn(self::VALOR);
        $inicio   = $ano.'-'.$mes.'-01';
        $fim      = $ano.'-'.$mes.'-30';
        $cFecha = $c->getNewCriterion(self::DATA_IR_PROJETO, $inicio,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(self::DATA_IR_PROJETO, $fim, Criteria::LESS_EQUAL));
        $c->add($cFecha);
        
        //Ejecucion de consulta
        $rs = self::doSelectStmt($c);
        //Se recuperan los registros y se genera arreglo
        $con = 0;
        $valor = 0;
        while($res = $rs->fetch()) {
            $con = $con + 1;
            $valor = $valor + $res['VALOR'];
        }
        $datos['emitidas'] = $con;
        $datos['valor'] = $valor;
        return $datos;
        
    }
    
    public static function getPropostasNameUser($arrayIdUsers)
    {
        $c = new Criteria();
        $c->add(self::GERENTE, $arrayIdUsers, Criteria::IN);
        
        return self::doSelect($c);
    }
    
    public static function getProjetoUltimo()
    {
        $c =  new Criteria();
        //Eliminamos la columnas de seleccion en caso de que esten definidas
        $c->clearSelectColumns();
        //Selecciona las columnas
        //$c->addSelectColumn(PropostaPeer::CODIGO_SGWS_PROJETO);
        //Condicion
        $c->add(PropostaPeer::ID_STATUS_PROPOSTA, 2, Criteria::EQUAL);
        //Ejecucion de consulta
        $sortTemp = PropostaPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $sort = $sortTemp[3];      // Nombre del campo que por defecto se ordenara
 
        $c->addDescendingOrderByColumn($sort);
        return self::doSelectOne($c);
    }
    
    	public static function retrieveByCodeProjecto($pk)
	{

		
		$criteria = new Criteria();
		$criteria->add(PropostaPeer::CODIGO_PROJETO, $pk);

		$v = PropostaPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}
} // PropostaPeer
