<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MembershipGroups Controller
 *
 * @property \App\Model\Table\MembershipGroupsTable $MembershipGroups
 */
class MembershipGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('membershipGroups', $this->paginate($this->MembershipGroups));
        $this->set('_serialize', ['membershipGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Membership Group id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $membershipGroup = $this->MembershipGroups->get($id, [
            'contain' => []
        ]);
        $this->set('membershipGroup', $membershipGroup);
        $this->set('_serialize', ['membershipGroup']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $membershipGroup = $this->MembershipGroups->newEntity();
        if ($this->request->is('post')) {
            $membershipGroup = $this->MembershipGroups->patchEntity($membershipGroup, $this->request->data);
            if ($this->MembershipGroups->save($membershipGroup)) {
                $this->Flash->success('The membership group has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership group could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipGroup'));
        $this->set('_serialize', ['membershipGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Membership Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $membershipGroup = $this->MembershipGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $membershipGroup = $this->MembershipGroups->patchEntity($membershipGroup, $this->request->data);
            if ($this->MembershipGroups->save($membershipGroup)) {
                $this->Flash->success('The membership group has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership group could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipGroup'));
        $this->set('_serialize', ['membershipGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Membership Group id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $membershipGroup = $this->MembershipGroups->get($id);
        if ($this->MembershipGroups->delete($membershipGroup)) {
            $this->Flash->success('The membership group has been deleted.');
        } else {
            $this->Flash->error('The membership group could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
