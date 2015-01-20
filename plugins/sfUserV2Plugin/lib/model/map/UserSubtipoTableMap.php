<?php


/**
 * This class defines the structure of the 'user_subtipo' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 03/04/2014 12:04:40
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfUserV2Plugin.lib.model.map
 */
class UserSubtipoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfUserV2Plugin.lib.model.map.UserSubtipoTableMap';

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
		$this->setName('user_subtipo');
		$this->setPhpName('UserSubtipo');
		$this->setClassname('UserSubtipo');
		$this->setPackage('plugins.sfUserV2Plugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID_USER_SUBTIPO', 'IdUserSubtipo', 'INTEGER', true, 11, null);
		$this->addForeignKey('ID_USER', 'IdUser', 'INTEGER', 'lx_user', 'ID_USER', true, 11, null);
		$this->addForeignKey('ID_SUBTIPO', 'IdSubtipo', 'INTEGER', 'subtipo_user', 'ID_SUBTIPO', true, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('LxUser', 'LxUser', RelationMap::MANY_TO_ONE, array('id_user' => 'id_user', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SubtipoUser', 'SubtipoUser', RelationMap::MANY_TO_ONE, array('id_subtipo' => 'id_subtipo', ), 'RESTRICT', 'RESTRICT');
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

} // UserSubtipoTableMap
