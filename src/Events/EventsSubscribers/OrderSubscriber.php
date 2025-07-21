<?php

namespace App\Events\EventsSubscribers;

use Throwable;
use App\Entity\User;
use App\Entity\Order;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\UserRepository;
use App\Service\NotifierService\EmailVerificationNotifierServiceInterface;

final class OrderSubscriber implements ProcessorInterface
{
    public function __construct(
        private readonly UserRepository $repo,
        private readonly EmailVerificationNotifierServiceInterface $notifier,
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        try {
            if (!$data instanceof Order) {
                throw new InvalidArgumentException('La commande est non conforme.');
            }

            $buyer = $data->getBuyer() ?? null;

            if (!($buyer instanceof User)) {
                throw new InvalidArgumentException('L\'utilisateur est non conforme.');
            }

            if (!$buyer->getId()) {
                $this->em->persist($buyer);
            }

            return $data;
        } catch (Throwable $e) {
            $this->logger->error('ERROR : ' . $e->getMessage());
            throw $e;
        }
    }
}
