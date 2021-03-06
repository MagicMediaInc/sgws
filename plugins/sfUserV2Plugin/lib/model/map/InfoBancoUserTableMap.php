<?php


/**
 * This class defines the structure of the 'info_banco_user' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 03/04/2014 12:04:39
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfUserV2Plugin.lib.model.map
 */
class InfoBancoUserTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfUserV2Plugin.lib.model.map.InfoBancoUserTableMap';

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
		$this->setName('info_banco_user');
		$this->setPhpName('InfoBancoUser');
		$this->setClassname('InfoBancoUser');
		$this->setPackage('plugins.sfUserV2Plugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID_INFO_BANCO', 'IdInfoBanco', 'INTEGER', true, 11, null);
		$this->addForeignKey('ID_USER', 'IdUser', 'INTEGER', 'lx_user', 'ID_USER', true, 11, null);
		$this->addForeignKey('ID_BANCO', 'IdBanco', 'INTEGER', 'banco', 'ID_BANCO', true, 11, null);
		$this->addColumn('TITULAR', 'Titular', 'VARCHAR', true, 30, null);
		$this->addColumn('AGENCIA', 'Agencia', 'VARCHAR', true, 30, null);
		$this->addColumn('NUMERO_CONTA', 'NumeroConta', 'VARCHAR', true, 30, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('LxUser', 'LxUser', RelationMap::MANY_TO_ONE, array('id_user' => 'id_user', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Banco', 'Banco', RelationMap::MANY_TO_ONE, array('id_banco' => 'id_banco', ), 'RESTRICT', 'RESTRICT');
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

} // InfoBancoUserTableMap
