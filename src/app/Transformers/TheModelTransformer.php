<?php

namespace App\Transformers;

use App\TheModel;
use League\Fractal\TransformerAbstract;

class TheModelTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * List of resources to include by default
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * A Fractal transformer.
     *
     * @param \App\TheModel $theModel
     * @return array
     */
    public function transform(TheModel $theModel)
    {
        return [
            'id' => $theModel->id
        ];
    }

    /**
     * Include Profile
     *
     * @param \App\TheModel $theModel
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeRelationship(TheModel $theModel)
    {
        if ($theModel->relationship) {
            return $this->item($theModel->relationship, new RelationshipTransformer);
        }
    }
}
