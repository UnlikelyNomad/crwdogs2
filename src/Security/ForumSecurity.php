<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\ForumCategory;

class ForumSecurity {

    private $admin = false;
    private $read = false;
    private $create = false;
    private $mod = false;

    public function __construct(User $user, ForumCategory $category) {
        $catRoles = $category->getRolesRead();

        $this->admin = in_array('ROLE_ADMIN', $user->getRoles());
        $this->read = count($catRoles) == 0 || count(array_intersect($user->getRoles(), $category->getRolesRead())) > 0 || $this->admin;
        $this->create = count(array_intersect($user->getRoles(), $category->getRolesCreate())) > 0 || $this->admin;
        $this->mod = count(array_intersect($user->getRoles(), $category->getRolesMod())) > 0 || $this->admin;
    }

    public function isAdmin() {
        return $this->admin;
    }

    public function canRead() {
        return $this->read;
    }
    
    public function canCreate() {
        return $this->create;
    }
    
    public function canMod() {
        return $this->mod;
    }
}