<?php
namespace Tests\Helper;

use Api\User\Model\User;
use Mockery;

class UserTestHelper {
    public static function getWebUser(User $user)
    {
        $mockUser = Mockery::mock($user)->makePartial()->shouldReceive('hasApiTokens')->andReturnNull()->getMock();
        return $mockUser;
    }
}