<?php
namespace Api\Like\Repository;

use Api\Like\Model\Like;
use Api\Like\Model\LikeDto;

interface ILikeRepository {
    public function create(LikeDto $data): Like;
}