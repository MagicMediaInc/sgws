  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' <?php echo $this->getModuleName() ?> - Lynx Cms');
<?php if (isset($this->params['with_propel_route']) && $this->params['with_propel_route']): ?>
    $this-><?php echo $this->getPluralName() ?> = $this->getRoute()->getObjects();
<?php else: ?>
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  <?php echo constant($this->getModelClass().'::PEER') ?>::getFieldNames(BasePeer::TYPE_FIELDNAME);
      		//PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = $sortTemp[0];      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		$c = new Criteria();
		if($this->getRequestParameter('sort'))
		{
			$this->sort = $this->getRequestParameter('sort');
			switch ($this->getRequestParameter('by')) {

				case 'desc':
					$c->addDescendingOrderByColumn(<?php echo constant($this->getModelClass().'::PEER') ?>::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(<?php echo constant($this->getModelClass().'::PEER') ?>::$this->getRequestParameter('sort'));
					$this->by = "desc";
					$this->by_page = "asc";
					break;
			}
		}else{
			$c->addAscendingOrderByColumn($this->sort);
		}
		if($this->getRequestParameter('buscador'))
		{
                //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
                sfConfig::set('sf_escaping_strategy', false);
                //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
                <?php $i=0;?>
		<?php foreach ($this->getTableMap()->getColumns() as $name => $column):?>
                <?php if($i==0):?>
                    $criterio = $c->getNewCriterion(<?php echo constant($this->getModelClass().'::PEER') ?>::<?php echo $column->getColumnName(); ?>, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                <?php else:?>
                    $criterio->addOr($c->getNewCriterion(<?php echo constant($this->getModelClass().'::PEER') ?>::<?php echo $column->getColumnName(); ?>, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                <?php endif;?>
                <?php $i++;?>
		<?php endforeach; ?>
			$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('<?php echo $this->getSingularName() ?>',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this-><?php echo $this->getPluralName() ?> = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_<?php echo $this->getModuleName() ?>','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this-><?php echo $this->getPluralName() ?>->getPage());
  
<?php endif; ?>
  }
