<?php
namespace App\GraphQL\Query;

use App\User;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'id'    => ['name' => 'id', 'type' => Type::int()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'first' => ['name' => 'first', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $user = new User;

        // check for limit
        if (isset($args['first'])) {
            $user = $user->limit($args['first'])->latest('id');
        }

        if (isset($args['id'])) {
            $user = $user->where('id', $args['id']);
        }

        if (isset($args['email'])) {
            $user = $user->where('email', $args['email']);
        }

        return $user->get();
    }
}
