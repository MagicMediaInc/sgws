<?php


/**
 * This class defines the structure of the 'horas_billability' table.
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
class HorasBillabilityTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.sgws.map.HorasBillabilityTableMap';

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
		$this->setName('horas_billability');
		$this->setPhpName('HorasBillability');
		$this->setClassname('HorasBillability');
		$this->setPackage('lib.model.sgws');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('CODIGO', 'Codigo', 'INTEGER', true, 11, null);
		$this->addColumn('ANO', 'Ano', 'VARCHAR', false, 4, null);
		$this->addColumn('MES1', 'Mes1', 'VARCHAR', false, 5, null);
		$this->addColumn('MES2', 'Mes2', 'VARCHAR', false, 5, null);
		$this->addColumn('MES3', 'Mes3', 'VARCHAR', false, 5, null);
		$this->addColumn('MES4', 'Mes4', 'VARCHAR', false, 5, null);
		$this->addColumn('MES5', 'Mes5', 'VARCHAR', false, 5, null);
		$this->addColumn('MES6', 'Mes6', 'VARCHAR', false, 5, null);
		$this->addColumn('MES7', 'Mes7', 'VARCHAR', false, 5, null);
		$this->addColumn('MES8', 'Mes8', 'VARCHAR', false, 5, null);
		$this->addColumn('MES9', 'Mes9', 'VARCHAR', false, 5, null);
		$this->addColumn('MES10', 'Mes10', 'VARCHAR', false, 5, null);
		$this->addColumn('MES11', 'Mes11', 'VARCHAR', false, 5, null);
		$this->addColumn('MES12', 'Mes12', 'VARCHAR', false, 5, null);
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

} // HorasBillabilityTableMap
