<?php

namespace App\Models;

use App\Models\Relations\BelongsToUser;

/**
 * Class SocialLogin
 * @package App\Models
 */
class SocialLogin extends BaseModel
{
    use BelongsToUser;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'refresh_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'provider_user_data' => 'json',
        'provider_is_public' => 'boolean',
    ];

    /**
     * Get the value of `_id` column for the given provider.
     *
     * @param  SocialLoginProvider $provider
     */
    public function getProviderId($provider): string
    {
        return $this->getProviderColumn('id', $provider);
    }

    /**
     * Get the value of `_data` column for the given provider.
     *
     * @param  SocialLoginProvider $provider
     */
    public function getProviderData($provider): array
    {
        return $this->getProviderColumn('data', $provider);
    }

    /**
     * Get the value of `_is_public` column for the given provider.
     *
     * @param  SocialLoginProvider $provider
     */
    public function getProviderIsPublic($provider): bool
    {
        return $this->getProviderColumn('is_public', $provider);
    }

    /**
     * Get provider column value for a given suffix.
     *
     * @param  string               $columnSuffix
     * @param  SocialLoginProvider  $provider
     * @return mixed
     */
    public function getProviderColumn($columnSuffix, $provider)
    {
        return $this->{$provider->getColumnName($columnSuffix)};
    }

    /**
     * Determine if the user has connected a given provider.
     *
     * @param  SocialLoginProvider $provider
     */
    public function hasProvider(SocialLoginProvider $provider): bool
    {
        return $this->getProviderID($provider) !== null;
    }

    /**
     * Get the username of the user on a given provider.
     *
     * @param  SocialLoginProvider $provider
     */
    public function getProviderUsername(SocialLoginProvider $provider): string
    {
        switch ($provider->provider) {
            case 'facebook':
            case 'linkedin':
                return $this->getProviderData($provider)['name'];
                break;

            default:
                return $this->getProviderData($provider)['username'];
                break;
        }
    }

    /**
     * Toggle the public/hidden state of a users provider data.
     *
     * @param  SocialLoginProvider $provider
     */
    public function toggleProviderPublic(SocialLoginProvider $provider): int
    {
        return $this->update([
            $provider->getColumnName('is_public') => !$this->getProviderIsPublic($provider),
        ]);
    }
}
