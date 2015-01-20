<?php

/**
 * Base class that represents a row from the 'horas_billability' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 03/04/2014 12:04:43
 *
 * @package    lib.model.sgws.om
 */
abstract class BaseHorasBillability extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        HorasBillabilityPeer
	 */
	protected static $peer;

	/**
	 * The value for the codigo field.
	 * @var        int
	 */
	protected $codigo;

	/**
	 * The value for the ano field.
	 * @var        string
	 */
	protected $ano;

	/**
	 * The value for the mes1 field.
	 * @var        string
	 */
	protected $mes1;

	/**
	 * The value for the mes2 field.
	 * @var        string
	 */
	protected $mes2;

	/**
	 * The value for the mes3 field.
	 * @var        string
	 */
	protected $mes3;

	/**
	 * The value for the mes4 field.
	 * @var        string
	 */
	protected $mes4;

	/**
	 * The value for the mes5 field.
	 * @var        string
	 */
	protected $mes5;

	/**
	 * The value for the mes6 field.
	 * @var        string
	 */
	protected $mes6;

	/**
	 * The value for the mes7 field.
	 * @var        string
	 */
	protected $mes7;

	/**
	 * The value for the mes8 field.
	 * @var        string
	 */
	protected $mes8;

	/**
	 * The value for the mes9 field.
	 * @var        string
	 */
	protected $mes9;

	/**
	 * The value for the mes10 field.
	 * @var        string
	 */
	protected $mes10;

	/**
	 * The value for the mes11 field.
	 * @var        string
	 */
	protected $mes11;

	/**
	 * The value for the mes12 field.
	 * @var        string
	 */
	protected $mes12;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'HorasBillabilityPeer';

	/**
	 * Get the [codigo] column value.
	 * 
	 * @return     int
	 */
	public function getCodigo()
	{
		return $this->codigo;
	}

	/**
	 * Get the [ano] column value.
	 * 
	 * @return     string
	 */
	public function getAno()
	{
		return $this->ano;
	}

	/**
	 * Get the [mes1] column value.
	 * 
	 * @return     string
	 */
	public function getMes1()
	{
		return $this->mes1;
	}

	/**
	 * Get the [mes2] column value.
	 * 
	 * @return     string
	 */
	public function getMes2()
	{
		return $this->mes2;
	}

	/**
	 * Get the [mes3] column value.
	 * 
	 * @return     string
	 */
	public function getMes3()
	{
		return $this->mes3;
	}

	/**
	 * Get the [mes4] column value.
	 * 
	 * @return     string
	 */
	public function getMes4()
	{
		return $this->mes4;
	}

	/**
	 * Get the [mes5] column value.
	 * 
	 * @return     string
	 */
	public function getMes5()
	{
		return $this->mes5;
	}

	/**
	 * Get the [mes6] column value.
	 * 
	 * @return     string
	 */
	public function getMes6()
	{
		return $this->mes6;
	}

	/**
	 * Get the [mes7] column value.
	 * 
	 * @return     string
	 */
	public function getMes7()
	{
		return $this->mes7;
	}

	/**
	 * Get the [mes8] column value.
	 * 
	 * @return     string
	 */
	public function getMes8()
	{
		return $this->mes8;
	}

	/**
	 * Get the [mes9] column value.
	 * 
	 * @return     string
	 */
	public function getMes9()
	{
		return $this->mes9;
	}

	/**
	 * Get the [mes10] column value.
	 * 
	 * @return     string
	 */
	public function getMes10()
	{
		return $this->mes10;
	}

	/**
	 * Get the [mes11] column value.
	 * 
	 * @return     string
	 */
	public function getMes11()
	{
		return $this->mes11;
	}

	/**
	 * Get the [mes12] column value.
	 * 
	 * @return     string
	 */
	public function getMes12()
	{
		return $this->mes12;
	}

	/**
	 * Set the value of [codigo] column.
	 * 
	 * @param      int $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setCodigo($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->codigo !== $v) {
			$this->codigo = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::CODIGO;
		}

		return $this;
	} // setCodigo()

	/**
	 * Set the value of [ano] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setAno($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->ano !== $v) {
			$this->ano = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::ANO;
		}

		return $this;
	} // setAno()

	/**
	 * Set the value of [mes1] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes1($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes1 !== $v) {
			$this->mes1 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES1;
		}

		return $this;
	} // setMes1()

	/**
	 * Set the value of [mes2] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes2($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes2 !== $v) {
			$this->mes2 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES2;
		}

		return $this;
	} // setMes2()

	/**
	 * Set the value of [mes3] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes3($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes3 !== $v) {
			$this->mes3 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES3;
		}

		return $this;
	} // setMes3()

	/**
	 * Set the value of [mes4] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes4($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes4 !== $v) {
			$this->mes4 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES4;
		}

		return $this;
	} // setMes4()

	/**
	 * Set the value of [mes5] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes5($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes5 !== $v) {
			$this->mes5 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES5;
		}

		return $this;
	} // setMes5()

	/**
	 * Set the value of [mes6] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes6($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes6 !== $v) {
			$this->mes6 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES6;
		}

		return $this;
	} // setMes6()

	/**
	 * Set the value of [mes7] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes7($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes7 !== $v) {
			$this->mes7 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES7;
		}

		return $this;
	} // setMes7()

	/**
	 * Set the value of [mes8] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes8($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes8 !== $v) {
			$this->mes8 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES8;
		}

		return $this;
	} // setMes8()

	/**
	 * Set the value of [mes9] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes9($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes9 !== $v) {
			$this->mes9 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES9;
		}

		return $this;
	} // setMes9()

	/**
	 * Set the value of [mes10] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes10($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes10 !== $v) {
			$this->mes10 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES10;
		}

		return $this;
	} // setMes10()

	/**
	 * Set the value of [mes11] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes11($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes11 !== $v) {
			$this->mes11 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES11;
		}

		return $this;
	} // setMes11()

	/**
	 * Set the value of [mes12] column.
	 * 
	 * @param      string $v new value
	 * @return     HorasBillability The current object (for fluent API support)
	 */
	public function setMes12($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mes12 !== $v) {
			$this->mes12 = $v;
			$this->modifiedColumns[] = HorasBillabilityPeer::MES12;
		}

		return $this;
	} // setMes12()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->codigo = (isset($row[$startcol + 0]) && $row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->ano = (isset($row[$startcol + 1]) && $row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->mes1 = (isset($row[$startcol + 2]) && $row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->mes2 = (isset($row[$startcol + 3]) && $row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->mes3 = (isset($row[$startcol + 4]) && $row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->mes4 = (isset($row[$startcol + 5]) && $row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->mes5 = (isset($row[$startcol + 6]) && $row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->mes6 = (isset($row[$startcol + 7]) && $row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->mes7 = (isset($row[$startcol + 8]) && $row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->mes8 = (isset($row[$startcol + 9]) && $row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->mes9 = (isset($row[$startcol + 10]) && $row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->mes10 = (isset($row[$startcol + 11]) && $row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->mes11 = (isset($row[$startcol + 12]) && $row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->mes12 = (isset($row[$startcol + 13]) && $row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 14; // 14 = HorasBillabilityPeer::NUM_COLUMNS - HorasBillabilityPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating HorasBillability object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(HorasBillabilityPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = HorasBillabilityPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(HorasBillabilityPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseHorasBillability:delete:pre') as $callable)
			{
			  if ($ret = call_user_func($callable, $this, $con))
			  {
			    return;
			  }
			}

			if ($ret) {
				HorasBillabilityPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseHorasBillability:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(HorasBillabilityPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseHorasBillability:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseHorasBillability:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				HorasBillabilityPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			if ($this->isNew() ) {
				$this->modifiedColumns[] = HorasBillabilityPeer::CODIGO;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = HorasBillabilityPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setCodigo($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += HorasBillabilityPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = HorasBillabilityPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = HorasBillabilityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCodigo();
				break;
			case 1:
				return $this->getAno();
				break;
			case 2:
				return $this->getMes1();
				break;
			case 3:
				return $this->getMes2();
				break;
			case 4:
				return $this->getMes3();
				break;
			case 5:
				return $this->getMes4();
				break;
			case 6:
				return $this->getMes5();
				break;
			case 7:
				return $this->getMes6();
				break;
			case 8:
				return $this->getMes7();
				break;
			case 9:
				return $this->getMes8();
				break;
			case 10:
				return $this->getMes9();
				break;
			case 11:
				return $this->getMes10();
				break;
			case 12:
				return $this->getMes11();
				break;
			case 13:
				return $this->getMes12();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = HorasBillabilityPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCodigo(),
			$keys[1] => $this->getAno(),
			$keys[2] => $this->getMes1(),
			$keys[3] => $this->getMes2(),
			$keys[4] => $this->getMes3(),
			$keys[5] => $this->getMes4(),
			$keys[6] => $this->getMes5(),
			$keys[7] => $this->getMes6(),
			$keys[8] => $this->getMes7(),
			$keys[9] => $this->getMes8(),
			$keys[10] => $this->getMes9(),
			$keys[11] => $this->getMes10(),
			$keys[12] => $this->getMes11(),
			$keys[13] => $this->getMes12(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = HorasBillabilityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCodigo($value);
				break;
			case 1:
				$this->setAno($value);
				break;
			case 2:
				$this->setMes1($value);
				break;
			case 3:
				$this->setMes2($value);
				break;
			case 4:
				$this->setMes3($value);
				break;
			case 5:
				$this->setMes4($value);
				break;
			case 6:
				$this->setMes5($value);
				break;
			case 7:
				$this->setMes6($value);
				break;
			case 8:
				$this->setMes7($value);
				break;
			case 9:
				$this->setMes8($value);
				break;
			case 10:
				$this->setMes9($value);
				break;
			case 11:
				$this->setMes10($value);
				break;
			case 12:
				$this->setMes11($value);
				break;
			case 13:
				$this->setMes12($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = HorasBillabilityPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCodigo($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAno($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMes1($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMes2($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMes3($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMes4($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMes5($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMes6($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setMes7($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setMes8($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setMes9($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setMes10($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setMes11($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setMes12($arr[$keys[13]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(HorasBillabilityPeer::DATABASE_NAME);

		if ($this->isColumnModified(HorasBillabilityPeer::CODIGO)) $criteria->add(HorasBillabilityPeer::CODIGO, $this->codigo);
		if ($this->isColumnModified(HorasBillabilityPeer::ANO)) $criteria->add(HorasBillabilityPeer::ANO, $this->ano);
		if ($this->isColumnModified(HorasBillabilityPeer::MES1)) $criteria->add(HorasBillabilityPeer::MES1, $this->mes1);
		if ($this->isColumnModified(HorasBillabilityPeer::MES2)) $criteria->add(HorasBillabilityPeer::MES2, $this->mes2);
		if ($this->isColumnModified(HorasBillabilityPeer::MES3)) $criteria->add(HorasBillabilityPeer::MES3, $this->mes3);
		if ($this->isColumnModified(HorasBillabilityPeer::MES4)) $criteria->add(HorasBillabilityPeer::MES4, $this->mes4);
		if ($this->isColumnModified(HorasBillabilityPeer::MES5)) $criteria->add(HorasBillabilityPeer::MES5, $this->mes5);
		if ($this->isColumnModified(HorasBillabilityPeer::MES6)) $criteria->add(HorasBillabilityPeer::MES6, $this->mes6);
		if ($this->isColumnModified(HorasBillabilityPeer::MES7)) $criteria->add(HorasBillabilityPeer::MES7, $this->mes7);
		if ($this->isColumnModified(HorasBillabilityPeer::MES8)) $criteria->add(HorasBillabilityPeer::MES8, $this->mes8);
		if ($this->isColumnModified(HorasBillabilityPeer::MES9)) $criteria->add(HorasBillabilityPeer::MES9, $this->mes9);
		if ($this->isColumnModified(HorasBillabilityPeer::MES10)) $criteria->add(HorasBillabilityPeer::MES10, $this->mes10);
		if ($this->isColumnModified(HorasBillabilityPeer::MES11)) $criteria->add(HorasBillabilityPeer::MES11, $this->mes11);
		if ($this->isColumnModified(HorasBillabilityPeer::MES12)) $criteria->add(HorasBillabilityPeer::MES12, $this->mes12);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(HorasBillabilityPeer::DATABASE_NAME);

		$criteria->add(HorasBillabilityPeer::CODIGO, $this->codigo);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getCodigo();
	}

	/**
	 * Generic method to set the primary key (codigo column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setCodigo($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of HorasBillability (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAno($this->ano);

		$copyObj->setMes1($this->mes1);

		$copyObj->setMes2($this->mes2);

		$copyObj->setMes3($this->mes3);

		$copyObj->setMes4($this->mes4);

		$copyObj->setMes5($this->mes5);

		$copyObj->setMes6($this->mes6);

		$copyObj->setMes7($this->mes7);

		$copyObj->setMes8($this->mes8);

		$copyObj->setMes9($this->mes9);

		$copyObj->setMes10($this->mes10);

		$copyObj->setMes11($this->mes11);

		$copyObj->setMes12($this->mes12);


		$copyObj->setNew(true);

		$copyObj->setCodigo(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     HorasBillability Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     HorasBillabilityPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new HorasBillabilityPeer();
		}
		return self::$peer;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseHorasBillability:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseHorasBillability::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseHorasBillability
