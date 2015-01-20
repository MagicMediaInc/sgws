<?php


/**
 * This class defines the structure of the 'lx_privilege' table.
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
class LxPrivilegeTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfUserV2Plugin.lib.model.map.LxPrivilegeTableMap';

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
		$this->setName('lx_privilege');
		$this->setPhpName('LxPrivilege');
		$this->setClassname('LxPrivilege');
		$this->setPackage('plugins.sfUserV2Plugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID_PRIVILEGE', 'IdPrivilege', 'INTEGER', true, 11, null);
		$this->addColumn('PRIVILEGE_NAME', 'PrivilegeName', 'VARCHAR', true, 20, null);
		$this->addColumn('SF_PRIVILEGE', 'SfPrivilege', 'VARCHAR', true, 20, null);
		$this->addColumn('PRIVILEGE_DESCRIPTION', 'PrivilegeDescription', 'VARCHAR', true, 100, null);
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

} // LxPrivilegeTableMap
