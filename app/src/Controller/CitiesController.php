<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 */
class CitiesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['States']
        ];
        $this->set('cities', $this->paginate($this->Cities));
        $this->set('_serialize', ['cities']);
    }

    /**
     * View method
     *
     * @param string|null $id City id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $city = $this->Cities->get($id, [
            'contain' => ['States', 'Tenants']
        ]);
        $this->set('city', $city);
        $this->set('_serialize', ['city']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $city = $this->Cities->newEntity();
        if ($this->request->is('post')) {
            $city = $this->Cities->patchEntity($city, $this->request->data);
            if ($this->Cities->save($city)) {
                $this->Flash->success('The city has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The city could not be saved. Please, try again.');
            }
        }
        $states = $this->Cities->States->find('list', ['limit' => 200]);
        $this->set(compact('city', 'states'));
        $this->set('_serialize', ['city']);
    }

    /**
     * Edit method
     *
     * @param string|null $id City id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $city = $this->Cities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->data);
            if ($this->Cities->save($city)) {
                $this->Flash->success('The city has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The city could not be saved. Please, try again.');
            }
        }
        $states = $this->Cities->States->find('list', ['limit' => 200]);
        $this->set(compact('city', 'states'));
        $this->set('_serialize', ['city']);
    }

    /**
     * Delete method
     *
     * @param string|null $id City id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $city = $this->Cities->get($id);
        if ($this->Cities->delete($city)) {
            $this->Flash->success('The city has been deleted.');
        } else {
            $this->Flash->error('The city could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
