<?php
namespace Modules\Seller\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Account\Models\User;
use Modules\Seller\Models\Seller;

class SellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Seller\Models\Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        $user = User::all()->random(1);

        return [
            'name' => $name,
            'profile_type_id' => 1,
            'user_id' => $user->id,
            'location' => $this->faker->streetAddress(),
            'logo' => null,
            'status' => Seller::STATUS_ACTIVE,
            'slug' => \illuminate\Support\Str::slug($name)
        ];
    }
}

