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









<?php


abstract class Animal {
    
    protected $name;

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    abstract public function makeSound();
}


class Dog extends Animal {
    public function makeSound() {
        return "Woof! Woof!";
    }
}


class Cat extends Animal {
    public function makeSound() {
        return "Meow! Meow!";
    }
}

$dog = new Dog();
$dog->setName("Rex");
echo "Nom: " . $dog->getName() . "\n"; 
echo "Son: " . $dog->makeSound() . "\n"; 

$cat = new Cat();
$cat->setName("Mimi");
echo "Nom: " . $cat->getName() . "\n"; 
echo "Son: " . $cat->makeSound() . "\n"; 

?>
