<?php

use App\Models\Tour;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->uuid('uuid')->unique();
            $table->string('title_al')->nullable();
            $table->string('title_en')->nullable();
            $table->text('teaser_al')->nullable();
            $table->text('teaser_en')->nullable();
            $table->text('author_al')->nullable();
            $table->text('author_en')->nullable();
            $table->foreignIdFor(Tour::class);
            $table->string('lng')->default(0);
            $table->string('lat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
};
