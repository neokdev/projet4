<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\DateFormType;
use App\Form\PriceFormType;
use App\Repository\ProductsRepository;
use App\Service\FlashManager;
use App\Service\LocaleManager;
use App\Service\Wizard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class OrderController
 * @package App\Controller
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="app_order_date")
     * @param Request $request
     * @param Translator $translator
     * @return Response
     */
    public function index(Request $request,
                          SessionInterface $session,
                          FlashManager $flashManager,
                          ProductsRepository $productsRepository,
                          TranslatorInterface $translator,
                          Wizard $wizard):Response
    {
        // Values for the order status  progress bar
        $progress = [
            'value' => 1,
            'type' => 'info',
            'message' => ''
        ];
        //Create the Form
        $dateform = $this->createForm(DateFormType::class);
        $priceform = $this->createForm(PriceFormType::class);
        // Init the form
        $dateform->handleRequest($request);
        $priceform->handleRequest($request);

        if ($dateform->get('order.next_step')->isClicked() && $dateform->isValid()) {

            $em = $this->getDoctrine()->getManager();
//            $products->setDate($dateform['date']->getData());
            $em->persist($products);

            $productsdate = $products->getDate('date');
//            $selectedDate = $localeManager->formatDates($productsdate);

            // Values for the order status  progress bar
            $progress = [
                'value' => 1,
                'type' => 'success',
                'message' => 'date ok'
            ];
            //Prepare date format for flash message
            if ($request->getLocale() == 'fr') {
                setlocale(LC_TIME, 'fr','fr');
                $selectedDate = utf8_encode(strftime('%A %d %B %Y', $products->getDate('date')->format('U')));
            }
            if ($request->getLocale() == 'en') {
                setlocale(LC_TIME, 'en','en');
                $selectedDate = $products->getDate('date')->format('D, d M Y');
            }
            //Display the Flash message
            $flashManager->add(
                'info alert alert-info text-center',
                'flash.dateandtickets %selecteddate% %ticketsavalaible%',
                array(
                    '%selecteddate%' => $selectedDate,
                    '%ticketsavalaible%' => 1000 -$productsRepository->ticketsForThisDate($products->getDate()),
                ));
            return $this->render('price.html.twig', [
                'test' => [
                    'Date Form Getdata' => $dateform->getData(),
                    'String Product date' => $products->getDate('date')->format('D, d M Y'),
                    'Productdate' => $productsdate,
                    'Get Locale' => $request->getLocale()],
                //'selecteddate' => $selectedDate,
                'progress' => $progress,
            ]);
        }

        return $this->render('order.html.twig', [
            'test' => [
                'Date Form Getdata' => $dateform->getData(),
                'Get Locale from request' => $request->getLocale(),
                'Get Locale from session' => $session->get('_locale')],
            'progress' => $progress,
            'form' => $dateform->createView(),
            'priceform' => $priceform->createView(),
        ]);
    }
}
