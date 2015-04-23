<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Comptable1 Controller
 *
 * @property \App\Model\Table\Comptable1Table $Comptable1
 */
class Comptable1Controller extends AppController
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
        $this->set('comptable1', $this->paginate($this->Comptable1));
        $this->set('_serialize', ['comptable1']);
    }

    /**
     * View method
     *
     * @param string|null $id Comptable1 id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comptable1 = $this->Comptable1->get($id, [
            'contain' => ['Tenants', 'Payments']
        ]);
        $this->set('comptable1', $comptable1);
        $this->set('_serialize', ['comptable1']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comptable1 = $this->Comptable1->newEntity();
        if ($this->request->is('post')) {
            $comptable1 = $this->Comptable1->patchEntity($comptable1, $this->request->data);
            if ($this->Comptable1->save($comptable1)) {
                $this->Flash->success('The comptable1 has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The comptable1 could not be saved. Please, try again.');
            }
        }
        $tenants = $this->Comptable1->Tenants->find('list', ['limit' => 200]);
        $payments = $this->Comptable1->Payments->find('list', ['limit' => 200]);
        $this->set(compact('comptable1', 'tenants', 'payments'));
        $this->set('_serialize', ['comptable1']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Comptable1 id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comptable1 = $this->Comptable1->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comptable1 = $this->Comptable1->patchEntity($comptable1, $this->request->data);
            if ($this->Comptable1->save($comptable1)) {
                $this->Flash->success('The comptable1 has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The comptable1 could not be saved. Please, try again.');
            }
        }
        $tenants = $this->Comptable1->Tenants->find('list', ['limit' => 200]);
        $payments = $this->Comptable1->Payments->find('list', ['limit' => 200]);
        $this->set(compact('comptable1', 'tenants', 'payments'));
        $this->set('_serialize', ['comptable1']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comptable1 id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comptable1 = $this->Comptable1->get($id);
        if ($this->Comptable1->delete($comptable1)) {
            $this->Flash->success('The comptable1 has been deleted.');
        } else {
            $this->Flash->error('The comptable1 could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
