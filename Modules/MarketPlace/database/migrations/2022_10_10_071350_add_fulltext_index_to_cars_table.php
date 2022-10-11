<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\MarketPlace\Models\Car;

class AddFulltextIndexToCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE ".Car::TABLE_NAME." ADD FULLTEXT search_fulltext(title, description)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Car::TABLE_NAME, function (Blueprint $table) {
            $table->dropIndex('search_fulltext');
        });
    }
}
