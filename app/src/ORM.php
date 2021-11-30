<?php 

class User
{
	public $id;
	public $name;
    public $login;
    public $position;
    public $pos_id;
    public $department;
    public $session_id;
    public $age;
    public $head_id;

    function __construct($id, $name, $login, $position, $session_id, $age, $department, $head_id, $pos_id)
    {
    	$this->id = $id;
    	$this->name = $name;
    	$this->login = $login;
    	$this->position = $position;
    	$this->session_id = $session_id;
    	$this->age = $age;
        $this->department = $department;
        $this->head_id = $head_id;
        $this->pos_id = $pos_id;
    }
}