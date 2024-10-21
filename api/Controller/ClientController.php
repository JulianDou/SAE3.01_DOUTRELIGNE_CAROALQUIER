<?php
require_once "Controller.php";
require_once "Repository/ClientRepository.php";


// This class inherits the jsonResponse method  and the $cnx propertye from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class ClientController extends Controller
{

    private ClientRepository $clients;

    public function __construct()
    {
        $this->clients = new ClientRepository();
    }


    protected function processGetRequest(HttpRequest $request)
    {
        $id = $request->getId("id");
        if ($id) {
            // URI is .../products/{id}
            $p = $this->clients->find($id);
            return $p == null ? false :  $p;
        } else {
            return $this->clients->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request)
    {
        $json = $request->getJson();
        $obj = json_decode($json);
        $p = new Client(0); // 0 is a symbolic and temporary value since the product does not have a real id yet.
        $p->setName($obj->name);
        $p->setEmail($obj->email);
        $p->setPassword($obj->password);
        $ok = $this->clients->save($p);
        return $ok ? $p : false;
    }
}
