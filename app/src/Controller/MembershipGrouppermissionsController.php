<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MembershipGrouppermissions Controller
 *
 * @property \App\Model\Table\MembershipGrouppermissionsTable $MembershipGrouppermissions
 */
class MembershipGrouppermissionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('membershipGrouppermissions', $this->paginate($this->MembershipGrouppermissions));
        $this->set('_serialize', ['membershipGrouppermissions']);
    }

    /**
     * View method
     *
     * @param string|null $id Membership Grouppermission id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $membershipGrouppermission = $this->MembershipGrouppermissions->get($id, [
            'contain' => []
        ]);
        $this->set('membershipGrouppermission', $membershipGrouppermission);
        $this->set('_serialize', ['membershipGrouppermission']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $membershipGrouppermission = $this->MembershipGrouppermissions->newEntity();
        if ($this->request->is('post')) {
            $membershipGrouppermission = $this->MembershipGrouppermissions->patchEntity($membershipGrouppermission, $this->request->data);
            if ($this->MembershipGrouppermissions->save($membershipGrouppermission)) {
                $this->Flash->success('The membership grouppermission has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership grouppermission could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipGrouppermission'));
        $this->set('_serialize', ['membershipGrouppermission']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Membership Grouppermission id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $membershipGrouppermission = $this->MembershipGrouppermissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $membershipGrouppermission = $this->MembershipGrouppermissions->patchEntity($membershipGrouppermission, $this->request->data);
            if ($this->MembershipGrouppermissions->save($membershipGrouppermission)) {
                $this->Flash->success('The membership grouppermission has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership grouppermission could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipGrouppermission'));
        $this->set('_serialize', ['membershipGrouppermission']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Membership Grouppermission id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $membershipGrouppermission = $this->MembershipGrouppermissions->get($id);
        if ($this->MembershipGrouppermissions->delete($membershipGrouppermission)) {
            $this->Flash->success('The membership grouppermission has been deleted.');
        } else {
            $this->Flash->error('The membership grouppermission could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
