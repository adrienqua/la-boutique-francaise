<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/account/address', name: 'app_account_address')]
    public function index(Request $request): Response
    {
        $address = new Address();
        $address->setUser($this->getUser());

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($address);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('account_address/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/address/{id}', name: 'app_account_address_edit')]
    public function edit(Request $request, AddressRepository $addressRepository, $id): Response
    {
        $address = $addressRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('account_address/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/address/{id}/delete', name: 'app_account_address_delete')]
    public function delete(Request $request, AddressRepository $addressRepository, $id): Response
    {
        $address = $addressRepository->findOneBy(['id' => $id]);

        $this->entityManager->remove($address);

        $this->entityManager->flush();

        return $this->redirectToRoute('app_profile');
    }
}
