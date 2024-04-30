<?php

namespace App\Orchid\Screens;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Cropper;
use Twilio\Rest\Client;
use App\Models\Agreement;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class AgreementEditScreen extends Screen
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
        return $this->agreement->exists ? 'Edit agreement' : 'Creating a new agreement';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return 'Edit/View Agreement';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create agreement')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->agreement->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->agreement->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->agreement->exists),

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('agreement.CustomerFirstName')
                    ->title('Customer First Name')
                    ->help('Enter Customer First Name')
                    ->required(),

                Input::make('agreement.CustomerLastName')
                    ->title('Customer Last Name')
                    ->help('Enter Customer Last Name.')
                    ->required(),

                Input::make('agreement.CustomerEmail')
                    ->type('email')
                    ->title('Customer Email')
                    ->help('Enter Customer Email')
                    ->placeholder('example@example.com')
                    ->required(),

                Input::make('agreement.CustomerPhone')
                    ->title('Customer Phone')
                    ->help('Enter Customer Phone Number')
                    ->mask([
                        'numericInput' => true
                    ])
                    ->required(),

                Input::make('agreement.CompanyName')
                    ->title('Company Name')
                    ->help('Enter Company Name')
                    ->required(),
                Cropper::make('agreement.Logo')
                    ->title('Enter and Crop the Logo')
                    ->width(1000)
                    ->height(500)
                    ->required(),

                TextArea::make('agreement.CompanyDescription')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Enter Company Description')
                    ->required(),

                Input::make('agreement.Address')
                    ->title('Address')
                    ->help('Enter your Address.')
                     ->required(),
                Input::make('agreement.City')
                    ->title('City')
                    ->help('Enter your City.')
                    ->required(),


                Select::make('agreement.Province')
                    ->title('Payment Province')
                    ->options(['Ontario', 'Quebec', 'PEI', 'New Brunswick'])
                    ->title('Province')
                    ->help('Enter your Province.')
                    ->required(),


                Input::make('agreement.PostalCode')
                    ->title('PostalCode')
                    ->help('Enter your Postal Code.'),

                Input::make('agreement.WebsiteHeaderName')
                    ->title('WebsiteHeaderName')
                    ->help('Please enter the name you want in website header.'),

                Input::make('agreement.WebsiteDomain')
                    ->title('WebsiteDomain')
                    ->type('url')
                    ->placeholder('https://example.com')
                    ->help('Enter your website URL.'),

                Input::make('agreement.WebsiteHeaderColor')
                    ->type('color')
                    ->title('Website Header Color')
                    ->value('#563d7c')
                    ->horizontal(),

                Input::make('agreement.WebsiteFooterColor')
                    ->type('color')
                    ->title('Website Footer Color')
                    ->value('#563d7c')
                    ->horizontal(),

                CheckBox::make('agreement.WebsiteContactUsPage')
                    ->title('Contact Us Page')
                    ->value(1),

                CheckBox::make('agreement.WebsiteMeetTheTeamPage')
                    ->title('Meet The Team Page')
                    ->value(1),

                CheckBox::make('agreement.WebsiteProductsPage')
                    ->title('Products Page')
                    ->value(1),

                Select::make('agreement.PaymentMethod')
                    ->title('Payment Method')
                    ->options(['Card', 'Cash']),

                Input::make('agreement.CardNumber')
                    ->title('CardNumber')
                    ->help('You can leave this blank if you picked cash or if you want us to contact you.'),

                Input::make('agreement.CVV')
                    ->title('CVV')
                    ->help('You can leave this blank if you picked cash or if you want us to contact you.'),

                Input::make('agreement.Expiry')
                    ->title('Expiry')
                    ->help('You can leave this blank if you picked cash or if you want us to contact you.'),

            ])
        ];
    }


    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients,
            ['from' => $twilio_number, 'body' => $message] );
    }

    public function createOrUpdate(Request $request)
    {
        $this->agreement->fill($request->get('agreement'))->save();
        $cfname = $this->agreement["CustomerFirstName"];
        $clname = $this->agreement["CustomerLastName"];
        $message = "Hi, the agreement for ".$cfname." ".$clname." has been processed";
        $this->sendMessage($message, $this->agreement["CustomerPhone"]);
        Alert::info('You have successfully created an agreement.');
        return redirect()->route('platform.agreement.list');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->agreement->delete();

        Alert::info('You have successfully deleted the agreement.');

        return redirect()->route('platform.agreement.list');
    }

}
