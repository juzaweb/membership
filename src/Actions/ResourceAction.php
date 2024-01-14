<?php
namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;

class ResourceAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'enqueueStyles']);
    }

    public function enqueueStyles(): void
    {
        $this->hookAction->enqueueScript(
            'subs-js',
            plugin_asset('js/frontend/index.js', 'juzaweb/membership')
        );
        $this->hookAction->enqueueScript(
            'subs-css',
            plugin_asset('css/frontend/index.js', 'juzaweb/membership')
        );
    }
}
