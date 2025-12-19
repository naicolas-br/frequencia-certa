<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('has_seen_intro')->default(false); // Viu a tela de boas-vindas?
        $table->boolean('has_completed_tour')->default(false); // Terminou o tour no dashboard?
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['has_seen_intro', 'has_completed_tour']);
    });
}
};
