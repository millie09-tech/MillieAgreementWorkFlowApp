<?php

namespace App\Models;

use App\Orchid\Filters\EmailFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;


class Agreement extends Model
{
    use  AsSource, Attachable, Filterable;

    /**
     * @var array
     */


    protected $fillable = [
        'CustomerFirstName',
        'CustomerLastName',
        'CustomerEmail',
        'CustomerPhone',
        'CompanyName',
        'CompanyDescription',
        'Logo',
        'Address',
        'City',
        'Province',
        'PostalCode',
        'WebsiteHeaderName',
        'WebsiteDomain',
        'WebsiteHeaderColor',
        'WebsiteFooterColor',
        'WebsiteContactUsPage',
        'WebsiteMeetTheTeamPage',
        'WebsiteProductsPage',
        'PaymentMethod',
        'CardNumber',
        'CVV',
        'Expiry',

    ];
}
