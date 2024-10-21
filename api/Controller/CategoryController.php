<?php
require_once "Controller.php";
require_once "Repository/CategoryRepository.php" ;


// This class inherits the jsonResponse method  and the $cnx propertye from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class CategoryController extends Controller {

    private CategoryRepository $category;

    public function __construct(){
        $this->category = new CategoryRepository();
    }

   
    protected function processGetRequest(HttpRequest $request) {
        $id = $request->getId("id");
        if ($id){
            // URI is .../categories/{id}
            $p = $this->category->find($id);
            return $p==null ? false :  $p;
        }
        else{
            // URI is .../categories
            $cat = $request->getParam("category"); // is there a category parameter in the request ?
            if ( $cat == false) // no request category, return all products
                return $this->category->findAll();
            // else // return only products of category $cat
            //     return $this->products->findAllByCategory($cat);
        }
    }

    protected function processPostRequest(HttpRequest $request) {
        $json = $request->getJson();
        $obj = json_decode($json);
        $p = new Category(0); // 0 is a symbolic and temporary value since the product does not have a real id yet.
        $p->setName($obj->name);
        $p->setImage($obj->image);
        $p->setIcone($obj->icone);

        $ok = $this->category->save($p); 
        return $ok ? $p : false;
    }
   
}

?>