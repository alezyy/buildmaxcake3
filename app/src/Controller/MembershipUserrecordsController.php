<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MembershipUserrecords Controller
 *
 * @property \App\Model\Table\MembershipUserrecordsTable $MembershipUserrecords
 */
class MembershipUserrecordsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('membershipUserrecords', $this->paginate($this->MembershipUserrecords));
        $this->set('_serialize', ['membershipUserrecords']);
    }

    /**
     * View method
     *
     * @param string|null $id Membership Userrecord id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $membershipUserrecord = $this->MembershipUserrecords->get($id, [
            'contain' => []
        ]);
        $this->set('membershipUserrecord', $membershipUserrecord);
        $this->set('_serialize', ['membershipUserrecord']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $membershipUserrecord = $this->MembershipUserrecords->newEntity();
        if ($this->request->is('post')) {
            $membershipUserrecord = $this->MembershipUserrecords->patchEntity($membershipUserrecord, $this->request->data);
            if ($this->MembershipUserrecords->save($membershipUserrecord)) {
                $this->Flash->success('The membership userrecord has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership userrecord could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipUserrecord'));
        $this->set('_serialize', ['membershipUserrecord']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Membership Userrecord id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $membershipUserrecord = $this->MembershipUserrecords->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $membershipUserrecord = $this->MembershipUserrecords->patchEntity($membershipUserrecord, $this->request->data);
            if ($this->MembershipUserrecords->save($membershipUserrecord)) {
                $this->Flash->success('The membership userrecord has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The membership userrecord could not be saved. Please, try again.');
            }
        }
        $this->set(compact('membershipUserrecord'));
        $this->set('_serialize', ['membershipUserrecord']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Membership Userrecord id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $membershipUserrecord = $this->MembershipUserrecords->get($id);
        if ($this->MembershipUserrecords->delete($membershipUserrecord)) {
            $this->Flash->success('The membership userrecord has been deleted.');
        } else {
            $this->Flash->error('The membership userrecord could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
