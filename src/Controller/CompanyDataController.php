<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contracts\CompanyInfoCollector\CompanyInfoCollector;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class CompanyDataController extends AbstractController
{
    public function __construct(
        private CompanyInfoCollector $companyInfoCollector,
        private EntityManagerInterface $entityManager,
    )
    {

    }

    #[Route('/companies/add', methods: ['GET'])]
    public function addOneForm(): Response
    {
        return $this->render('companies/add.html.twig');
    }

    #[Route('/companies/add', methods: ['POST'])]
    public function addOne(Request $request): Response
    {
        try {
            $data = $this->companyInfoCollector->collect(
                $request->request->get('inn')
            );
        } catch (Throwable) {
            return $this->render('companies/add.html.twig', [
                'err_message' => 'Внутренняя ошибка сервера'
            ]);
        }

        if (!$data) {
            return $this->render('companies/add.html.twig', [
                'err_message' => 'Не существует'
            ]);
        }

        $entity = new Company();
        $entity->setName($data->name);
        $entity->setOkved($data->okved);
        $entity->setActivity($data->activity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return new RedirectResponse($this->generateUrl('companies'));
    }

    #[Route('/companies', name: 'companies', methods: ['GET'])]
    /**
     * Выводит список всех компаний
     */
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('companies/index.html.twig', [
            'companies' => $companyRepository->findAll()
        ]);
    }
}
