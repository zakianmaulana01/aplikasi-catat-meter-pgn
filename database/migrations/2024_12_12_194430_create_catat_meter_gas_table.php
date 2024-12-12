<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatMeterGasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catat_meter_gas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_pelanggan', 15)->nullable();
            $table->string('foto', 50)->nullable();
            $table->string('angka_stand', 50);
            $table->string('jam_catat', 10);
            $table->date('tanggal_pencatatan')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->timestamps();
            $table->string('updated_by', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catat_meter_gas');
    }
}
