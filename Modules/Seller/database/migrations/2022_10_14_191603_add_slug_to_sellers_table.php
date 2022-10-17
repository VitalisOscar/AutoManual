<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Seller\Models\Seller;

class AddSlugToSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Seller::TABLE_NAME, function (Blueprint $table) {
            $table->string('slug')->after('status')->unique('unique_slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Seller::TABLE_NAME, function (Blueprint $table) {
            $table->dropIndex('unique_slug');
            $table->dropColumn('slug');
        });
    }
}
