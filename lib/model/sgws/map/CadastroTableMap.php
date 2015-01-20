<?php


/**
 * This class defines the structure of the 'cadastro' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 03/04/2014 12:04:41
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.sgws.map
 */
class CadastroTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.sgws.map.CadastroTableMap';

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
		$this->setName('cadastro');
		$this->setPhpName('Cadastro');
		$this->setClassname('Cadastro');
		$this->setPackage('lib.model.sgws');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('CODIGOCADASTRO', 'Codigocadastro', 'INTEGER', true, 11, null);
		$this->addColumn('TIPOCADASTRO', 'Tipocadastro', 'VARCHAR', false, 50, null);
		$this->addColumn('RAZAOSOCIAL', 'Razaosocial', 'VARCHAR', false, 255, null);
		$this->addColumn('NOMEFANTASIA', 'Nomefantasia', 'VARCHAR', false, 255, null);
		$this->addColumn('CNPJ', 'Cnpj', 'VARCHAR', false, 50, null);
		$this->addColumn('INSCRICAOESTADUAL', 'Inscricaoestadual', 'VARCHAR', false, 50, null);
		$this->addColumn('INSCRICAOCOM', 'Inscricaocom', 'VARCHAR', false, 50, null);
		$this->addColumn('ENDERECO', 'Endereco', 'VARCHAR', false, 255, null);
		$this->addColumn('NUMERO', 'Numero', 'VARCHAR', false, 50, null);
		$this->addColumn('COMPLEMENTO', 'Complemento', 'VARCHAR', false, 50, null);
		$this->addColumn('BAIRRO', 'Bairro', 'VARCHAR', false, 50, null);
		$this->addColumn('CIDADE', 'Cidade', 'VARCHAR', false, 50, null);
		$this->addColumn('CEP', 'Cep', 'VARCHAR', false, 50, null);
		$this->addColumn('ESTADO', 'Estado', 'VARCHAR', false, 50, null);
		$this->addColumn('PAIS', 'Pais', 'VARCHAR', false, 50, null);
		$this->addColumn('TELEFONE', 'Telefone', 'VARCHAR', false, 50, null);
		$this->addColumn('FAX', 'Fax', 'VARCHAR', false, 50, null);
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255, null);
		$this->addColumn('CONTATO1', 'Contato1', 'VARCHAR', false, 255, null);
		$this->addColumn('TELEFONECON1', 'Telefonecon1', 'VARCHAR', false, 50, null);
		$this->addColumn('CELULARCON1', 'Celularcon1', 'VARCHAR', false, 50, null);
		$this->addColumn('EMAILCONTATO1', 'Emailcontato1', 'VARCHAR', false, 255, null);
		$this->addColumn('CONTATO2', 'Contato2', 'VARCHAR', false, 255, null);
		$this->addColumn('TELEFONECON2', 'Telefonecon2', 'VARCHAR', false, 50, null);
		$this->addColumn('CELULARCON2', 'Celularcon2', 'VARCHAR', false, 50, null);
		$this->addColumn('EMAILCONTATO2', 'Emailcontato2', 'VARCHAR', false, 255, null);
		$this->addColumn('CONTATO3', 'Contato3', 'VARCHAR', false, 255, null);
		$this->addColumn('TELEFONECON3', 'Telefonecon3', 'VARCHAR', false, 50, null);
		$this->addColumn('CELULARCON3', 'Celularcon3', 'VARCHAR', false, 50, null);
		$this->addColumn('EMAILCONTATO3', 'Emailcontato3', 'VARCHAR', false, 255, null);
		$this->addColumn('CONTATO4', 'Contato4', 'VARCHAR', false, 255, null);
		$this->addColumn('TELEFONECON4', 'Telefonecon4', 'VARCHAR', false, 50, null);
		$this->addColumn('CELULARCON4', 'Celularcon4', 'VARCHAR', false, 50, null);
		$this->addColumn('EMAILCONTATO4', 'Emailcontato4', 'VARCHAR', false, 255, null);
		$this->addColumn('CONTATO5', 'Contato5', 'VARCHAR', false, 255, null);
		$this->addColumn('TELEFONECON5', 'Telefonecon5', 'VARCHAR', false, 50, null);
		$this->addColumn('CELULARCON5', 'Celularcon5', 'VARCHAR', false, 50, null);
		$this->addColumn('EMAILCONTATO5', 'Emailcontato5', 'VARCHAR', false, 255, null);
		$this->addColumn('ENDERECOSITE', 'Enderecosite', 'VARCHAR', false, 255, null);
		$this->addColumn('NIVELPRIVACIDADE', 'Nivelprivacidade', 'INTEGER', false, 11, null);
		$this->addColumn('CODIGOCLIENTE', 'Codigocliente', 'VARCHAR', false, 50, null);
		$this->addColumn('SUBTIPO', 'Subtipo', 'VARCHAR', false, 255, null);
		$this->addColumn('CATEGORIA', 'Categoria', 'INTEGER', false, 11, null);
		$this->addColumn('STATUS', 'Status', 'VARCHAR', false, 50, null);
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

} // CadastroTableMap
