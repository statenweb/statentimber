<?php

namespace StatenTimber\Base;

abstract class Thing {

    public function init() {
        $this->attach_hooks();
    }

    abstract public function attach_hooks();

}