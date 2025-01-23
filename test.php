<?php

class Animal {

    protected $name;

    public function __construct($name){
        $this->name = $name;
    }

    public function sound(){
        return "animal with sound";
    }

    public function set_name($name){
        $this->name = $name;
    }

    public function get_name(){
        return $this->name;
    }
}

class Dog extends Animal {

    public function sound(){
        return "how, how";
    }
    
}

class cat extends Animal {
    public function sound(){
        return "miow, miow";
    }

}







?>