<?php
namespace App\GraphQL\Query;

use App\Tweet;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class TweetsQuery extends Query
{
    protected $attributes = [
        'name' => 'tweets',
    ];
    public function type()
    {
        return Type::listOf(GraphQL::type('Tweet'));
    }
    public function args()
    {
        return [
            'id'    => ['name' => 'id', 'type' => Type::int()],
            'first' => ['name' => 'first', 'type' => Type::int()],
        ];
    }
    public function resolve($root, $args)
    {
        $tweet = new Tweet;
        // check for limit
        if (isset($args['first'])) {
            $tweet = $tweet->limit($args['first'])->latest('id');
        }
        if (isset($args['id'])) {
            $tweet = $tweet->where('id', $args['id']);
        }
        if (isset($args['email'])) {
            $tweet = $tweet->where('email', $args['email']);
        }
        return $tweet->get();
    }
}
