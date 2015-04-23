<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * References Controller
 *
 * @property \App\Model\Table\ReferencesTable $References
 */
class ReferencesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('references', $this->paginate($this->References));
        $this->set('_serialize', ['references']);
    }

    /**
     * View method
     *
     * @param string|null $id Reference id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reference = $this->References->get($id, [
            'contain' => []
        ]);
        $this->set('reference', $reference);
        $this->set('_serialize', ['reference']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reference = $this->References->newEntity();
        if ($this->request->is('post')) {
            $reference = $this->References->patchEntity($reference, $this->request->data);
            if ($this->References->save($reference)) {
                $this->Flash->success('The reference has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The reference could not be saved. Please, try again.');
            }
        }
        $this->set(compact('reference'));
        $this->set('_serialize', ['reference']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Reference id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reference = $this->References->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reference = $this->References->patchEntity($reference, $this->request->data);
            if ($this->References->save($reference)) {
                $this->Flash->success('The reference has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The reference could not be saved. Please, try again.');
            }
        }
        $this->set(compact('reference'));
        $this->set('_serialize', ['reference']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Reference id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reference = $this->References->get($id);
        if ($this->References->delete($reference)) {
            $this->Flash->success('The reference has been deleted.');
        } else {
            $this->Flash->error('The reference could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
