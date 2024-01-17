<?php
namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;

class FrontendAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::FRONTEND_CALL_ACTION, [$this, 'enqueueStyles']);
    }

    public function enqueueStyles(): void
    {
        $this->hookAction->enqueueFrontendScript(
            'subs-js',
            plugin_asset('js/frontend/pricing.min.js', 'juzaweb/membership')
        );
        $this->hookAction->enqueueFrontendStyle(
            'subs-css',
            plugin_asset('css/frontend/pricing.min.css', 'juzaweb/membership')
        );
    }
}
