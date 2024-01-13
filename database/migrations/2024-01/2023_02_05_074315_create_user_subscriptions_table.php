<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $prefix = DB::getTablePrefix();

        Schema::create(
            'membership_user_subscriptions',
            function (Blueprint $table) use ($prefix) {
                $table->bigIncrements('id');
                $table->uuid()->unique();
                $table->string('agreement_id', 100)->unique()
                    ->comment('Agreement of payment partner');
                $table->float('amount')->index();
                $table->dateTime('start_date')->index()->nullable();
                $table->dateTime('end_date')->index()->nullable();
                $table->unsignedBigInteger('method_id');
                $table->unsignedBigInteger('plan_id');
                $table->unsignedBigInteger('user_id')->unique();
                $table->timestamps();

                $table->foreign('method_id', "{$prefix}_user_subscription_payment_methods_foreign")
                    ->references('id')
                    ->on('subscription_payment_methods');
                $table->foreign('plan_id', "{$prefix}_user_subscription_plan_foreign")
                    ->references('id')
                    ->on('subscription_plans');
            }
        );

        Schema::create(
            'membership_user_subscription_metas',
            function (Blueprint $table) use ($prefix) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_subscription_id');
                $table->string('meta_key', 50)->index();
                $table->text('meta_value')->nullable();
                $table->unique(['user_subscription_id', 'meta_key'], "{$prefix}_user_subscription_meta_key_unique");

                $table->foreign('user_subscription_id', "{$prefix}_subscription_user_metas_foreign")
                    ->references('id')
                    ->on('membership_user_subscriptions')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_user_subscription_metas');
        Schema::dropIfExists('membership_user_subscriptions');
    }
};
