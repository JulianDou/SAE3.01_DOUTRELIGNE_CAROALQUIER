<?php
require_once "Controller.php";
require_once "Repository/CommandeRepository.php";


// This class inherits the jsonResponse method  and the $cnx propertye from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class CommandeController extends Controller
{

    private CommandeRepository $products;

    public function __construct()
    {
        $this->products = new CommandeRepository();
    }


    protected function processGetRequest(HttpRequest $request)
    {
        $id = $request->getId("id");

        if ($id) {
            $p = $this->products->find($id);
            return $p == null ? false : $p;
        } else {
            return $this->products->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request)
    {
        $json = $request->getJson();
        $obj = json_decode($json);
        $p = new Commande(0); // 0 is a symbolic and temporary value since the product does not have a real id yet.
        $ok = $this->products->save($p);
        return $ok ? $p : false;
    }
}
