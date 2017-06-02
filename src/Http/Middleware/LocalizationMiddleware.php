<?php
namespace Infrastructure\Http\Middleware;

use Aura\Intl\TranslatorLocator;
use Dflydev\FigCookies\FigRequestCookies;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class LocalizationMiddleware
 * @package Tradesii\Http\Middleware
 *
 * Restricts a route based upon the HTTP REFERER
 */
class LocalizationMiddleware implements MiddlewareInterface
{
    /**
     * @var TranslatorLocator
     */
    private $translatorLocator;

    /** @var array */
    private $langs;

    /**
     * LocalizationMiddleware constructor.
     *
     * @param TranslatorLocator $translatorLocator
     * @param array $langs
     */
    public function __construct(TranslatorLocator $translatorLocator, array $langs = [])
    {
        $this->translatorLocator = $translatorLocator;
        $this->langs = $langs;
    }

    public function __invoke(Request $serverRequest, Response $response, callable $next)
    {
        $locale = FigRequestCookies::get($serverRequest, 'language', 'en_CA')->getValue();

        if (!in_array($locale, $this->langs, true)) {
            $locale = 'en_CA';
        }

        $this->translatorLocator->setLocale($locale);

        return $next($serverRequest, $response);
    }
}