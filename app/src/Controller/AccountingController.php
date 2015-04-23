<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Accounting Controller
 *
 * @property \App\Model\Table\AccountingTable $Accounting
 */
class AccountingController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tenants', 'Payments']
        ];
        $this->set('accounting', $this->paginate($this->Accounting));
        $this->set('_serialize', ['accounting']);
    }

    /**
     * View method
     *
     * @param string|null $id Accounting id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accounting = $this->Accounting->get($id, [
            'contain' => ['Tenants', 'Payments']
        ]);
        $this->set('accounting', $accounting);
        $this->set('_serialize', ['accounting']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accounting = $this->Accounting->newEntity();
        if ($this->request->is('post')) {
            $accounting = $this->Accounting->patchEntity($accounting, $this->request->data);
            if ($this->Accounting->save($accounting)) {
                $this->Flash->success('The accounting has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The accounting could not be saved. Please, try again.');
            }
        }
        $tenants = $this->Accounting->Tenants->find('list', ['limit' => 200]);
        $payments = $this->Accounting->Payments->find('list', ['limit' => 200]);
        $this->set(compact('accounting', 'tenants', 'payments'));
        $this->set('_serialize', ['accounting']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Accounting id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accounting = $this->Accounting->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accounting = $this->Accounting->patchEntity($accounting, $this->request->data);
            if ($this->Accounting->save($accounting)) {
                $this->Flash->success('The accounting has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The accounting could not be saved. Please, try again.');
            }
        }
        $tenants = $this->Accounting->Tenants->find('list', ['limit' => 200]);
        $payments = $this->Accounting->Payments->find('list', ['limit' => 200]);
        $this->set(compact('accounting', 'tenants', 'payments'));
        $this->set('_serialize', ['accounting']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Accounting id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accounting = $this->Accounting->get($id);
        if ($this->Accounting->delete($accounting)) {
            $this->Flash->success('The accounting has been deleted.');
        } else {
            $this->Flash->error('The accounting could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
