<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Leasestypes Controller
 *
 * @property \App\Model\Table\LeasestypesTable $Leasestypes
 */
class LeasestypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('leasestypes', $this->paginate($this->Leasestypes));
        $this->set('_serialize', ['leasestypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Leasestype id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leasestype = $this->Leasestypes->get($id, [
            'contain' => ['ApplicationsLeases']
        ]);
        $this->set('leasestype', $leasestype);
        $this->set('_serialize', ['leasestype']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leasestype = $this->Leasestypes->newEntity();
        if ($this->request->is('post')) {
            $leasestype = $this->Leasestypes->patchEntity($leasestype, $this->request->data);
            if ($this->Leasestypes->save($leasestype)) {
                $this->Flash->success('The leasestype has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The leasestype could not be saved. Please, try again.');
            }
        }
        $this->set(compact('leasestype'));
        $this->set('_serialize', ['leasestype']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Leasestype id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leasestype = $this->Leasestypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leasestype = $this->Leasestypes->patchEntity($leasestype, $this->request->data);
            if ($this->Leasestypes->save($leasestype)) {
                $this->Flash->success('The leasestype has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The leasestype could not be saved. Please, try again.');
            }
        }
        $this->set(compact('leasestype'));
        $this->set('_serialize', ['leasestype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Leasestype id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leasestype = $this->Leasestypes->get($id);
        if ($this->Leasestypes->delete($leasestype)) {
            $this->Flash->success('The leasestype has been deleted.');
        } else {
            $this->Flash->error('The leasestype could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
