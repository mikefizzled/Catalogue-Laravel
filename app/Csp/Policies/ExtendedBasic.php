<?php

namespace App\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Keyword;

class ExtendedBasic extends Basic
{
    public function configure(): void
    {
        parent::configure();

        // — PRODUCTION & DEV: your “always-allowed” sources —

        $this

            ->addDirective(Directive::SCRIPT,      'self')
            ->addDirective(Directive::SCRIPT_ELEM, 'self')
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::SCRIPT_ELEM)

            ->addDirective(Directive::STYLE,       'self', 'fonts.bunny.net')
            ->addDirective(Directive::STYLE_ELEM,  'self', 'fonts.bunny.net')
            ->addNonceForDirective(Directive::STYLE)
            ->addNonceForDirective(Directive::STYLE_ELEM)

            // External resources
            ->addDirective(Directive::FONT,        'fonts.bunny.net')
            ->addDirective(Directive::IMG,         'https://bird-dev-laravel.s3.eu-west-2.amazonaws.com');


        if (app()->environment('local')) {
            $devHttp = 'http://localhost:5173';
            $devWs   = 'ws://localhost:5173';

            $this
                // Vite’s injected module & element scripts
                ->addDirective(Directive::SCRIPT,      $devHttp)
                ->addDirective(Directive::SCRIPT_ELEM, $devHttp)
                // Allow Alpine’s runtime eval in dev
                ->addDirective(Directive::SCRIPT,      Keyword::UNSAFE_EVAL)

                // Vite’s injected module & element styles
                ->addDirective(Directive::STYLE,       $devHttp)
                ->addDirective(Directive::STYLE_ELEM,  $devHttp)

                // HMR websocket
                ->addDirective(Directive::CONNECT,     $devWs);
        }
    }
}
