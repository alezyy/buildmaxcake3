<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RentalOwners Controller
 *
 * @property \App\Model\Table\RentalOwnersTable $RentalOwners
 */
class RentalOwnersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('rentalOwners', $this->paginate($this->RentalOwners));
        $this->set('_serialize', ['rentalOwners']);
    }

    /**
     * View method
     *
     * @param string|null $id Rental Owner id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rentalOwner = $this->RentalOwners->get($id, [
            'contain' => []
        ]);
        $this->set('rentalOwner', $rentalOwner);
        $this->set('_serialize', ['rentalOwner']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rentalOwner = $this->RentalOwners->newEntity();
        if ($this->request->is('post')) {
            $rentalOwner = $this->RentalOwners->patchEntity($rentalOwner, $this->request->data);
            if ($this->RentalOwners->save($rentalOwner)) {
                $this->Flash->success('The rental owner has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The rental owner could not be saved. Please, try again.');
            }
        }
        $this->set(compact('rentalOwner'));
        $this->set('_serialize', ['rentalOwner']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rental Owner id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rentalOwner = $this->RentalOwners->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rentalOwner = $this->RentalOwners->patchEntity($rentalOwner, $this->request->data);
            if ($this->RentalOwners->save($rentalOwner)) {
                $this->Flash->success('The rental owner has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The rental owner could not be saved. Please, try again.');
            }
        }
        $this->set(compact('rentalOwner'));
        $this->set('_serialize', ['rentalOwner']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rental Owner id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rentalOwner = $this->RentalOwners->get($id);
        if ($this->RentalOwners->delete($rentalOwner)) {
            $this->Flash->success('The rental owner has been deleted.');
        } else {
            $this->Flash->error('The rental owner could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
