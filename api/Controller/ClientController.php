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

    private function processSignUpRequest(HttpRequest $request)
    {
        $email = $request->getParam('email');
        $password = $request->getParam('password');

        $client = $this->clients->findByEmail($email);

        if ($client) {
            return false;
        }

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $client = new Client(0); // Assuming 0 is a placeholder for the client ID

        $clientdata = [];
        $clientdata['email'] = $email;
        $clientdata['password'] = $hash_password;
        $clientdata['name'] = $request->getParam('name');

        $client->setEmail($clientdata['email']);
        $client->setPassword($clientdata['password']);
        $client->setName($clientdata['name']);

        $this->clients->save($client);

        // Set session cookie
        session_start();
        $_SESSION['client_id'] = $client->getId();
        
        return true;
    }

    private function processSignInRequest(HttpRequest $request)
    {
        $email = $request->getParam('email');
        $password = $request->getParam('password');

        $client = $this->clients->findByEmail($email);

        if (!$client) {

            return "Ce compte n'existe pas";
        }

        if (password_verify($password, $client->getPassword())) {
            // Set session cookie
            session_start();
            $_SESSION['client_id'] = $client->getId();

            return true;
        }
        return "Mot de passe incorrect";
    }

    private function processSignoutRequest(HttpRequest $request)
    {
        session_start();
        session_destroy();
        return true;
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
        $id = $request->getId("id");



        if ($id == "signup") {
            return $this->processSignUpRequest($request);
        }
        if ($id == "signin") {
            return $this->processSigninRequest($request);
        }
        if ($id == "signout") {
            return $this->processSignoutRequest($request);
        }


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
}
