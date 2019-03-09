<?php

use App\Models\OauthProvider;
use Illuminate\Database\Seeder;

class OauthProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultProvider = [
            'is_enabled' => false,
            'image' => null,
            'scopes' => [],
        ];

        $providers = [
            'github' => [
                'name' => 'github',
                'display_name' => 'GitHub',
                'is_enabled' => true,
                'link' => 'https://github.com/%username%',
                'icon' => 'github',
                'color' => 'github',
            ],
            'facebook' => [
                'name' => 'facebook',
                'display_name' => 'Facebook',
                'link' => 'https://fb.com/%username%',
                'icon' => 'facebook',
                'color' => 'facebook',
                'scopes' => ['user_friends', 'read_custom_friendlists'],
            ],
            'twitter' => [
                'name' => 'twitter',
                'display_name' => 'Twitter',
                'link' => 'https://twitter.com/%username%',
                'icon' => 'twitter',
                'color' => 'twitter',
            ],
            'google' => [
                'name' => 'google',
                'display_name' => 'Google+',
                'link' => null,
                'icon' => 'google',
                'color' => 'google',
            ],
            'twitch' => [
                'name' => 'twitch',
                'display_name' => 'Twitch',
                'link' => 'https://twitch.tv/%username%',
                'icon' => 'twitch',
                'color' => 'twitch',
            ],
            'battlenet' => [
                'name' => 'battlenet',
                'display_name' => 'Battle.net',
                'link' => null,
                'icon' => null,
                'image' => 'http://oi65.tinypic.com/2mfx2d1.jpg',
                'color' => 'battlenet',
            ],
            'linkedin' => [
                'name' => 'linkedin',
                'display_name' => 'LinkedIn',
                'link' => 'https://www.linkedin.com/in/%username%',
                'icon' => 'linkedin',
                'color' => 'linkedin',
            ],
            'instagram' => [
                'name' => 'instagram',
                'display_name' => 'Instagram',
                'link' => 'https://www.instagram.com/%username%',
                'icon' => 'instagram',
                'color' => 'instagram',
                'scopes' => ['public_content', 'follower_list', 'likes', 'comments', 'relationships'],
            ],
        ];

        $providers = collect($providers);

        $providers->transform(function ($value, $key) use ($defaultProvider) {
            $value = array_merge($defaultProvider, $value);

            $value['scopes'] = json_encode($value['scopes']);

            return $value;
        });

        OauthProvider::insert($providers->toArray());
    }
}
