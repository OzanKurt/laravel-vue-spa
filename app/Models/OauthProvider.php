<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OauthProvider
 * @package App\Models
 */
class OauthProvider extends BaseModel
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'name', 'display_name', 'icon', 'image', 'color'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scopes' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'has_image',
    ];

    /**
     * Get the users profile url of the provider.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function linkForUser(User $user)
    {
        switch ($this->provider) {
            case 'facebook':
                $username = $user->socialLogin->getProviderId($this);
                break;
            case 'linkedin':
                return $user->socialLogin->getProviderData($this)['username'];
                break;

            default:
                $username = $user->socialLogin->getProviderUsername($this);
                break;
        }

        return $this->linkForUsername($username);
    }

    /**
     * Replace a username to providers profile link.
     *
     * @param $username
     *
     * @return mixed
     */
    public function linkForUsername($username)
    {
        return str_replace('%username%', $username, $this->link);
    }

    /**
     * Check if the provider uses image rather than an icon.
     *
     * @return bool
     */
    public function hasImage()
    {
        return !is_null($this->image);
    }

    /**
     * Accessor for hasImage attribute.
     *
     * @return bool
     */
    public function getHasImageAttribute()
    {
        return $this->hasImage();
    }

    /**
     * Filter providers with their `is_enabled` field.
     *
     * @param $query
     * @param bool $enabled
     */
    public function scopeEnabled($query, $enabled = true): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_enabled', $enabled);
    }

    /**
     * Filter to not enabled providers.
     *
     * @param $query
     */
    public function scopeNotEnabled($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->enabled(false);
    }

    public function socialLogins(): HasMany
    {
        return $this->hasMany(SocialLogin::class, 'oauth_provider_id', 'id');
    }
}
