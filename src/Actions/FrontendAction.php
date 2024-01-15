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
            url('jw-styles/plugins/juzaweb/membership/js/frontend/pricing.min.js')
        );
        $this->hookAction->enqueueFrontendStyle(
            'subs-css',
            url('jw-styles/plugins/juzaweb/membership/css/frontend/pricing.min.css')
        );
    }
}
