<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Users extends Controller {
    public function __construct()
    {
        parent:: __construct();
        $this->call->model('users_model');
    }
    public function index()
    {
        $this->call->view('jmcusers/users');
    }

    public function getUsers()
    {
        $users = $this->users_model->read();
        $html = '';
        foreach($users as $user) {
            $html .= '<tr>';
            $html .= '<td>'.$user['id'].'</td>';
            $html .= '<td>'.$user['jmc_last_name'].'</td>';
            $html .= '<td>'.$user['jmc_first_name'].'</td>';
            $html .= '<td>'.$user['jmc_email'].'</td>';
            $html .= '<td>'.$user['jmc_gender'].'</td>';
            $html .= '<td>'.$user['jmc_address'].'</td>';
            $html .= '<td>
                        <button class="btn btn-primary btn-sm edit-user" data-id="'.$user['id'].'">Edit</button>
                        <button class="btn btn-danger btn-sm delete-user" data-id="'.$user['id'].'">Delete</button>
                    </td>';
            $html .= '</tr>';
        }
        echo $html;
    }
    public function create()
    {
        $response = array();
        
        if($this->form_validation->submitted()) {
            $this->form_validation
                ->name('lname')->required('Last name is required!')
                ->name('fname')->required('First name is required!')
                ->name('email')->required('Email is required!')
                ->name('gender')->required('Gender is required!')
                ->name('address')->required('Address is required!');

            if($this->form_validation->run()) {
                $jmc_last_name = $this->io->post('lname');
                $jmc_first_name = $this->io->post('fname');
                $jmc_email = $this->io->post('email');
                $jmc_gender = $this->io->post('gender');
                $jmc_address = $this->io->post('address');

                if($this->users_model->create($jmc_last_name, $jmc_first_name, $jmc_email, $jmc_gender, $jmc_address)) {
                    $response['success'] = true;
                    $response['message'] = 'User added successfully!';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Failed to add user';
                }
            } else {
                $response['success'] = false;
                $response['message'] = $this->form_validation->errors();
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function update()
    {
        $response = array();
        
        if($this->form_validation->submitted()) {
            $this->form_validation
                ->name('lname')->required('Last name is required!')
                ->name('fname')->required('First name is required!')
                ->name('email')->required('Email is required!')
                ->name('gender')->required('Gender is required!')
                ->name('address')->required('Address is required!');

            if($this->form_validation->run()) {
                $id = $this->io->post('updateUserId');
                if (!$id) {
                    $response['success'] = false;
                    $response['message'] = 'User ID is missing';
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
                
                // Check if user exists in database
                $existing_user = $this->users_model->get_one($id);
                if (!$existing_user) {
                    $response['success'] = false;
                    $response['message'] = 'User not found in database. ID: ' . $id;
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
                $jmc_last_name = $this->io->post('lname');
                $jmc_first_name = $this->io->post('fname');
                $jmc_email = $this->io->post('email');
                $jmc_gender = $this->io->post('gender');
                $jmc_address = $this->io->post('address');

                if($this->users_model->update($jmc_last_name, $jmc_first_name, $jmc_email, $jmc_gender, $jmc_address, $id)) {
                    $response['success'] = true;
                    $response['message'] = 'User updated successfully!';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Failed to update user';
                }
            } else {
                $response['success'] = false;
                $response['message'] = $this->form_validation->errors();
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'No data submitted';
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getOne($id)
    {
        $user = $this->users_model->get_one($id);
        header('Content-Type: application/json');
        echo json_encode($user);
    }
    public function delete($id){
        $response = array();
        if($this->users_model->delete($id)){
            $response['success'] = true;
            $response['message'] = 'User deleted successfully!';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to delete user';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
