<?php
namespace App\GraphQL\Mutation;

use App\User;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteUser',
    ];
    public function type()
    {
        return GraphQL::type('User');
    }
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }
    public function resolve($root, $args)
    {
        if ($user = User::findOrFail($args['id'])) {
            $user->delete();
            return $user;
        }
        return null;
    }
}
