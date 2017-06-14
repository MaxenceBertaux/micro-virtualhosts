<?php
namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;
use models\Virtualhost;
use models\Server;

class Display extends ControllerBase{

    public function index(){





        $this->jquery->compile($this->view);
        $this->loadView("Display/host/index2.html");




    }
    public function host($idhost){
    }
}