<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\AppointmentStatusType;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); // owner
            $table->unsignedInteger('client_id'); // registered user
            $table->string('walkin_name')->nullable(); // fullname
            $table->string('walkin_contact')->nullable(); // phone no.
            $table->timestamp('appointment_created');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('price_expected');
            $table->decimal('price_full')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('price_final')->nullable();
            $table->tinyInteger('status')->unsigned()->default(AppointmentStatusType::Pending);
            $table->boolean('canceled')->default(false); // from client side
            $table->string('cancellation_reason')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
