<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword {

    /**
     * @Assert\NotBlank()
     */
    protected $currentPassword;

    /**
     * @Assert\NotBlank()
     */
    protected $newPassword;

    public function setCurrentPassword($currentPassword) {
        $this->currentPassword = $currentPassword;
    }

    public function getCurrentPassword() {
        return $this->currentPassword;
    }

    public function getNewPassword() {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
    }

}
