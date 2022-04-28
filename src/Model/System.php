<?php

namespace App\Model;

abstract class System
{
    private $device;
    private $programs;
    public function __construct(Device $device,array $programs)
    {
        $this->device = $device;
        /** @var Program $program */
        foreach($programs as $program) {
            //z zalozenia dana klasa programu moze byc tylko jedna
            $this->programs[get_class($program)] = $program;
        }
    }

    public function addProgram(Program $program): void
    {
        $this->programs[get_class($program)] = $program;
    }
    public function getProgram($name){
        if(array_key_exists($name,$this->programs)) {
            return $this->programs[$name];
        }
    }

}