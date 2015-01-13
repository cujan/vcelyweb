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



class VcelnicaPresenter extends BasePresenter {
    
     /** @var Model\VcelnicaRepository @inject */
    public $vcelnica;
    
     /** @var Model\UlRepository @inject */
    public $ul;
    
    
    public function renderDelete($id = 0)
	{
		$this->template->vcelnica = $this->vcelnica->findById($id);
		if (!$this->template->vcelnica) {
			$this->error('Record not found');
		}
	}
    
    public function renderDetail($id = 0)
	{
	
		$this->template->vcelnica = $this->vcelnica->findById($id);
		if (!$this->template->vcelnica) {
			$this->error('Record not found');
		}
	}
    
    
    
    
    protected function createComponentGridVcelnice($name) {
	 $grid = new  Grid($this,$name);
	$grid->setModel($this->vcelnica->findAll());
	$grid->addColumnText('nazov', 'Názov vcelnice');
	$grid->addActionHref('edit', 'Edit');
	$grid->addActionHref('delete', 'Zmaz');
	$grid->addActionHref('detail', 'Detail');
    }
    
     protected function createComponentGridUle($name) {
	$grid = new  Grid($this,$name);
	$grid->setModel($this->ul->findAll()->where('idVcelnica',$this->getParameter('id')));
	$grid->addColumnText('nazov', 'Názov ula');
	$grid->addActionHref('detail', 'Detail','Ul:detail');
    }
    
    
    protected function createComponentPolozkaForm($name) {
	  
	    $form = new Form;
	    $form->addText('nazov','Nazov vcelnice')->setRequired();
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
			$this->vcelnica->findById($id)->update($values);
			$this->flashMessage('Transakcia bola upravena.');
		} else {
			$this->vcelnica->insert($values);
			$this->flashMessage('Transakcia bola vlozena.');
		}
		$this->redirect('default');
	}
	public function formCancelled()
	{
		$this->redirect('default');
	}
	
	
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
		$this->vcelnica->findById($this->getParameter('id'))->delete();
		$this->flashMessage('Transakcia bola zmazana.');
		$this->redirect('default');
	}
}