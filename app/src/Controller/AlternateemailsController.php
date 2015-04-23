<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Alternateemails Controller
 *
 * @property \App\Model\Table\AlternateemailsTable $Alternateemails
 */
class AlternateemailsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tenants']
        ];
        $this->set('alternateemails', $this->paginate($this->Alternateemails));
        $this->set('_serialize', ['alternateemails']);
    }

    /**
     * View method
     *
     * @param string|null $id Alternateemail id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alternateemail = $this->Alternateemails->get($id, [
            'contain' => ['Tenants']
        ]);
        $this->set('alternateemail', $alternateemail);
        $this->set('_serialize', ['alternateemail']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alternateemail = $this->Alternateemails->newEntity();
        if ($this->request->is('post')) {
            $alternateemail = $this->Alternateemails->patchEntity($alternateemail, $this->request->data);
            if ($this->Alternateemails->save($alternateemail)) {
                $this->Flash->success('The alternateemail has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The alternateemail could not be saved. Please, try again.');
            }
        }
        $tenants = $this->Alternateemails->Tenants->find('list', ['limit' => 200]);
        $this->set(compact('alternateemail', 'tenants'));
        $this->set('_serialize', ['alternateemail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Alternateemail id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alternateemail = $this->Alternateemails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alternateemail = $this->Alternateemails->patchEntity($alternateemail, $this->request->data);
            if ($this->Alternateemails->save($alternateemail)) {
                $this->Flash->success('The alternateemail has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The alternateemail could not be saved. Please, try again.');
            }
        }
        $tenants = $this->Alternateemails->Tenants->find('list', ['limit' => 200]);
        $this->set(compact('alternateemail', 'tenants'));
        $this->set('_serialize', ['alternateemail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Alternateemail id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alternateemail = $this->Alternateemails->get($id);
        if ($this->Alternateemails->delete($alternateemail)) {
            $this->Flash->success('The alternateemail has been deleted.');
        } else {
            $this->Flash->error('The alternateemail could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
