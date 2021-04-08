<?php

namespace App\Http\Policies;

use Illuminate\Http\Request;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy extends Policy
{
    public function configure(): void
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::CHILD, Keyword::NONE)
            ->addDirective(Directive::CONNECT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::FRAME, Keyword::NONE)
            ->addDirective(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->addDirective(Directive::MANIFEST, Keyword::NONE)
            ->addDirective(Directive::MEDIA, Keyword::NONE)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::WORKER, Keyword::NONE)
            ->addDirective(Directive::IMG, Keyword::SELF)
            ->addDirective(Directive::IMG, 'https://avatars.githubusercontent.com')
            ->addDirective(Directive::IMG, 'https://images.unsplash.com')
            ->addDirective(Directive::SCRIPT, Keyword::SELF)
            ->addDirective(Directive::SCRIPT, Keyword::UNSAFE_EVAL)
            ->addDirective(Directive::STYLE, Keyword::SELF)
            ->addDirective(Directive::STYLE, Keyword::UNSAFE_INLINE)
            ->addDirective(Directive::FONT, Keyword::SELF)
            ->addNonceForDirective(Directive::SCRIPT);
    }

    public function shouldBeApplied(Request $request, Response $response): bool
    {
        if (app()->environment('local') && config('debugbar.enabled')) {
            return false;
        }

        return config('csp.enabled') && empty($response->exception);
    }
}
