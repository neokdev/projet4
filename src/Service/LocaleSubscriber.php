<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 14/02/2018
 * Time: 00:19
 */

namespace App\Service;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        // try to see if the locale has been set as a _locale routing parameter
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }

//    /**
//     * @var RequestStack
//     */
//    private $stack;
//
//    public function __construct(RequestStack $stack)
//    {
//        $this->stack = $stack;
//    }
//    public function setLocale($products)
//    {
//        $request = $this->stack->getMasterRequest();
//        if ($request->getLocale() == 'fr') {
//            $this->setLocale(LC_TIME, 'fr', 'fr');
//            $selectedDate = utf8_encode(strftime('%A %d %B %Y', $products->format('U')));
//        }
//        if ($request->getLocale() == 'en') {
//            setlocale(LC_TIME, 'en','en');
//            $selectedDate = $products->format('D, d M Y');
//        }
//        return $selectedDate;
//    }
}