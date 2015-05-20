<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HmtSslCertificatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('system')->create('ssl_certificates', function(Blueprint $table)
        {
            $table->bigIncrements('id');
            // tenant owner
            $table->bigInteger('tenant_id')->unsigned();

            // certificate
            $table->string('certificate');
            // bundles
            $table->string('authority_bundle');

            // date when certificate becomes usable as read from certificate
            $table->timestamp('valid_from')->nullable();
            // date of expiry as read from certificate
            $table->timestamp('expires_at')->nullable();

            // timestaps
            $table->timestamps();
            $table->softDeletes();

            // relations
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');

            // index
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('system')->dropIfExists('ssl_certificates');
	}

}
