<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PropertiestypesSpecifications Controller
 *
 * @property \App\Model\Table\PropertiestypesSpecificationsTable $PropertiestypesSpecifications
 */
class PropertiestypesSpecificationsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Propertiestypes']
        ];
        $this->set('propertiestypesSpecifications', $this->paginate($this->PropertiestypesSpecifications));
        $this->set('_serialize', ['propertiestypesSpecifications']);
    }

    /**
     * View method
     *
     * @param string|null $id Propertiestypes Specification id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $propertiestypesSpecification = $this->PropertiestypesSpecifications->get($id, [
            'contain' => ['Propertiestypes', 'Properties']
        ]);
        $this->set('propertiestypesSpecification', $propertiestypesSpecification);
        $this->set('_serialize', ['propertiestypesSpecification']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $propertiestypesSpecification = $this->PropertiestypesSpecifications->newEntity();
        if ($this->request->is('post')) {
            $propertiestypesSpecification = $this->PropertiestypesSpecifications->patchEntity($propertiestypesSpecification, $this->request->data);
            if ($this->PropertiestypesSpecifications->save($propertiestypesSpecification)) {
                $this->Flash->success('The propertiestypes specification has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The propertiestypes specification could not be saved. Please, try again.');
            }
        }
        $propertiestypes = $this->PropertiestypesSpecifications->Propertiestypes->find('list', ['limit' => 200]);
        $this->set(compact('propertiestypesSpecification', 'propertiestypes'));
        $this->set('_serialize', ['propertiestypesSpecification']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Propertiestypes Specification id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $propertiestypesSpecification = $this->PropertiestypesSpecifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $propertiestypesSpecification = $this->PropertiestypesSpecifications->patchEntity($propertiestypesSpecification, $this->request->data);
            if ($this->PropertiestypesSpecifications->save($propertiestypesSpecification)) {
                $this->Flash->success('The propertiestypes specification has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The propertiestypes specification could not be saved. Please, try again.');
            }
        }
        $propertiestypes = $this->PropertiestypesSpecifications->Propertiestypes->find('list', ['limit' => 200]);
        $this->set(compact('propertiestypesSpecification', 'propertiestypes'));
        $this->set('_serialize', ['propertiestypesSpecification']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Propertiestypes Specification id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $propertiestypesSpecification = $this->PropertiestypesSpecifications->get($id);
        if ($this->PropertiestypesSpecifications->delete($propertiestypesSpecification)) {
            $this->Flash->success('The propertiestypes specification has been deleted.');
        } else {
            $this->Flash->error('The propertiestypes specification could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
