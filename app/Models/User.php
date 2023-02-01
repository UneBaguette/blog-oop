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

    public function checkUsername(string $username): bool
    {
        $st = $this->query("SELECT * FROM {$this->table} WHERE username = ?", [$username], true);
        foreach($st as $v){
            if ($v['id'] === $username){
                return false;
            }
        }
        return true;
    }

    public function register($user, $pass, $admin = 1): bool{
        if (!$this->checkUsername($user)){
            return false;
        }
        $st = $this->db->getPDO()->prepare("INSERT INTO {$this->table}(id, username, password, admin) VALUES (NULL, :user, :pass, :admin)");
        $st->execute(['user' => $user, 'pass' => $pass, 'admin' => $admin]);
        return true;
    }

    public static function test () {
        echo __METHOD__, PHP_EOL;
    }
}
