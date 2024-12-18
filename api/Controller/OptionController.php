<?php
require_once "Controller.php";
require_once "Repository/OptionRepository.php";


// This class inherits the jsonResponse method  and the $cnx propertye from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class OptionController extends Controller
{

    private OptionRepository $products;

    public function __construct()
    {
        $this->products = new OptionRepository();
    }


    protected function processGetRequest(HttpRequest $request)
    {
        $id = $request->getId("id");

        if ($id) {

            $opt = $request->getParam("option"); // is there a category parameter in the request ?
            if ($opt == false) { // no request category, return all products
                // URI is .../products/{id}
                $p = $this->products->find($id);
                return $p == null ? false :  $p;
            } else {

                // URI is .../products/{id}?option={option}
                $p = $this->products->find($id);
                $res = [];
                foreach ($p as $obj) {
                    if ($obj->getIdOptions() == $opt) {
                        array_push($res, $obj);
                    }
                }
                return $res;
            }
        } else {
            return $this->products->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request)
    {
        $json = $request->getJson();
        $obj = json_decode($json);
        $p = new Option(0); // 0 is a symbolic and temporary value since the product does not have a real id yet.
        $p->setName($obj->name);
        $ok = $this->products->save($p);
        return $ok ? $p : false;
    }
}
