<?php

namespace Gtd\Extension\User\Providers;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Log;

class AuthUserServiceProvider extends EloquentUserProvider
{

    public function __construct(HasherContract $hasher, $model)
    {
        $this->model = $model;
        $this->hasher = $hasher;
    }
    
    /**
    * Validate a user against the given credentials.
    *
    * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
    * @param  array  $credentials
    * @return bool
    */
    
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password']; // will depend on the name of the input on the login form
        $hashedValue = $user->getAuthPassword();
        
        $salt = $user->salt;
        $password_link = '#x-client-x#';
        $plain = $plain.$password_link.$salt;
        
        /**
        if ($this->hasher->needsRehash($hashedValue) && $hashedValue === md5($plain)) {
            $user->passwordnew_enc = bcrypt($plain);
            $user->save();
        }
        */
        
        return $this->hasher->check($plain, $user->getAuthPassword());
    }
    
    public function retrieveById($identifier){
        
        $model = $this->createModel();
        
        $user = $model->newQuery()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();
        return $user;
    }
    
}