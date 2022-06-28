<?php

namespace App\Models\customer;
use App\Models\ModelTrait;
use App\Models\customer\Traits\CustomerAttribute;
use App\Models\customer\Traits\CustomerRelationship;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Access\User\Traits\CustomerSendPasswordReset;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class CustomerLogin extends Authenticatable
{
    use ModelTrait,
        CustomerAttribute,
        CustomerSendPasswordReset,
        Notifiable,
    	CustomerRelationship {
            // CustomerAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/5.4/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'customers';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * Dates
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Constructor of Model
     * @param array $attributes
     */
    protected $hidden = ['password',  'remember_token'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

        public function findByEmail($email)
    {
        return $this->query()->where('email', $email)->first();
    }

        public function findByPasswordResetToken($token)
    {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return $this->findByEmail($row->email);
            }
        }

        return false;
    }

         public function getPictureAttribute()
    {
        if (!$this->attributes['picture']) {
            return 'example.png';
        }

        return $this->attributes['picture'];
    }
    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }


}
