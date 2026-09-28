<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SellerBuyer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class FraudDetectionService
{
    public function score(array $payload): array
    {
        $score = 0;
        $reasons = [];

        $userId = $payload['user_id'] ?? null;
        $amount = (float) ($payload['amount'] ?? 0);
        $address = trim((string) ($payload['address'] ?? ''));
        $state = trim((string) ($payload['state'] ?? ''));
        $postCode = trim((string) ($payload['post_code'] ?? ''));
        $ip = $payload['buyer_ip'] ?? $payload['ip'] ?? null;
        $paymentGateway = strtolower(trim((string) ($payload['payment_gateway'] ?? '')));
        $buyerEmail = strtolower(trim((string) ($payload['buyer_email'] ?? $payload['email'] ?? '')));

        $detector = new SuspiciousInputDetector();
        $inputResult = $detector->detect([
            'name' => $payload['name'] ?? '',
            'address' => $address,
            'state' => $state,
            'post_code' => $postCode,
        ]);

        if ($inputResult['is_suspicious']) {
            $score += 30;
            $reasons = array_merge($reasons, $inputResult['reasons']);
        }

        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                $recentOrders = Order::where('user_id', $userId)
                    ->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->count();

                if ($recentOrders === 0) {
                    $score += 15;
                    $reasons[] = 'নতুন ব্যবহারকারী, তাই অর্ডারটি উচ্চ ঝুঁকি হিসেবে চিহ্নিত হয়েছে।';
                }

                if ($recentOrders > 0 && $recentOrders < 3) {
                    $score += 5;
                    $reasons[] = 'ব্যবহারকারীর অল্প ইতিহাস থাকায় অর্ডারটি কিছুটা সন্দেহজনক।';
                }
            }
        }

        if ($amount >= 50000) {
            $score += 20;
            $reasons[] = 'অতিরিক্ত অর্ডার মূল্য উচ্চ হওয়ায় ঝুঁকি বাড়ছে।';
        }

        if ($ip) {
            $sameIpOrders = 0;
            if (Schema::hasColumn('orders', 'ip_address')) {
                $sameIpOrders = Order::where('created_at', '>=', Carbon::now()->subHours(6))
                    ->where('ip_address', $ip)
                    ->count();
            }

            if ($sameIpOrders > 1) {
                $score += 20;
                $reasons[] = 'একই IP থেকে একাধিক অর্ডার এসেছে।';
            }

            $sameIpSellerBuyers = 0;
            if (Schema::hasColumn('seller_buyers', 'buyer_ip')) {
                $sameIpSellerBuyers = SellerBuyer::where('buyer_ip', $ip)
                    ->where('created_at', '>=', Carbon::now()->subHours(6))
                    ->count();
            }

            if ($sameIpSellerBuyers >= 3) {
                $score += 20;
                $reasons[] = 'একই IP থেকে একাধিক ক্রয় ধরার ফলে ঝুঁকি বেড়েছে।';
            } elseif ($sameIpSellerBuyers === 2) {
                $score += 10;
                $reasons[] = 'একই IP থেকে আরেকটি ক্রয় হয়েছে, তাই সতর্ক থাকা জরুরি।';
            }
        }

        if ($buyerEmail) {
            $sameEmailDifferentIp = 0;
            if (Schema::hasColumn('seller_buyers', 'buyer_ip')) {
                $sameEmailDifferentIp = SellerBuyer::whereRaw('LOWER(buyer_email) = ?', [$buyerEmail])
                    ->when($ip, fn ($query) => $query->where('buyer_ip', '<>', $ip))
                    ->where('created_at', '>=', Carbon::now()->subDay())
                    ->count();
            }

            if ($sameEmailDifferentIp > 1) {
                $score += 20;
                $reasons[] = 'একই ইমেল বিভিন্ন IP থেকে ব্যবহার করা হয়েছে, যা অস্বাভাবিক।';
            }
        }

        if ($paymentGateway) {
            if (in_array($paymentGateway, ['bkash', 'bank', 'handcash'], true)) {
                $score += 5;
                $reasons[] = 'এই পেমেন্ট পদ্ধতি সামগ্রিক ঝুঁকি বৃদ্ধি করতে পারে।';
            }
        }

        $userCartCount = $userId ? Cart::where('user_id', $userId)->count() : 0;
        if ($userCartCount > 8) {
            $score += 10;
            $reasons[] = 'কার্টে অনেক পণ্য থাকায় অস্বাভাবিক আচরণ হতে পারে।';
        }

        $riskLevel = 'low';
        if ($score >= 60) {
            $riskLevel = 'high';
        } elseif ($score >= 30) {
            $riskLevel = 'medium';
        }

        return [
            'score' => $score,
            'risk_level' => $riskLevel,
            'is_suspicious' => $score >= 30,
            'reasons' => array_unique($reasons),
        ];
    }
}
