<?php

namespace App\Models;

use App\Models\SocialLogin;
use App\Models\Traits\HasDates;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasDates;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'socialLogins',
    ];

    /**
     * Get the profile photo URL attribute.
     */
    public function getPhotoUrlAttribute(): string
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }

    public function socialLogins(): HasMany
    {
        return $this->hasMany(SocialLogin::class, 'user_id', 'id');
    }

    /**
     * Check if the user has SocialLogin for the given provider.
     *
     * @param SocialLoginProvider $provider
     */
    public function hasLoginWithProvider($provider): bool
    {
        return $this->socialLogins->where('social_login_provider_id', $provider->id)->first() !== null;
    }

    /**
     * Get the users SocialLogin for the given provider.
     *
     * @param SocialLoginProvider $provider
     */
    public function loginWithProvider($provider): SocialLogin
    {
        return $this->socialLogins->where('social_login_provider_id', $provider->id)->first();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Save profile picture with the given UploadedFile.
     *
     * @param  UploadedFile $file
     * @return string
     */
    public function saveProfilePicture($file)
    {
        $path = $this->uploadProfilePicture($file);

        $this->update([
            'profile_picture' => $path,
        ]);

        return $path;
    }

    /**
     * Upload or replace profile picture with the given UploadedFile.
     *
     * @param  UploadedFile $file
     * @return string
     */
    public function uploadProfilePicture($file)
    {
        if ($this->hasProfilePicture()) {
            $this->deleteProfilePicture();
        }

        $path = $file->storePublicly('uploads/profile-pictures', 'public');

        $this->profile_picture = $path;

        return $path;
    }

    /**
     * Delete the current profile picture.
     *
     * @return void
     */
    public function deleteProfilePicture()
    {
        Storage::disk('public')->delete($this->profile_picture);

        $this->update([
            'profile_picture' => null,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profilePicture()
    {
        return $this->hasOne(ProfilePicture::class, 'user_id', 'id')->where('active', true);
    }

    /**
     * Get the users profile picture by prioritizing
     * the uploaded image and then falling back to gravatar.
     *
     * @return string
     */
    public function getProfilePicture($size = 150)
    {
        if ($this->hasProfilePicture()) {
            return app(CdnImage::class)->url($this->profile_picture, [
                // 'w' => $size,
                // 'h' => $size,
            ]);
        }

        if ($this->uses_gravatar) {
            return Gravatar::src($this->email, $size);
        }

        return Gravatar::src('0000000000', $size);
    }

    public function hasProfilePicture()
    {
        return $this->profile_picture != null;
    }

    public function hasPassword()
    {
        return $this->password != '';
    }
}
