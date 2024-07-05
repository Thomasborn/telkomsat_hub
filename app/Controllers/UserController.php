<?php

namespace App\Controllers;

use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use CodeIgniter\Controller;

class UserController extends BaseController
{
    public function login()
    {
        $session = session();

        if ($session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        return view('login');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/login'));
    }

    public function processLogin()
    {
        $session = session();
        $userModel = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();
        if ($user) {
            if (password_verify($password,  $user['password'])) {
                // Set session data
                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ]);
                return redirect()->to(base_url('/'))->with('success', 'Login berhasil!');
            } else {
                return redirect()->to(base_url('/login'))->with('error', 'Password salah.');
            }
        } else {
            return redirect()->to(base_url('/login'))->with('error', 'Email tidak ditemukan.');
        }
    }
    
    public function index()
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();

        // Fetch all roles
        $data['roles'] = $roleModel->findAll();

        // Fetch all users
        $users = $userModel->findAll();

        // Associate roles with users
        foreach ($users as &$user) {
            $role = $roleModel->find($user['role']);
            $user['role_id'] = ($user['role']);
            $user['role'] = ($role) ? $role['nama'] : 'Unknown Role'; // Assuming 'nama' is the role name field
        }

        // Pass users data to the view
        $data['users'] = $users;

        return view('users', $data); 
    }

    // Other methods like add, edit, delete, etc.

    public function add()
    {
        $userModel = new UserModel();
        
        $password = $this->request->getVar('password');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
            'username' => $this->request->getVar('username'),
            'password' => $hashedPassword
        ];
    
        $userModel->save($data);
    
        return redirect()->to(base_url('users'))->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('users'))->with('error', 'User tidak ditemukan!');
        }

        $data = [
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'role' => $this->request->getVar('role'),
        ];

        $password = $this->request->getVar('password');
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
        }

        $userModel->update($id, $data);

        return redirect()->to(base_url('users'))->with('success', 'Data berhasil diubah!');
    }

    public function delete($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to(base_url('users'))->with('error', 'User tidak ditemukan!');
        }

        $userModel->delete($id);

        return redirect()->to(base_url('users'))->with('success', 'Data berhasil dihapus!');
    }
}
