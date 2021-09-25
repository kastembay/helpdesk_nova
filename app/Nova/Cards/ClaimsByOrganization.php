<?php


namespace App\Nova\Cards;


use App\Models\Claim;
use App\Models\Contact;
use App\Models\Organization;

class ClaimsByOrganization extends \Mako\CustomTableCard\CustomTableCard
{
    public function __construct(array $header = [], array $data = [], string $title = '', array $viewall = [])
    {
        $header = collect([__('Organization'), __('Claims')]);

        $this->title(__('Applications by organization'));

        $this->viewall(['label' => 'Посмотреть заявки', 'link' => '/resource/claims']);

        $organizations = Organization::with('contacts', 'claims')->get();


        $this->header($header->map(function($value) {
            // Make the Status column sortable
            return ($value === 'Claims') ?
                (new \Mako\CustomTableCard\Table\Cell($value))->sortable(true) :
                new \Mako\CustomTableCard\Table\Cell($value);
        })->toArray());

        $this->data($organizations->map(function($organization) {
            return new \Mako\CustomTableCard\Table\Row(
                new \Mako\CustomTableCard\Table\Cell($organization->company),
                new \Mako\CustomTableCard\Table\Cell($organization->claims->count()),
                // Instead of alphabetically ordering the status, set a sortableData value for better representation
            );
        })->toArray());
    }

}
