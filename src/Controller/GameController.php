<?php

namespace App\Controller;

use App\Game\GameInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GameController extends AbstractController
{
    /**
     * @var GameInterface $game
     */
    private $game;

    public function __construct(GameInterface $game)
    {
        $this->game= $game;
    }

    public function move(Request $request)
    {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        try {
            $result = $this->game->playNextMove($parametersAsArray["board"], $parametersAsArray["playerUnit"]);
        }

        catch(\Exception $ex)
        {
            error_log($ex->getMessage(), 0);
            $result = array("error" => $ex->getMessage());
        }

        return new Response(json_encode($result));
    }
}
