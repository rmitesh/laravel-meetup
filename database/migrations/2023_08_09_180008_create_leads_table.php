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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('lead_number', 30);
            $table->string('full_name', 60);
            $table->string('email', 80)->nullable();
            $table->string('phone_number', 15);
            $table->integer('property_type')->unsigned();
            $table->string('location', 90);
            $table->decimal('budget', 10, 2);
            $table->integer('bedrooms')->unsigned();
            $table->integer('bathrooms')->unsigned();
            $table->text('additional_requirements')->nullable();
            $table->timestamps();
        });

        Schema::create('lead_property', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('property_id');

            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_lead');
        Schema::dropIfExists('leads');
    }
};
