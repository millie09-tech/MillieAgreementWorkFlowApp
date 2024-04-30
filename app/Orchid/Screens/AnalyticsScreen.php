<?php

namespace App\Orchid\Screens;
use App\Models\Agreement;
use App\Orchid\Filters\GetDifferentProv;
use App\Orchid\Filters\GetNumAgreementsFilter;
use App\Orchid\Filters\GetNumPerMonthAgreements;
use App\Orchid\Filters\GetNumPerYearAgreements;

use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\ChartPieExample;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class AnalyticsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        $numOfAgreements = count(Agreement::filters([GetNumAgreementsFilter::class])->simplePaginate());
        $numall = count(Agreement::all());
        $numPerMonth = count(Agreement::filters([GetNumPerMonthAgreements::class])->simplePaginate());
        $numPerYear = count(Agreement::filters([GetNumPerYearAgreements::class])->simplePaginate());
        $prov_arr= Agreement::filters([GetDifferentProv::class])->get();

        $prov_keys = array();
        $prov_counts = array();
        foreach ($prov_arr as $p=>$val){
            $vals = explode(",", $val);
            $secondvals = explode(":", $vals[0]);
            $thirdvals = explode(":", $vals[1]);
            $thirdvals[1] = str_replace("}", "", $thirdvals[1]);
            array_push($prov_keys, $secondvals[1]);
            array_push($prov_counts,  $thirdvals[1]);



        }

        return [

            'metrics' => [
                'num'    => ['value' => number_format($numall)],
                'numToday' => ['value' => number_format($numOfAgreements)],
                'numThisMonth'   => ['value' => number_format($numPerMonth)],
                'numThisYear'    => ['value' => number_format($numPerYear)],
            ],


            'charts'  => [
                [
                    'name'   => 'Agreements Broken Down By Province',
                    'values' => $prov_counts,
                    'labels' => $prov_keys
                ]
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Analytics Screen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Number of Agreements'    => 'metrics.num',
                'Agreements Today' => 'metrics.numToday',
                'Agreements This Month' => 'metrics.numThisMonth',
                'Agreements This Year' => 'metrics.numThisYear',
            ]),

            Layout::columns([
                ChartPieExample::make('charts', 'BreakDown of Agreements By Province')
                    ->description('Break down agreements into different provinces.'),

            ]),

        ];
    }
}
