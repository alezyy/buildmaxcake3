<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Recurringcharges Controller
 *
 * @property \App\Model\Table\RecurringchargesTable $Recurringcharges
 */
class RecurringchargesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('recurringcharges', $this->paginate($this->Recurringcharges));
        $this->set('_serialize', ['recurringcharges']);
    }

    /**
     * View method
     *
     * @param string|null $id Recurringcharge id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recurringcharge = $this->Recurringcharges->get($id, [
            'contain' => ['ApplicationsLeases']
        ]);
        $this->set('recurringcharge', $recurringcharge);
        $this->set('_serialize', ['recurringcharge']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $recurringcharge = $this->Recurringcharges->newEntity();
        if ($this->request->is('post')) {
            $recurringcharge = $this->Recurringcharges->patchEntity($recurringcharge, $this->request->data);
            if ($this->Recurringcharges->save($recurringcharge)) {
                $this->Flash->success('The recurringcharge has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The recurringcharge could not be saved. Please, try again.');
            }
        }
        $this->set(compact('recurringcharge'));
        $this->set('_serialize', ['recurringcharge']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Recurringcharge id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recurringcharge = $this->Recurringcharges->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recurringcharge = $this->Recurringcharges->patchEntity($recurringcharge, $this->request->data);
            if ($this->Recurringcharges->save($recurringcharge)) {
                $this->Flash->success('The recurringcharge has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The recurringcharge could not be saved. Please, try again.');
            }
        }
        $this->set(compact('recurringcharge'));
        $this->set('_serialize', ['recurringcharge']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recurringcharge id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recurringcharge = $this->Recurringcharges->get($id);
        if ($this->Recurringcharges->delete($recurringcharge)) {
            $this->Flash->success('The recurringcharge has been deleted.');
        } else {
            $this->Flash->error('The recurringcharge could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
