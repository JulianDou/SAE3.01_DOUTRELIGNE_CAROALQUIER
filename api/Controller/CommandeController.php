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
            // On donne les commandes de l'utilisateur qui fait la requête
            return $this->products->findByUser();
        } else
        if ($id) {
            // Si on a un id, on renvoie la commande correspondante
            $p = $this->products->find($id);

            // On vérifie s'il y a unb paramètre "duplicate=true" dans la requête
            if ($request->getParam("duplicate") == true) {
                // On duplique la commande pour l'utilisateur qui fait la requête
                $p = $this->products->duplicate($p);
            }
            return $p == null ? false : $p;
        } else {
            // Sinon on renvoie la liste de tous les produits
            return $this->products->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request)
    {
        $id = $request->getId("id");
        // Si on a comme id stock, on fait un update du stock
        if ($id == "stock") {
            // On récupère les données JSON de la requête
            $data = json_decode(file_get_contents('php://input'), true);
            $idProduits = $data['id_produits'];
            $idOptions = $data['id_options'];
            $quantity = $data['quantity'];

            // On met à jour le stock
            $ok = $this->products->updateStock($idProduits, $idOptions, $quantity);
            return $ok ? true : false;
        }

        // Si on a comme id status, on fait un update du statut de la commande
        if ($id == "status") {

            // On récupère les données JSON de la requête
            $data = json_decode(file_get_contents('php://input'), true);
            $idCommande = $data['id_commandes'];
            $statut = $data['status'];


            $commande = $this->products->find($idCommande);

            // Si la commande existe on la met à jour
            if ($commande) {
                $commande->setStatut($statut);
                $ok = $this->products->update($commande);
                return $ok ? $commande : false;
            } else {
                return false;
            }
        }

        // SI on a comme id "update", on met à jour une commande
        if ($id == "update") {
            // On récupère les données JSON de la requête
            $idCommande = $_POST['id_commandes'];
            $statut = $_POST['status'];
            $products = json_decode($_POST['products'], true);

            $commande = $this->products->find($idCommande);
            // Si la commande existe on la met à jour
            if ($commande) {
            $commande->setStatut($statut);
            $ok = $this->products->update($commande); // Update the status first
            if (!$ok) {
                return false;
            }
            foreach ($products as $product) {
                $idProduits = $product['id_produits'];
                $idOptions = $product['id_options'];
                $quantity = $product['quantity'];
                $ok = $this->products->updateProduct($idProduits, $idOptions, $quantity);
                if (!$ok) {
                return false;
                }
            }
            return $commande;
            } else {
            return false;
            }
        }

        // Si on a pas d'id, on crée une nouvelle commande

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
