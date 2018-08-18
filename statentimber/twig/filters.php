<?php

namespace StatenTimber\Twig;

use StatenTimber\Base\Thing;
use StatenTimber\Format\Phone;

class Filters extends Thing {


    public function attach_hooks() {
        add_action( 'timber/twig/filters', array( $this, 'format_phone' ) );

    }

    public function format_phone( $twig ) {

        $twig->addFilter( new \Twig_SimpleFilter( 'phone', array( $this, 'format' ) ) );

        return $twig;
    }

    public function format( $value ) {
        $formatter = new Phone( $value );

        return $formatter->get_formatted();

    }


}
