<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\SocialLogin;
use App\Models\OauthProvider;
use App\Http\Controllers\Controller;
use App\Exceptions\EmailTakenException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Collection of enabled OauthProviders.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $enabledProviders;

    public function __construct()
    {
        $enabledProviders = OauthProvider::enabled()->get();

        foreach ($enabledProviders as $provider) {
            config([
                "services.{$provider->name}" => [
                    'client_id' => $provider->client_id,
                    'client_secret' => $provider->client_secret,
                    'redirect' => route('oauth.callback', $provider->name),
                ],
            ]);
        }
    }

    /**
     * Get the redirect uri for the provider.
     *
     * @param string $provider
     */
    public function getRedirectUri($provider): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param  string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $user = $this->findOrCreateUser($provider, $user);

        auth()->guard()->setToken(
            $token = auth()->guard()->login($user)
        );

        return view('oauth/callback', [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard()->getPayload()->get('exp') - time(),
        ]);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\User|false
     */
    protected function findOrCreateUser($provider, $sUser)
    {
        $provider = OauthProvider::where('name', $provider)->first();

        $socialLogin = $provider->socialLogins()->where('provider_user_id', $sUser->getId())->first();

        if ($socialLogin) {
            $socialLogin->update([
                'access_token' => $sUser->token,
                'refresh_token' => $sUser->refreshToken,
            ]);

            return $socialLogin->user;
        }

        if (User::where('email', $sUser->getEmail())->exists()) {
            throw new EmailTakenException;
        }

        return $this->createUser($provider, $sUser);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\User
     */
    protected function createUser($provider, $sUser)
    {
        $user = User::create([
            'name' => $sUser->getName(),
            'email' => $sUser->getEmail(),
        ]);

        $sUserData = [
            'id' => $sUser->getId(),
            'name' => $sUser->getName(),
            'username' => $sUser->getNickname(),
            'email' => $sUser->getEmail(),
            'avatar' => $sUser->getAvatar(),
        ];

        $user->socialLogins()->create([
            'oauth_provider_id' => $provider->id,
            'provider_user_id' => $sUser->getId(),
            'provider_user_data' => $sUserData,
            'provider_is_public' => true,
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }

    // public function verifyProvider($provider)
    // {
    //     $provider = SocialLoginProvider::where('provider', $provider)->first();

    //     if ($provider && !$provider->is_enabled) {
    //         throw new OAuthProvider;
    //     }
    // }
}
