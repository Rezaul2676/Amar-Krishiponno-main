<?php

namespace App\Services;

class SuspiciousInputDetector
{
    public function detect(array $input): array
    {
        $reasons = [];
        $name = trim((string) ($input['name'] ?? ''));
        $address = trim((string) ($input['address'] ?? ''));
        $state = trim((string) ($input['state'] ?? ''));
        $postCode = trim((string) ($input['post_code'] ?? ''));

        if ($name !== '' && strlen($name) < 3) {
            $reasons[] = 'নাম খুব ছোট লেখা হয়েছে। পূর্ণ ও স্পষ্ট নাম লিখুন।';
        }

        if ($name !== '' && preg_match('/\d/', $name)) {
            $reasons[] = 'নামে সংখ্যা ব্যবহার করা হয়েছে। নামটি পরিষ্কার English বা Bangla অক্ষর দিয়ে লিখুন।';
        }

        if ($name !== '' && !preg_match('/^[\pL\pM\s\.\-\']+$/u', $name)) {
            $reasons[] = 'নামে অযাচিত অক্ষর ব্যবহার করা হয়েছে। নামটি শুধুমাত্র অক্ষর, স্পেস, ডট বা হাইফেন দিয়ে লিখুন।';
        }

        if ($address !== '' && preg_match('/\b(test|asdf|abc|unknown|sample|dummy|n\/a|na)\b/i', $address)) {
            $reasons[] = 'ঠিকানায় অস্বাভাবিক বা placeholder শব্দ ব্যবহার করা হয়েছে।';
        }

        if ($address !== '' && preg_match('/([A-Za-z0-9])\1{3,}/', $address)) {
            $reasons[] = 'ঠিকানায় একই অক্ষর বারবার পুনরাবৃত্তি হয়েছে। অনুগ্রহ করে সম্পূর্ণ ও সঠিক ঠিকানা লিখুন।';
        }

        if ($address !== '' && !BangladeshLocationValidator::isValidAddress($address)) {
            $reasons[] = 'ঠিকানা সন্দেহজনক মনে হচ্ছে। একটি পূর্ণ, বাস্তব ও সঠিক ঠিকানা লিখুন।';
        }

        if ($state !== '' && preg_match('/[0-9!@#$%^&*_=+{}\[\]|\\:;<>?]/', $state)) {
            $reasons[] = 'স্টেটে অস্বাভাবিক অক্ষর ব্যবহার করা হয়েছে।';
        }

        if ($state !== '' && !BangladeshLocationValidator::isValidState($state)) {
            $reasons[] = 'স্টেট/জেলা/উপজেলার নামটি বৈধ নয়। বাংলাদেশি জেলা বা উপজেলা নাম লিখুন।';
        }

        if ($postCode !== '' && !preg_match('/^\d{4,6}$/', $postCode)) {
            $reasons[] = 'পোস্ট কোড সঠিক নয়। ৪ থেকে ৬ ডিজিটের পোস্ট কোড দিন।';
        }

        return [
            'is_suspicious' => !empty($reasons),
            'reasons' => $reasons,
        ];
    }
}
