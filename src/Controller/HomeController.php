<?php

namespace App\Controller;

use App\Repository\BandRepository;
use App\Repository\SongRepository;
use App\Repository\UserRepository;
use App\Repository\AlbumRepository;
use App\Repository\ArticleRepository;
use App\Repository\PlateformRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
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
        // $band = $serializer->serialize($band, 'json');
        // $band = json_decode($band);

        $newBandMembers = [];
        foreach ($bandMembers as $bandMember) {
            // $bandMember = $serializer->serialize($bandMember, 'json');
            // $bandMember = json_decode($bandMember);
            $newBandMembers[] = $bandMember;
        }

        $articles = $articleRepo->findAll();
        dd($articles);

        $newPlateformLinks = [];
        foreach ($plateformLinks as $plateformLink) {
            // $plateformLink = $serializer->serialize($plateformLink, 'json');
            // $plateformLink = json_decode($plateformLink);
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
