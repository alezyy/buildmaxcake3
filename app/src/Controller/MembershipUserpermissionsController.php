<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MembershipUserpermissions Controller
 *
 * @property \App\Model\Table\MembershipUserpermissionsTable $MembershipUserpermissions
 */
class MembershipUserpermissionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('membershipUserpermissions', $this->paginate($this->MembershipUserpermissions));
        $this->set('_serialize', ['membershipUserpermissions']);
    }

    /**
     * View method
     *
     * @param string|null $id Membership Userpermission id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $membershipUserpermission = $this->MembershipUserpermissions->get($id, [
            'contain' => []
        ]);
        $this->set('membershipUserpermission', $membershipUserpermission);
        $this->set('_serialize', ['membershipUserpermission']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $membershipUserpermission = $this->MembershipUserpermissions->newEntity();
        if ($this->request->is('post')) {
            $membershipUserpermission = $this->MembershipUserpermissions->patchEntity($membershipUserpermission, $this->request->data);
            if ($this->MembershipUserpermissions->save($membershipUserpermission)) {
                $this->Flash->success('The membership userpermission has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership userpermission could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipUserpermission'));
        $this->set('_serialize', ['membershipUserpermission']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Membership Userpermission id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $membershipUserpermission = $this->MembershipUserpermissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $membershipUserpermission = $this->MembershipUserpermissions->patchEntity($membershipUserpermission, $this->request->data);
            if ($this->MembershipUserpermissions->save($membershipUserpermission)) {
                $this->Flash->success('The membership userpermission has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership userpermission could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipUserpermission'));
        $this->set('_serialize', ['membershipUserpermission']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Membership Userpermission id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $membershipUserpermission = $this->MembershipUserpermissions->get($id);
        if ($this->MembershipUserpermissions->delete($membershipUserpermission)) {
            $this->Flash->success('The membership userpermission has been deleted.');
        } else {
            $this->Flash->error('The membership userpermission could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
