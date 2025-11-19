<?php 
namespace Api\Like\Repository;
use Api\Like\Model\Like;
use Api\Like\Model\LikeDto;

 class LikeRepository implements ILikeRepository{
    public function create(LikeDto $data): Like {
        return Like::create($data->toArray());
    }
 }