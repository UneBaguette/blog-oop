<?php

namespace App\models;

// TODO: remove
require __DIR__ . '/Model.php';
class User extends Model {

    protected $table = 'users';

    public function getByUsername(string $username): User
    {
        return $this->query("SELECT * FROM {$this->table} WHERE username = ?", [$username], true);
    }

    public function getPassByUsername(string $username)
    {
        return $this->query("SELECT password FROM {$this->table} WHERE username = ?", [$username], true);
    }

    public function getAdminByUsername(string $username)
    {
        return $this->query("SELECT admin FROM {$this->table} WHERE username = ?", [$username], true);
    }

    public function exist(string $username): bool
    {
        $st = $this->query("SELECT id, username as user FROM {$this->table} WHERE username = ?", [$username], true);
        foreach($st as $v){
            if ($v === $username){
                return true;
            }
        }
        return false;
    }

    public function register($user, $pass, $admin = 1): bool{
        if ($this->exist($user)){
            return false;
        }
        $st = $this->db->getPDO()->prepare("INSERT INTO {$this->table}(id, username, password, admin) VALUES (NULL, :user, :pass, :admin)");
        $st->execute(['user' => $user, 'pass' => $pass, 'admin' => $admin]);
        return true;
    }
}
