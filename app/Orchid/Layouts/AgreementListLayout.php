<?php

namespace App\Orchid\Layouts;

use App\Models\Agreement;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class AgreementListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    public $target = 'agreements';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [

            TD::make('CustomerFirstName', 'Customer First Name')
                ->render(function (Agreement $agreement) {
                    return Link::make($agreement->CustomerFirstName)
                        ->route('platform.agreement.edit', $agreement);
                }),
            TD::make('CompanyName', 'Company Name')
                ->render(function (Agreement $agreement) {
                    return Link::make($agreement->CompanyName)
                        ->route('platform.agreement.edit', $agreement);
                }),
            TD::make('CustomerEmail', 'Customer Email')
                ->render(function (Agreement $agreement) {
                    return Link::make($agreement->CustomerEmail)
                        ->route('platform.agreement.edit', $agreement);
                }),
            TD::make('CustomerPhone', 'Customer Phone')
                ->render(function (Agreement $agreement) {
                    return Link::make($agreement->CustomerPhone)
                        ->route('platform.agreement.edit', $agreement);
                }),
            
            TD::make('created_at', 'Created'),
        ];
    }
}
