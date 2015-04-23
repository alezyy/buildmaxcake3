<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Comptable Controller
 *
 * @property \App\Model\Table\ComptableTable $Comptable
 */
class ComptableController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('comptable', $this->paginate($this->Comptable));
        $this->set('_serialize', ['comptable']);
    }

    /**
     * View method
     *
     * @param string|null $id Comptable id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comptable = $this->Comptable->get($id, [
            'contain' => []
        ]);
        $this->set('comptable', $comptable);
        $this->set('_serialize', ['comptable']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comptable = $this->Comptable->newEntity();
        if ($this->request->is('post')) {
            $comptable = $this->Comptable->patchEntity($comptable, $this->request->data);
            if ($this->Comptable->save($comptable)) {
                $this->Flash->success('The comptable has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The comptable could not be saved. Please, try again.');
            }
        }
        $this->set(compact('comptable'));
        $this->set('_serialize', ['comptable']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Comptable id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comptable = $this->Comptable->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comptable = $this->Comptable->patchEntity($comptable, $this->request->data);
            if ($this->Comptable->save($comptable)) {
                $this->Flash->success('The comptable has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The comptable could not be saved. Please, try again.');
            }
        }
        $this->set(compact('comptable'));
        $this->set('_serialize', ['comptable']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comptable id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comptable = $this->Comptable->get($id);
        if ($this->Comptable->delete($comptable)) {
            $this->Flash->success('The comptable has been deleted.');
        } else {
            $this->Flash->error('The comptable could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
