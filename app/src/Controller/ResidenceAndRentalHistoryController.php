<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ResidenceAndRentalHistory Controller
 *
 * @property \App\Model\Table\ResidenceAndRentalHistoryTable $ResidenceAndRentalHistory
 */
class ResidenceAndRentalHistoryController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('residenceAndRentalHistory', $this->paginate($this->ResidenceAndRentalHistory));
        $this->set('_serialize', ['residenceAndRentalHistory']);
    }

    /**
     * View method
     *
     * @param string|null $id Residence And Rental History id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $residenceAndRentalHistory = $this->ResidenceAndRentalHistory->get($id, [
            'contain' => []
        ]);
        $this->set('residenceAndRentalHistory', $residenceAndRentalHistory);
        $this->set('_serialize', ['residenceAndRentalHistory']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $residenceAndRentalHistory = $this->ResidenceAndRentalHistory->newEntity();
        if ($this->request->is('post')) {
            $residenceAndRentalHistory = $this->ResidenceAndRentalHistory->patchEntity($residenceAndRentalHistory, $this->request->data);
            if ($this->ResidenceAndRentalHistory->save($residenceAndRentalHistory)) {
                $this->Flash->success('The residence and rental history has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The residence and rental history could not be saved. Please, try again.');
            }
        }
        $this->set(compact('residenceAndRentalHistory'));
        $this->set('_serialize', ['residenceAndRentalHistory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Residence And Rental History id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $residenceAndRentalHistory = $this->ResidenceAndRentalHistory->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $residenceAndRentalHistory = $this->ResidenceAndRentalHistory->patchEntity($residenceAndRentalHistory, $this->request->data);
            if ($this->ResidenceAndRentalHistory->save($residenceAndRentalHistory)) {
                $this->Flash->success('The residence and rental history has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The residence and rental history could not be saved. Please, try again.');
            }
        }
        $this->set(compact('residenceAndRentalHistory'));
        $this->set('_serialize', ['residenceAndRentalHistory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Residence And Rental History id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $residenceAndRentalHistory = $this->ResidenceAndRentalHistory->get($id);
        if ($this->ResidenceAndRentalHistory->delete($residenceAndRentalHistory)) {
            $this->Flash->success('The residence and rental history has been deleted.');
        } else {
            $this->Flash->error('The residence and rental history could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
