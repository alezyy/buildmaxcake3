<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Deposits Controller
 *
 * @property \App\Model\Table\DepositsTable $Deposits
 */
class DepositsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('deposits', $this->paginate($this->Deposits));
        $this->set('_serialize', ['deposits']);
    }

    /**
     * View method
     *
     * @param string|null $id Deposit id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deposit = $this->Deposits->get($id, [
            'contain' => []
        ]);
        $this->set('deposit', $deposit);
        $this->set('_serialize', ['deposit']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deposit = $this->Deposits->newEntity();
        if ($this->request->is('post')) {
            $deposit = $this->Deposits->patchEntity($deposit, $this->request->data);
            if ($this->Deposits->save($deposit)) {
                $this->Flash->success('The deposit has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The deposit could not be saved. Please, try again.');
            }
        }
        $this->set(compact('deposit'));
        $this->set('_serialize', ['deposit']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Deposit id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deposit = $this->Deposits->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deposit = $this->Deposits->patchEntity($deposit, $this->request->data);
            if ($this->Deposits->save($deposit)) {
                $this->Flash->success('The deposit has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The deposit could not be saved. Please, try again.');
            }
        }
        $this->set(compact('deposit'));
        $this->set('_serialize', ['deposit']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Deposit id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deposit = $this->Deposits->get($id);
        if ($this->Deposits->delete($deposit)) {
            $this->Flash->success('The deposit has been deleted.');
        } else {
            $this->Flash->error('The deposit could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
