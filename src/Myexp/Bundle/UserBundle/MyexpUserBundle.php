<?php

namespace Myexp\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MyexpUserBundle extends Bundle {

    //get parent FOSUserbundle
    public function getParent() {
        return 'FOSUserBundle';
    }

}
