<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MaritalStatus Controller
 *
 * @property \App\Model\Table\MaritalStatusTable $MaritalStatus
 */
class MaritalStatusController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('maritalStatus', $this->paginate($this->MaritalStatus));
        $this->set('_serialize', ['maritalStatus']);
    }

    /**
     * View method
     *
     * @param string|null $id Marital Status id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $maritalStatus = $this->MaritalStatus->get($id, [
            'contain' => ['Tenants']
        ]);
        $this->set('maritalStatus', $maritalStatus);
        $this->set('_serialize', ['maritalStatus']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $maritalStatus = $this->MaritalStatus->newEntity();
        if ($this->request->is('post')) {
            $maritalStatus = $this->MaritalStatus->patchEntity($maritalStatus, $this->request->data);
            if ($this->MaritalStatus->save($maritalStatus)) {
                $this->Flash->success('The marital status has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The marital status could not be saved. Please, try again.');
            }
        }
        $this->set(compact('maritalStatus'));
        $this->set('_serialize', ['maritalStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Marital Status id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $maritalStatus = $this->MaritalStatus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $maritalStatus = $this->MaritalStatus->patchEntity($maritalStatus, $this->request->data);
            if ($this->MaritalStatus->save($maritalStatus)) {
                $this->Flash->success('The marital status has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The marital status could not be saved. Please, try again.');
            }
        }
        $this->set(compact('maritalStatus'));
        $this->set('_serialize', ['maritalStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Marital Status id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $maritalStatus = $this->MaritalStatus->get($id);
        if ($this->MaritalStatus->delete($maritalStatus)) {
            $this->Flash->success('The marital status has been deleted.');
        } else {
            $this->Flash->error('The marital status could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
