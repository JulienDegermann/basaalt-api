<?php

namespace App\Controller;

use App\Repository\BandRepository;
use App\Repository\SongRepository;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\PlateformRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/{url}', 
    name: 'app_home', 
    requirements: ['url' => '(?!admin).*'], 
    defaults: ['url' => ''])]
    public function index(
        BandRepository $bandRepo,
        UserRepository $userRepo,
        SongRepository $songRepo,
        PlateformRepository $plateformRepo,
        ArticleRepository $articleRepo,
        SerializerInterface $serializer

    ): Response {

        $bandMembers = $userRepo->findBandMembers();
        $plateformLinks = $plateformRepo->findAll();

        $band = $bandRepo->findAll();

        $newBandMembers = [];
        foreach ($bandMembers as $bandMember) {
            $newBandMembers[] = $bandMember;
        }

        $articles = $articleRepo->findAll();
        dd($articles);

        $newPlateformLinks = [];
        foreach ($plateformLinks as $plateformLink) {
            $newPlateformLinks[] = $plateformLink;
        }

        $datas = [
            "bandMembers" => $newBandMembers,
            "plateformLinks" => $newPlateformLinks,
            "band" => $band
        ];



        

        $jsonDatas = $serializer->serialize($datas, 'json');

        return new Response($jsonDatas, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
