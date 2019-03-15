<?php
/**
 * Created by PhpStorm.
 * User: kartyshova
 * Date: 11.03.19
 * Time: 12:22
 */

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;

class OAuthProvider extends OAuthUserProvider
{
    /** @var UserRepository*/
    public $userRepository;

    /**
     * @required
     */
    public function setUserRepository(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userRepository->findOneByEmail($response->getEmail());
        $data = $response->getData();
        $facebookID = $data['id'];

        if (null === $user) {
            $user = $this->userRepository->findOneByFacebookID($facebookID);
        }

        if (null === $user) {
            $name = $data['name'];
            $login = $data['first_name'] . random_int(100, 999);
            $password = (string)random_int(100000, 999999);

            $user = new User();

            $user->setLogin($login);
            $user->setName($name);
            $user->setPassword($password);
            $user->setFacebookId($facebookID);
            $response->getOAuthToken();
            if (isset($data['email'])) {
                $email = $data['email'];
                $user->setEmail($email);
            }

            $this->userRepository->save($user);

            return $user;
        }
        return $user;
    }
}