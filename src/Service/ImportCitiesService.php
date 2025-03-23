<?php

namespace App\Service;

use App\Entity\City;
use League\Csv\Reader;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCitiesService
{
	public function __construct(
		private CityRepository $cityRepo,
		private EntityManagerInterface $em
	) {
	}

	public function importCities(SymfonyStyle $io): void
	{
		$io->title('Importation des villes');

		$cities = $this->readCsvFile(); // stocke toutes les villes

		$io->progressStart(count($cities)); // permet d'avoir une barre de progression dans le terminal

		foreach ($cities as $arrayCity) {
			$city = $this->createOrUpdateCity($arrayCity);
			$this->em->persist($city);

			$io->progressAdvance();
		}
		$this->em->flush();


		$io->progressFinish();
		$io->success('L\'importation est terminée');
	}

	private function readCsvFile(): Reader
	{
		$csv = Reader::createFromPath('%kernel.root.dir%/../import/cities.csv', 'r'); // class Reader (librairy : composer require	league/csv / kernel = repertoire root du projet ; mode Read
		$csv->setHeaderOffset(0); // header = ligne 0 du fichier

		return $csv;
	}


	private function createOrUpdateCity(array $arrayCity): City
	{
		$city = new City();

		$city
			->setInseeCode($arrayCity['insee_code'])
			->setZipCode($arrayCity['zip_code'])
			->setName($arrayCity['label']);

		return $city;
	}
}
