<?php

class usersRoute extends rest
{
    function get() {
        return json_encode(array(
            "User" => $this->user,
            "Input" => $this->input,
            "Verb" => $this->verb,
            "ID" => $this->id
        ));
    }
}
