<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $privacyPolicy = [
                [
                    'description' => 'nittomartomart.com এ আপনাকে স্বাগতম। banggomart.com হলো Webcoder-IT Institute এর একটি অঙ্গপ্রতিষ্ঠান এবং এই ওয়েবসাইটটির মালিক ও পরিচালক Webcoder-IT Institute নিজেই। আমরা আমাদের ওয়েবসাইট ব্যবহারকারীদের গোপনীয়তা রক্ষায় সদা তৎপর এবং তাই আপনাদের তথ্যের গোপনীয়তা রক্ষায় আমরা একটি গোপনীয়তা নীতিমালায় প্রকাশ করছি যেখানে আমরা কিভাবে আপনাদের গোপনীয়তা রক্ষা করবো তার বিস্তারিত ভাবে বর্ণণা করা হয়েছে। এই নীতিমালায় আমরা কিভাবে আপনার তথ্য সংগ্রহ ও ব্যবহার করি, কিভাবে আমরা আপনার ব্যক্তিগত তথ্যের সুরক্ষা নিশ্চিত করি তারও বিস্তারিত বর্ণনা রয়েছ। আমরা শুধুমাত্র আমাদের ওয়েবসাইট ব্যবহার করে অর্ডার করতে যে তথ্যগুলো প্রয়োজন সেই তথ্যগুলোই সংগ্রহ করে থাকি। বিস্তারিত জানতে অনুগ্রহ করে সময় নিয়ে গোপনীয়তা নীতিমালাটি পড়ুন।',

                ],
            ];
            PrivacyPolicy::insert($privacyPolicy);
        }
    }
}
