<?php


/**
 * This class defines the structure of the 'sf_news' table.
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
class SfNewsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfLynxNewsPlugin.lib.model.map.SfNewsTableMap';

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
		$this->setName('sf_news');
		$this->setPhpName('SfNews');
		$this->setClassname('SfNews');
		$this->setPackage('plugins.sfLynxNewsPlugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID_NEWS', 'IdNews', 'INTEGER', true, 10, null);
		$this->addColumn('ID_PROFILE', 'IdProfile', 'INTEGER', true, 11, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 200, null);
		$this->addColumn('SUB_TITLE', 'SubTitle', 'VARCHAR', false, 150, null);
		$this->addColumn('BODY', 'Body', 'LONGVARCHAR', true, null, null);
		$this->addColumn('DATE', 'Date', 'DATE', false, null, null);
		$this->addColumn('SUMMARY', 'Summary', 'LONGVARCHAR', true, null, null);
		$this->addColumn('AUTHOR', 'Author', 'VARCHAR', false, 100, null);
		$this->addColumn('IMAGE_PRINCIPAL', 'ImagePrincipal', 'VARCHAR', true, 50, null);
		$this->addColumn('IMAGE', 'Image', 'VARCHAR', false, 50, null);
		$this->addColumn('STATUS', 'Status', 'CHAR', true, null, null);
		$this->addColumn('HOME', 'Home', 'CHAR', true, null, null);
		$this->addColumn('PERMALINK', 'Permalink', 'LONGVARCHAR', false, null, null);
		$this->addColumn('HOME_TITLE', 'HomeTitle', 'VARCHAR', false, 58, null);
		$this->addColumn('CATEGORY', 'Category', 'VARCHAR', false, 20, null);
		$this->addColumn('STICKY', 'Sticky', 'CHAR', true, null, '0');
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('SfNewsAccess', 'SfNewsAccess', RelationMap::ONE_TO_MANY, array('id_news' => 'id_news', ), 'CASCADE', 'RESTRICT');
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

} // SfNewsTableMap
