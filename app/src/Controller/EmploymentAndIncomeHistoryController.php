<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmploymentAndIncomeHistory Controller
 *
 * @property \App\Model\Table\EmploymentAndIncomeHistoryTable $EmploymentAndIncomeHistory
 */
class EmploymentAndIncomeHistoryController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('employmentAndIncomeHistory', $this->paginate($this->EmploymentAndIncomeHistory));
        $this->set('_serialize', ['employmentAndIncomeHistory']);
    }

    /**
     * View method
     *
     * @param string|null $id Employment And Income History id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employmentAndIncomeHistory = $this->EmploymentAndIncomeHistory->get($id, [
            'contain' => []
        ]);
        $this->set('employmentAndIncomeHistory', $employmentAndIncomeHistory);
        $this->set('_serialize', ['employmentAndIncomeHistory']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employmentAndIncomeHistory = $this->EmploymentAndIncomeHistory->newEntity();
        if ($this->request->is('post')) {
            $employmentAndIncomeHistory = $this->EmploymentAndIncomeHistory->patchEntity($employmentAndIncomeHistory, $this->request->data);
            if ($this->EmploymentAndIncomeHistory->save($employmentAndIncomeHistory)) {
                $this->Flash->success('The employment and income history has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The employment and income history could not be saved. Please, try again.');
            }
        }
        $this->set(compact('employmentAndIncomeHistory'));
        $this->set('_serialize', ['employmentAndIncomeHistory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employment And Income History id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employmentAndIncomeHistory = $this->EmploymentAndIncomeHistory->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employmentAndIncomeHistory = $this->EmploymentAndIncomeHistory->patchEntity($employmentAndIncomeHistory, $this->request->data);
            if ($this->EmploymentAndIncomeHistory->save($employmentAndIncomeHistory)) {
                $this->Flash->success('The employment and income history has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The employment and income history could not be saved. Please, try again.');
            }
        }
        $this->set(compact('employmentAndIncomeHistory'));
        $this->set('_serialize', ['employmentAndIncomeHistory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Employment And Income History id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employmentAndIncomeHistory = $this->EmploymentAndIncomeHistory->get($id);
        if ($this->EmploymentAndIncomeHistory->delete($employmentAndIncomeHistory)) {
            $this->Flash->success('The employment and income history has been deleted.');
        } else {
            $this->Flash->error('The employment and income history could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
