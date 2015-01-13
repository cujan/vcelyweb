<?php

namespace App\Presenters;

    use App\Model,
	    Nette,
	    Nette\Application\UI\Form;



    class EkonomikaPresenter extends BasePresenter {
  /** @var Model\PrijmyVydajeRepository @inject */
public $prijmyvydaje;  

/** @var Model\CiselnikTypTransakcieRepository @inject */
public $ciselniktyptransakcie;
  
   


    /**public function __construct(Model\PrijmyVydajeRepository $prijmyvydaje,Model\CiselnikTypTransakcieRepository $ciselniktyptransakcie) {
	 $this->prijmyvydaje = $prijmyvydaje;
	 $this->ciselniktyptransakcie = $ciselniktyptransakcie;
    }*/
    
   
    /********************* view default *********************/


	public function renderDefault()
	{
		$this->template->prijmyvydaje = $this->prijmyvydaje->findAll();
		$this->template->celkovyPrijem = $this->zratajPrijem();
		$this->template->celkovyVydaj = $this->zratajVydaj();
		//$this->template->saldo = $this->zratajPrijem() - $this->zratajVydaj();
	}
	/********************* view delete *********************/


	public function renderDelete($id = 0)
	{
		$this->template->prijemvydaj = $this->prijmyvydaje->findById($id);
		if (!$this->template->prijemvydaj) {
			$this->error('Record not found');
		}
	}

	protected function createComponentGrid($name) {
	    
	    $list = $this->ciselniktyptransakcie->findAll()->fetchPairs('nazov','nazov');
	    
	    $grid = new  \Grido\Grid($this,$name);
	    $grid->translator->lang='sk';
	    $grid->setModel($this->prijmyvydaje->findAll());
	    $grid->setDefaultSort(array('datum'=>'DESC'));
	    $grid->addColumnDate('datum', 'Datum')->setDateFormat(\Grido\Components\Columns\Date::FORMAT_DATE)->setSortable()->setFilterDate();
	    $grid->addColumnText('popis', "Popis");
	    $grid->addColumnText('suma', "Suma")->setSortable();
	    $grid->addColumnText('idCiselnikTypTransakcie', 'typ transakcie')
		    ->setColumn(function($item){ return $item->ciselnikTypTransakcie->nazov;});
	    //$grid->addColumnText('identifikator', 'identifikator');
	    
	    
	    $grid->setRowCallback(function($row, \Nette\Utils\Html $tr) {
	     if ($row->identifikator == 1) {
		$tr->class[] = 'prijem';
		
	    }
	    else {
		$tr->class[] = 'vydaj';
	    }
	    return $tr;
	    });
	    $grid->addActionHref('delete', 'Zmaz');
	}
	protected function createComponentPolozkaForm($name) {
	   $identifikatory = array('1'=>'prijem','-1'=>'vydaj');
	   $typTransakcie = $this->ciselniktyptransakcie->findAll()->fetchPairs('id','nazov');
		
	    $form = new Form;
	    $form->addRadioList('identifikator', 'transakcia', $identifikatory)->setRequired();
	    $form->addText('popis','Popis')->setRequired();
	    $form->addDatePicker('datum', 'Datum:', 10, 10)->setRequired();
	    $form->addText('suma','Suma')->addRule(\Nette\Application\UI\Form::FLOAT,'Prosim vlozte cislo')->setRequired();
	    $form->addSelect('idCiselnikTypTransakcie', 'Typ transakcie',$typTransakcie)->setPrompt('- Zvoľte typ transakcie -')->setRequired();
	    $form->addSubmit('save', 'Save')
			->setAttribute('class', 'default')
			->onClick[] = $this->vlozitTransakciuFormSucceeded;

		$form->addSubmit('cancel', 'Cancel')
			->setValidationScope(array())
			->onClick[] = $this->formCancelled;
	    return $form;
	     
	}
	
	public function vlozitTransakciuFormSucceeded($button) {
	    $values = $button->getForm()->getValues();
		$id = (int) $this->getParameter('id');
		if ($id) {
			$this->prijmyvydaje->findById($id)->update($values);
			$this->flashMessage('Transakcia bola upravena.');
		} else {
			$this->prijmyvydaje->insert($values);
			$this->flashMessage('Transakcia bola vlozena.');
		}
		$this->redirect('default');
	}
	public function formCancelled()
	{
		$this->redirect('default');
	}
	
	/**
	 * Delete form factory.
	 * @return Form
	 */
	protected function createComponentDeleteForm()
	{
		$form = new Form;
		$form->addSubmit('cancel', 'Cancel')
			->onClick[] = $this->formCancelled;

		$form->addSubmit('delete', 'Delete')
			->setAttribute('class', 'default')
			->onClick[] = $this->deleteFormSucceeded;

		$form->addProtection();
		return $form;
	}
	
	public function deleteFormSucceeded()
	{
		$this->prijmyvydaje->findById($this->getParameter('id'))->delete();
		$this->flashMessage('Transakcia bola zmazana.');
		$this->redirect('default');
	}
	
	public function zratajPrijem(){
	    $vysledok=0;
	    $prijmy = $this->prijmyvydaje->findAll()->where('identifikator',1);
	    foreach ($prijmy as $prijem){
		$vysledok = $vysledok + $prijem->suma;
	    }
	    return $vysledok;
	}
	public function zratajVydaj(){
	    $vysledok=0;
	    $vydaje = $this->prijmyvydaje->findAll()->where('identifikator',-1);
	    foreach ($vydaje as $vydaj){
		$vysledok = $vysledok + $vydaj->suma;
	    }
	    return $vysledok;
	}
}
