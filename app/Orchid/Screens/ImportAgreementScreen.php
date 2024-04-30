<?php

namespace App\Orchid\Screens;

use App\Models\Agreement;
use Illuminate\Http\Request;
use Orchid\Attachment\File;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Attachment;

class ImportAgreementScreen extends Screen
{
    public $agreement;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Agreement $agreement): array
    {
        return [
            'agreement' => $agreement,

        ];

    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Import Agreement Screen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Import an Agreement')
                ->modal('ImportModal')
                ->icon('plus')->method('createImported')
        ];
    }


    public function createImported(Request $request){
        $t = $request->input('attachment');
        $t =str_replace("\t", "", $t);
        $t =str_replace("\n", "", $t);
        $t =str_replace("\r", "", $t);
        $arr = (array) json_decode($t,true);
        $this->agreement->fill($arr)->save();
        return redirect()->route('platform.agreement.edit', $this->agreement->id);





    }
    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return
            [
        Layout::modal('ImportModal', Layout::rows([
            TextArea::make('attachment')

        ]))
            ->title('Create Agreement, add JSON here')
            ->applyButton('Add Agreement'),
        ];
    }
}
