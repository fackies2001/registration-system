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
        Schema::table('users', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['full_name', 'country']);

            // Add new personal fields
            $table->string('salutation')->after('id');
            $table->string('first_name')->after('salutation');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->after('middle_name');
            $table->string('suffix')->nullable()->after('last_name');
            $table->string('sex')->after('suffix');
            $table->string('nationality')->after('sex');
            $table->string('place_of_birth')->after('nationality');
            $table->date('date_of_birth')->after('place_of_birth');

            // Add new professional fields
            $table->string('participant_type')->after('designation');
            $table->string('ministry_agency')->after('participant_type');
            $table->string('office_subunit')->after('ministry_agency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert new fields
            $table->dropColumn([
                'salutation', 'first_name', 'middle_name', 'last_name', 'suffix',
                'sex', 'nationality', 'place_of_birth', 'date_of_birth',
                'participant_type', 'ministry_agency', 'office_subunit'
            ]);

            // Add back old columns
            $table->string('full_name')->after('id');
            $table->string('country')->after('designation');
        });
    }
};
