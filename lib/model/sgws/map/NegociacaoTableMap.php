<?php


/**
 * This class defines the structure of the 'negociacao' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 03/04/2014 12:04:42
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.sgws.map
 */
class NegociacaoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.sgws.map.NegociacaoTableMap';

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
		$this->setName('negociacao');
		$this->setPhpName('Negociacao');
		$this->setClassname('Negociacao');
		$this->setPackage('lib.model.sgws');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID_NEGOCIACAO', 'IdNegociacao', 'INTEGER', true, 11, null);
		$this->addColumn('NOME', 'Nome', 'VARCHAR', true, 50, null);
		$this->addColumn('STATUS', 'Status', 'CHAR', true, null, null);
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

} // NegociacaoTableMap
