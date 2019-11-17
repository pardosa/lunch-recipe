<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nahid\JsonQ\Jsonq;

class LunchController extends AbstractController
{
    /**
     * @Route("/lunch", name="lunch")
     */
    public function index()
    {

        $recipes = file_get_contents(__DIR__.'/../Data/Recipe/data.json');

        $recipesArray = json_decode($recipes,true);
        
        $qIn = new Jsonq(__DIR__.'/../Data/Ingredient/data.json');
        $resIn = $qIn->from('ingredients')
            ->select('title')
            ->where('use-by', '>', date("Y-m-d"))
            ->sortBy('best-before', 'desc')
            ->get();

        $arrIng = [];
        foreach($resIn as $res){
            array_push($arrIng, $res['title']);
        }
        
        $arrRec = [];
        foreach($recipesArray['recipes'] as $rec){
            if (count(array_diff($rec['ingredients'], $arrIng)) == 0)
                array_push($arrRec, $rec);
        }

        $response = new JsonResponse();
        $response->setData($arrRec);
        return $response;

        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/LunchController.php',
        // ]);
    }
}
