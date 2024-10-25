<?php
require_once "Controller.php";
require_once "Repository/AdminRepository.php";


// This class inherits the jsonResponse method  and the $cnx propertye from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class AdminController extends Controller
{

    private AdminRepository $admins;

    public function __construct()
    {
        $this->admins = new AdminRepository();
    }


    private function processSignInRequest(HttpRequest $request)
    {
        $name = $request->getParam('name');
        $password = $request->getParam('password');

        $admin = $this->admins->findByName($name);

        if (!$admin) {

            return "Ce compte n'existe pas";
        }

        if ($password == $admin->getPassword()) {
            // Set session cookie
            $_SESSION['authenticated'] = true;
            echo json_encode([
                'name' => $admin->getName(),
                'email' => $admin->getEmail()
            ]);
            header("Location: ../../backoffice/index.php");
            exit();
        }
        return "Mot de passe incorrect";
    }

    private function processSignoutRequest(HttpRequest $request)
    {
        session_destroy();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        }
        return true;
    }

    protected function processGetRequest(HttpRequest $request)
    {
        $id = $request->getId("id");




        if ($id) {
            // URI is .../products/{id}
            $p = $this->admins->find($id);
            return $p == null ? false :  $p;
        } else {
            return $this->admins->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request)
    {
        $id = $request->getId("id");



        if ($id == "signin") {
            return $this->processSigninRequest($request);
        }
        // if ($id == "signout") {
        //     return $this->processSignoutRequest($request);
        // } 
        {
            $json = $request->getJson();
            $obj = json_decode($json);
            $p = new Admin(0); // 0 is a symbolic and temporary value since the product does not have a real id yet.
            $p->setName($obj->name);
            $p->setEmail($obj->email);
            $p->setPassword($obj->password);
            $ok = $this->admins->save($p);
            return $ok ? $p : false;
        }
    }
}
