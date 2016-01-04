<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface {

    /**
     * List of supported locales.
     *
     * @var string[]
     */
    private $locales = array();

    /**
     * @var string
     */
    private $defaultLocale = '';

    /**
     * Constructor.
     *
     * @param string $locales Supported locales separated by '|'
     * @param string|null $defaultLocale
     */
    public function __construct($locales, $defaultLocale = null) {

        $this->locales = $locales;
        if (empty($this->locales)) {
            throw new \UnexpectedValueException('The list of supported locales must not be empty.');
        }

        $this->defaultLocale = $defaultLocale ? : $this->locales[0];

        if (!in_array($this->defaultLocale, $this->locales)) {
            throw new \UnexpectedValueException(sprintf('The default locale ("%s") must be one of "%s".', $this->defaultLocale, $locales));
        }

        array_unshift($this->locales, $this->defaultLocale);
        $this->locales = array_unique($this->locales);
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();

        $locale = $request->attributes->get('_locale');
        if ($locale) {
            $request->getSession()->set('_locale', $locale);
        }

        // If user selected locale
        if (!$request->getSession()->get('_locale')) {

            // Set preferred language
            $preferredLanguage = $request->getPreferredLanguage($this->locales);
            if ($preferredLanguage !== $this->defaultLocale) {
                $request->getSession()->set('_locale', $preferredLanguage);
            } else {
                $request->getSession()->set('_locale', $this->defaultLocale);
            }
        }

        $request->setLocale($request->getSession()->get('_locale'));
    }

    /**
     * 
     * @return type
     */
    public static function getSubscribedEvents() {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }

}
