<?php


/**
 * This class defines the structure of the 'pedido_items' table.
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
class PedidoItemsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.sgws.map.PedidoItemsTableMap';

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
		$this->setName('pedido_items');
		$this->setPhpName('PedidoItems');
		$this->setClassname('PedidoItems');
		$this->setPackage('lib.model.sgws');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('ID_PEDIDO', 'IdPedido', 'INTEGER', false, 11, null);
		$this->addColumn('ID_PRODUCTO', 'IdProducto', 'INTEGER', false, 11, null);
		$this->addColumn('NUMERO_PEDIDO', 'NumeroPedido', 'VARCHAR', false, 20, null);
		$this->addColumn('NOME', 'Nome', 'VARCHAR', false, 60, null);
		$this->addColumn('QT', 'Qt', 'TINYINT', false, 4, 1);
		$this->addColumn('PRECO', 'Preco', 'DECIMAL', false, 10, null);
		$this->addColumn('PESO', 'Peso', 'FLOAT', false, 9, null);
		$this->addColumn('PRECO_BOLETO', 'PrecoBoleto', 'DECIMAL', false, 10, 0);
		$this->addColumn('DESCONTO', 'Desconto', 'TINYINT', false, 4, 0);
		$this->addColumn('DESCONTO_BOLETO', 'DescontoBoleto', 'TINYINT', false, 4, 0);
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

} // PedidoItemsTableMap
