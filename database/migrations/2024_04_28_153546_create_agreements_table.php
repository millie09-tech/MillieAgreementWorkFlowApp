<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('CustomerFirstName')->nullable();
            $table->string('CustomerLastName')->nullable();
            $table->string('CustomerEmail')->nullable();
            $table->string('CustomerPhone')->nullable();
            $table->string('CompanyName')->nullable();
            $table->text('CompanyDescription')->nullable();
            $table->string('Logo')->nullable();
            $table->string('Address')->nullable();
            $table->string('City')->nullable();
            $table->string('Province')->nullable();
            $table->string('PostalCode')->nullable();
            $table->string('WebsiteHeaderName')->nullable();
            $table->string('WebsiteDomain')->nullable();
            $table->string('WebsiteHeaderColor')->nullable();
            $table->string('WebsiteFooterColor')->nullable();
            $table->boolean('WebsiteContactUsPage')->default(1)->nullable();
            $table->boolean('WebsiteMeetTheTeamPage')->default(1)->nullable();
            $table->boolean('WebsiteProductsPage')->default(1)->nullable();
            $table->string('PaymentMethod')->nullable();
            $table->string('CardNumber')->nullable();
            $table->string('CVV')->nullable();
            $table->string('Expiry')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
