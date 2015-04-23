<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ApplicationsLeases Controller
 *
 * @property \App\Model\Table\ApplicationsLeasesTable $ApplicationsLeases
 */
class ApplicationsLeasesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('applicationsLeases', $this->paginate($this->ApplicationsLeases));
        $this->set('_serialize', ['applicationsLeases']);
    }

    /**
     * View method
     *
     * @param string|null $id Applications Lease id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $applicationsLease = $this->ApplicationsLeases->get($id, [
            'contain' => []
        ]);
        $this->set('applicationsLease', $applicationsLease);
        $this->set('_serialize', ['applicationsLease']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $applicationsLease = $this->ApplicationsLeases->newEntity();
        if ($this->request->is('post')) {
            $applicationsLease = $this->ApplicationsLeases->patchEntity($applicationsLease, $this->request->data);
            if ($this->ApplicationsLeases->save($applicationsLease)) {
                $this->Flash->success('The applications lease has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The applications lease could not be saved. Please, try again.');
            }
        }
        $this->set(compact('applicationsLease'));
        $this->set('_serialize', ['applicationsLease']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Applications Lease id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $applicationsLease = $this->ApplicationsLeases->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $applicationsLease = $this->ApplicationsLeases->patchEntity($applicationsLease, $this->request->data);
            if ($this->ApplicationsLeases->save($applicationsLease)) {
                $this->Flash->success('The applications lease has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The applications lease could not be saved. Please, try again.');
            }
        }
        $this->set(compact('applicationsLease'));
        $this->set('_serialize', ['applicationsLease']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Applications Lease id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $applicationsLease = $this->ApplicationsLeases->get($id);
        if ($this->ApplicationsLeases->delete($applicationsLease)) {
            $this->Flash->success('The applications lease has been deleted.');
        } else {
            $this->Flash->error('The applications lease could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
