<?php
namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;
use models\Virtualhost;
use models\Server;

/**
 * Controller My
 **/
class My extends ControllerBase{


    /**
     * Mes services
     * Hosts et virtualhosts de l'utilisateur connect�
     */
    public function index(){
        if(Auth::isAuth()){
            $user = Auth::getUser();
            $hosts=DAO::getAll("models\Host","idUser=".$user->getId());

            $hostsItems=$this->semantic->htmlItems("list-hosts");
            $hostsItems->fromDatabaseObjects($hosts, function($host){
                $item=new HtmlItem("");
                $item->addImage("public/img/host.png")->setSize("tiny");
                $item->addItemHeaderContent($host->getName(),$host->getIpv4(),"");
                return $item;

            });

            $idUser=DAO::getAll("models\Host","idUser=".$user->getId());
            $hostsItems->fromDatabaseObjects($idUser, function($id){
                $item=new HtmlItem("");
                $item->addItemHeaderContent($id->getId());

                $namevirtualhost=DAO::getAll("models\Virtualhost","idUser=".$id->getId());



                $hostsItems=$this->semantic->htmlItems("list-virtualhosts");
                $hostsItems->fromDatabaseObjects($namevirtualhost, function($namevhost){
                    $item=new HtmlItem("");
                    $item->addImage("public/img/virtualhost.png")->setSize("tiny");

                    $server = $namevhost->getServer("models\Virtualhost");
                    echo $namevhost->getServer(), "";


                    $item->addItemHeaderContent($namevhost->getName(),"");


                    return $item;


                });});






            $vhosts=DAO::getAll("models\Virtualhost","idUser=".$user->getId());

            //Permet de compiler en Java
            $this->jquery->compile($this->view);
            //Permet de charger dans la vue les variables instanciées dans le contrôleur(=cette page)
            $this->loadView("My/index.html"
                ,array(
                    "tableau_vhosts"=>$vhosts
                    //"tableau_server"=>$vhosts_server
                ) );



            /**  $server=DAO::getAll("models\Virtualhost");
            foreach($virtualhost as $virtualhost){
            $nameserver=DAO::getAll("models\Server");
            echo $virtualhost."<br/>";} */


            /**$virtualhost=DAO::getAll("models\Virtualhost");

            $hostsItems=$this->semantic->htmlItems("list-virtualhosts");
            $hostsItems->fromDatabaseObjects($virtualhost, function($virtualhost){
            $item=new HtmlItem("");
            $item->addImage("public/img/virtualhost.png")->setSize("tiny");
            $item->addItemHeaderContent($virtualhost->getName(),"");

            return $item;
            });*/

            /**$nameserver=DAO::getAll("models\Server");
            $hostsItems=$this->semantic->htmlItems("list-nameserver");
            $hostsItems->fromDatabaseObjects($nameserver, function($nameserver){
            $item=new HtmlItem("");
            $item->setSize("tiny");
            $item->addItemHeaderContent($nameserver->getName(),"");
            return $item;
            });*/
        }
        else
        {
            //Utilisation de phpMv-UI
            //Pris dans le contrôler login
            //Pas obligé d'utiliser twing parce qu'on fait l'appel directement ici avec echo "$message"
            //Créer un objet "message" et on lui applique la méthode semantic (pour dire utilise sementic-ui)
            //et html message (permet de mettre "merci de vous connecter pour tester")
            $message=$this->semantic->htmlMessage("error","Merci de vous connecter pour tester.");
            //Rajoute l'icône au message affiché précédement avec la méthode setIcon créer par Mr HERON'
            $message->setIcon("announcement")->setError();
            //Ajouter la croix en haut à gauche pour fermer la mesage précédement affiché
            $message->setDismissable();
            //Permet d'ajouter le bouton pour le test, on a changé la librairie Login:: en Auth::
            //pour que cela focntionne
            $message->addContent(Auth::getInfoUser($this,"-login"));
            //Affichage de l'objet "$message"
            echo $message;
            //Utilisation de Java pour pouvoir cliquer sur le bouton pour s'identifier "connexion pour tests"
            echo $this->jquery->compile($this->view);
        }

    }
}
 
 
 
 
