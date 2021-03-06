<?php


/**
 * This class defines the structure of the 'pedidos' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 03/04/2014 12:04:43
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.sgws.map
 */
class PedidosTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.sgws.map.PedidosTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('pedidos');
		$this->setPhpName('Pedidos');
		$this->setClassname('Pedidos');
		$this->setPackage('lib.model.sgws');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('ID_CLIENTE', 'IdCliente', 'INTEGER', false, 11, 0);
		$this->addColumn('ID_PROJETO', 'IdProjeto', 'INTEGER', true, 11, null);
		$this->addColumn('NUMERO_PEDIDO', 'NumeroPedido', 'VARCHAR', false, 20, null);
		$this->addColumn('STATUS', 'Status', 'VARCHAR', false, 35, '');
		$this->addColumn('DATA', 'Data', 'DATE', false, null, null);
		$this->addColumn('VALOR', 'Valor', 'DECIMAL', false, 10, 0);
		$this->addColumn('DESCONTO', 'Desconto', 'FLOAT', false, 9, 0);
		$this->addColumn('FORMA_PAGAMENTO', 'FormaPagamento', 'VARCHAR', false, 50, '');
		$this->addColumn('PESO', 'Peso', 'FLOAT', false, 9, 0);
		$this->addColumn('CARTAO', 'Cartao', 'VARCHAR', false, 20, '');
		$this->addColumn('NUM_CARTAO', 'NumCartao', 'VARCHAR', false, 20, '');
		$this->addColumn('VENC_CARTAO', 'VencCartao', 'VARCHAR', false, 4, '');
		$this->addColumn('NOME_CARTAO', 'NomeCartao', 'VARCHAR', false, 40, '');
		$this->addColumn('CODS_CARTAO', 'CodsCartao', 'VARCHAR', false, 4, '');
		$this->addColumn('PARCELAS', 'Parcelas', 'TINYINT', false, 4, 1);
		$this->addColumn('DATA_PAG', 'DataPag', 'DATE', false, null, null);
                $this->addColumn('LOJA', 'loja', 'INTEGER', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // PedidosTableMap
