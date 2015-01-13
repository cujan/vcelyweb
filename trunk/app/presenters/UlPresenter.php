<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use App\Model,
	Nette,
	Nette\Application\UI\Form,
	Grido\Grid;



class UlPresenter extends BasePresenter {
    
     /** @var Model\UlRepository @inject */
    public $ul;
    /** @var Model\CiselnikTypUlaRepository @inject */
    public $ciselnikTypUla;
     /** @var Model\VcelnicaRepository @inject */
    public $vcelnica;
    
    
    
    
    public function renderDetail($id = 0)
	{
		$form = $this['ulForm'];
		if (!$form->isSubmitted()) {
			$album = $this->ul->findById($id);
			if (!$album) {
				$this->error('Record not found');
			}
			$form->setDefaults($album);
		}
	}
    
    protected function createComponentGridUle($name) {
	 $grid = new  Grid($this,$name);
	$grid->setModel($this->ul->findAll());
	$grid->addColumnText('nazov', 'Názov úľa');
	$grid->addColumnText('idCiselnikTypUla', 'typ ula')->setColumn(function($item){ return $item->ciselnikTypUla->nazov;});
	$grid->addActionHref('detail', 'Detail');
	$grid->addActionHref('delete', 'Zmaz');
    }
    
    
    protected function createComponentUlForm($name) {
	   //$identifikatory = array('1'=>'prijem','-1'=>'vydaj');
	   $typUla = $this->ciselnikTypUla->findAll()->fetchPairs('id','nazov');
	   $vcelnica = $this->vcelnica->findAll()->fetchPairs('id','nazov');
		
	    $form = new Form;
	    
	    $form->addText('nazov','Nazov ula');
	    $form->addSelect('idCiselnikTypUla', 'Typ ula',$typUla)->setPrompt('- Zvoľte typ ula -')->setRequired();
	    $form->addSelect('idVcelnica', 'Vcelnica',$vcelnica)->setPrompt('- Zvoľte vcelnicu -')->setRequired();
	    $form->addText('matkaRokLiahnutia', 'Matka rok vyliahnutia');
	    $form->addText('matkaLinia', 'Matka linia');
	    $form->addText('matkaOplodnenost', 'Matka oplodnenost');
	    $form->addText('matkaFarba', 'Matka Farba');
	    $form->addDatePicker('matkaDatumVlozenia', 'Matka datum vlozenia do vcelstva', 10, 10);
	    
	    
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
			$this->ul->findById($id)->update($values);
			$this->flashMessage('Transakcia bola upravena.');
		} else {
			$this->ul->insert($values);
			$this->flashMessage('Transakcia bola vlozena.');
		}
		$this->redirect('default');
	}
	public function formCancelled()
	{
		$this->redirect('default');
	}
    
}