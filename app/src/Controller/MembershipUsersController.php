<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MembershipUsers Controller
 *
 * @property \App\Model\Table\MembershipUsersTable $MembershipUsers
 */
class MembershipUsersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('membershipUsers', $this->paginate($this->MembershipUsers));
        $this->set('_serialize', ['membershipUsers']);
    }

    /**
     * View method
     *
     * @param string|null $id Membership User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $membershipUser = $this->MembershipUsers->get($id, [
            'contain' => []
        ]);
        $this->set('membershipUser', $membershipUser);
        $this->set('_serialize', ['membershipUser']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $membershipUser = $this->MembershipUsers->newEntity();
        if ($this->request->is('post')) {
            $membershipUser = $this->MembershipUsers->patchEntity($membershipUser, $this->request->data);
            if ($this->MembershipUsers->save($membershipUser)) {
                $this->Flash->success('The membership user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipUser'));
        $this->set('_serialize', ['membershipUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Membership User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $membershipUser = $this->MembershipUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $membershipUser = $this->MembershipUsers->patchEntity($membershipUser, $this->request->data);
            if ($this->MembershipUsers->save($membershipUser)) {
                $this->Flash->success('The membership user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipUser'));
        $this->set('_serialize', ['membershipUser']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Membership User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $membershipUser = $this->MembershipUsers->get($id);
        if ($this->MembershipUsers->delete($membershipUser)) {
            $this->Flash->success('The membership user has been deleted.');
        } else {
            $this->Flash->error('The membership user could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
