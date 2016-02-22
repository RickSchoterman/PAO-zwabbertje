<?php

class MessageService {
    public function __construct($config) {

    }

    public function getUserMessage($user) {
        return 'Hello '.$user->getUsername().', '.$user->getTitle().'.';
    }
}

?>