<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class KitchenDisplaySystemController extends AbstractController
{
    #[Route('/', name: 'index')]
    #[Route('/kds', name: 'app_kitchen_display_system')]
    public function index(): Response
    {
        return $this->render('kitchen_display_system/index.html.twig', [
            'controller_name' => 'KitchenDisplaySystemController',
        ]);
    }

    #[Route('/kds/getOrders', name: 'app_kitchen_display_system_get_orders')]
    public function getOrders(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Order::class);
        $orders = $repository->findUndeliveredOrders();

        $json = [];

        foreach ($orders as $order) {
            $orderItemsJson = [];
            foreach ($order->getItems() as $item) {
                $orderItemsJson[] = [
                    'quantity' => $item->getQuantity(),
                    'description' => $item->getDescription()
                ];
            }
            $json[] = [
                'items' => $orderItemsJson,
                'table' => $order->getTableIdentifier(),
                'waitingSeconds' => (new DateTimeImmutable())->getTimestamp() - $order->getOrderedAt()->getTimestamp(),
            ];
        }

        return new JsonResponse($json);
    }



    #[Route('/kds/fill', name: 'app_kitchen_display_system_filler')]
    public function fill(EntityManagerInterface $entityManager): Response
    {
        $foods = ['Burger', 'Fries', 'Milk-shake'];

        $dateTime = new DateTimeImmutable();
        $ts = $dateTime->getTimestamp();
        for ($i = 0; $i < 10; $i++) {
            $order = new Order;
            $order->setTableIdentifier('Table '.random_int(1, 30));
            $order->setOrderedAt($dateTime->setTimestamp(random_int($ts - 3600, $ts)));

            $orderItem = new OrderItem;
            $orderItem->setQuantity(random_int(1, 10));
            $orderItem->setDescription($foods[random_int(0, count($foods)-1)]);

            $order->addItem($orderItem);

            $entityManager->persist($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_kitchen_display_system');
    }
}
