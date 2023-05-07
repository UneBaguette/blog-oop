<?php

namespace App\models;

// TODO: remove
require __DIR__ . '/Model.php';
class User extends Model {

    protected $table = 'users';

    /**
     * @var string Mot de passe hashé de l'utilisateur
     */
    public $password;
    /**
     * @var int Valeur par défaut 0, admin si la valeur est supérieur à 0
     */
    public $admin;

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
        if ((bool)$st){
            return true;
        }
        return false;
    }

    public function register($user, $pass, $admin = 0): bool{
        if ($this->exist($user)){
            return false;
        }
        $st = $this->db->getPDO()->prepare("INSERT INTO {$this->table}(id, username, password, admin) VALUES (NULL, :user, :pass, :admin)");
        $st->execute(['user' => $user, 'pass' => $pass, 'admin' => $admin]);
        return true;
    }
}