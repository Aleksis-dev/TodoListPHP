<?php

class todo {

    public $list = ["item1", "item2", "item3"];

    public function __construct() {

        $preMethods = get_class_methods($this);
        $methods = array_slice($preMethods, 1);
        print_r($methods);

        while(true) {
            $line = readline("Command: ");

            $pieces = explode(" ", $line);
            $command = $pieces[0];
            $args = array_slice($pieces, 1);

            if (method_exists($this, $command)) {

                $reflection = new ReflectionMethod($this, $command);
                $numParams = $reflection->getNumberOfParameters();

                if (count($args) >= $numParams) {
                    call_user_func_array([$this, $command], $args);
                } else {
                    echo "Insufficient arguments. Expected $numParams arguments.\n";
                }
            } else {
                echo "Invalid command: $command\n";
            }
        }
    }

    public function list() {
        print_r($this->list);
    }

    public function exit() {
        echo "Exiting...\n";
        exit;
    }

    public function add($item) {
        $this->list[] = $item;
        echo "Added: $item\n";
    }

    public function remove($item) {
        $key = array_search($item, $this->list);
        if ($key !== false) {
            unset($this->list[$key]);
            echo "Removed: $item\n";
        } else {
            echo "Item not found: $item\n";
        }
    }
}

$new = new todo();