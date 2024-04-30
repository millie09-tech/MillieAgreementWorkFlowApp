<?php

namespace App\Orchid\Screens;

use App\Models\Agreement;
use App\Orchid\Layouts\AgreementListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class AgreementListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'agreements' => Agreement::paginate()
        ];    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Agreement List Screen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.agreement.edit')
        ];
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Agreements";
    }
    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            AgreementListLayout::class
        ];
    }
}
