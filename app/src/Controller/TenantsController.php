<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tenants Controller
 *
 * @property \App\Model\Table\TenantsTable $Tenants
 */
class TenantsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Countries', 'States', 'Cities']
        ];
        $this->set('tenants', $this->paginate($this->Tenants));
        $this->set('_serialize', ['tenants']);
    }

    /**
     * View method
     *
     * @param string|null $id Tenant id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => ['Countries', 'States', 'Cities', 'Alternateemails', 'Accounting', 'ApplicationsLeases', 'Comptable1']
        ]);
        $this->set('tenant', $tenant);
        $this->set('_serialize', ['tenant']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tenant = $this->Tenants->newEntity();
        if ($this->request->is('post')) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->data);
            if ($this->Tenants->save($tenant)) {
                $this->Flash->success('The tenant has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The tenant could not be saved. Please, try again.');
            }
        }
        $countries = $this->Tenants->Countries->find('list', ['limit' => 200]);
        $states = $this->Tenants->States->find('list', ['limit' => 200]);
        $cities = $this->Tenants->Cities->find('list', ['limit' => 200]);
        $this->set(compact('tenant', 'countries', 'states', 'cities'));
        $this->set('_serialize', ['tenant']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tenant id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->data);
            if ($this->Tenants->save($tenant)) {
                $this->Flash->success('The tenant has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The tenant could not be saved. Please, try again.');
            }
        }
        $countries = $this->Tenants->Countries->find('list', ['limit' => 200]);
        $states = $this->Tenants->States->find('list', ['limit' => 200]);
        $cities = $this->Tenants->Cities->find('list', ['limit' => 200]);
        $this->set(compact('tenant', 'countries', 'states', 'cities'));
        $this->set('_serialize', ['tenant']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tenant id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenant = $this->Tenants->get($id);
        if ($this->Tenants->delete($tenant)) {
            $this->Flash->success('The tenant has been deleted.');
        } else {
            $this->Flash->error('The tenant could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
