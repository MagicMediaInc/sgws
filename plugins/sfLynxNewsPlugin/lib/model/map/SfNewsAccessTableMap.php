<?php


/**
 * This class defines the structure of the 'sf_news_access' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 20/01/2014 11:33:32
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfLynxNewsPlugin.lib.model.map
 */
class SfNewsAccessTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfLynxNewsPlugin.lib.model.map.SfNewsAccessTableMap';

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
		$this->setName('sf_news_access');
		$this->setPhpName('SfNewsAccess');
		$this->setClassname('SfNewsAccess');
		$this->setPackage('plugins.sfLynxNewsPlugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID_ACCESS', 'IdAccess', 'INTEGER', true, 11, null);
		$this->addForeignKey('ID_NUCLEO', 'IdNucleo', 'INTEGER', 'lx_profile', 'ID_PROFILE', true, 11, null);
		$this->addForeignKey('ID_NEWS', 'IdNews', 'INTEGER', 'sf_news', 'ID_NEWS', true, 11, null);
		$this->addColumn('CATEGORIA', 'Categoria', 'VARCHAR', true, 20, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('LxProfile', 'LxProfile', RelationMap::MANY_TO_ONE, array('id_nucleo' => 'id_profile', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfNews', 'SfNews', RelationMap::MANY_TO_ONE, array('id_news' => 'id_news', ), 'CASCADE', 'RESTRICT');
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

} // SfNewsAccessTableMap
