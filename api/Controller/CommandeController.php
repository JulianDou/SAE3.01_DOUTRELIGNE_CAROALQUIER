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

        if ($id == "me") {
            return $this->products->findByUser();
        }
        if ($id) {
            $p = $this->products->find($id);
            return $p == null ? false : $p;
        } else {
            return $this->products->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request)
    {
    


    // Accéder aux données du tableau
    $products = json_decode($_POST['items'], true);


    // On vérifie que l'utilisateur est authentifié
    $clientId = $_SESSION['client']->getId();

    $commande = new Commande(0); // 0 est une valeur symbolique temporaire
    $commande->setIdClient($clientId);

    // Ajouter les produits à la commande
    foreach ($products as $product) {
        $commande->addProduct(
            $product['id_produits'],
            $product['quantity'],
            $product['price'],
            $product['id_options']
        );
    }

    $ok = $this->products->save($commande);
    return $ok ? $commande : false;
    }
}
