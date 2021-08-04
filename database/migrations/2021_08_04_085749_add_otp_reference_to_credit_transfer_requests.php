<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpReferenceToCreditTransferRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_transfer_requests', function (Blueprint $table) {
            $table->string('otp_id')->nullable()->after('status');
            $table->string('otp_secret')->nullable()->after('otp_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_transfer_requests', function (Blueprint $table) {
            $table->dropColumn('otp_id');
            $table->dropColumn('otp_secret');
        });
    }
}
