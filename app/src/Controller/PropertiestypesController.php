<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Propertiestypes Controller
 *
 * @property \App\Model\Table\PropertiestypesTable $Propertiestypes
 */
class PropertiestypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('propertiestypes', $this->paginate($this->Propertiestypes));
        $this->set('_serialize', ['propertiestypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Propertiestype id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $propertiestype = $this->Propertiestypes->get($id, [
            'contain' => []
        ]);
        $this->set('propertiestype', $propertiestype);
        $this->set('_serialize', ['propertiestype']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $propertiestype = $this->Propertiestypes->newEntity();
        if ($this->request->is('post')) {
            $propertiestype = $this->Propertiestypes->patchEntity($propertiestype, $this->request->data);
            if ($this->Propertiestypes->save($propertiestype)) {
                $this->Flash->success('The propertiestype has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The propertiestype could not be saved. Please, try again.');
            }
        }
        $this->set(compact('propertiestype'));
        $this->set('_serialize', ['propertiestype']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Propertiestype id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $propertiestype = $this->Propertiestypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $propertiestype = $this->Propertiestypes->patchEntity($propertiestype, $this->request->data);
            if ($this->Propertiestypes->save($propertiestype)) {
                $this->Flash->success('The propertiestype has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The propertiestype could not be saved. Please, try again.');
            }
        }
        $this->set(compact('propertiestype'));
        $this->set('_serialize', ['propertiestype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Propertiestype id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $propertiestype = $this->Propertiestypes->get($id);
        if ($this->Propertiestypes->delete($propertiestype)) {
            $this->Flash->success('The propertiestype has been deleted.');
        } else {
            $this->Flash->error('The propertiestype could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
