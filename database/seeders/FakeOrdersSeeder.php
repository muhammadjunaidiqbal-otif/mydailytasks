<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Orders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FakeOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingOrders = Orders::with('user')
                            ->whereNotNull('user_id')
                            ->whereNotNull('billing_id')
                            ->orderBy('id', 'asc')
                            ->get();
        foreach ($existingOrders as $originalOrder) {
            for ($i = 0; $i < 10; $i++) {

                $randomDaysAgo = rand(0, 29);
                $randomSeconds = rand(0, 86400);
                $timestamp = Carbon::now()->subDays($randomDaysAgo)->startOfDay()->addSeconds($randomSeconds);

                Orders::create([
                    'user_id' => $originalOrder->user_id,
                    'billing_id' => $originalOrder->billing_id,
                    'cart' => $originalOrder->cart,
                    'total' => $originalOrder->total,
                    'discount' => $originalOrder->discount,
                    'status' => $originalOrder->status,
                    'payment_status' => $originalOrder->payment_status,
                    'stripe_session_id' => $originalOrder->stripe_session_id,
                    'stripe_response' => $originalOrder->stripe_response,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }
        }
    }
}
