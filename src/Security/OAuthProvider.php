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
use App\Security\MyOAuthUser;
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
        //$email = $response->getEmail();

        //$source = $response->getResourceOwner()->getName();

//        $user = new User();
//
//        $user->setLogin('login');
//        $user->setName('name');
//        $user->setAddress('kyiv');
//        $user->setPhoneNumber('12345');
//        $user->setPassword('123123');
//        $user->setCompanyTitle('company');
//        $user->setEmail('emailll@gmail.com');
//
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->persist($user);
//        $entityManager->flush();
//        return $user;


        $data = $response->getData();
//        dd($data);
//        $id = $data['id'];
        $name = $data['name'];
        $token = $response->getAccessToken();
        $oauth_token = $response->getOAuthToken();
        $user = null;
        if (isset($user['email'])) {
            $email = $data['email'];
            $user = $this->userRepository->findOneByEmail($email);
        }

//        $user = $this->getDoctrine()
//            ->getRepository(User::class)
//            ->findOneBy([
//                $this->getProperty($response) => $email,
//            ]);

        //if (null === $user) {
            //throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
            // create new user here
            //$user = $this->userManager->createUser();
        // ......
        // set user name, email ...
        // ......
        //$this->userManager->updateUser($user);
            $user = new MyOAuthUser();
            if (isset($email)) {
                $user->email = $email;
            }
            $user->name = $name;
            $user->token = $token;
            $user->oauth_token = $oauth_token;
            //$user['facebookId'] = $id;
//            $user = new User();
//            $user->setName($name);
//            $user->setEmail($email);
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
            return $user;
        //}
        //$user = parent::loadUserByUsername($name);
        //return parent::loadUserByOAuthUserResponse($response);
       // $user = new MyOAuthUser();
        //return $user;
    }

    public function loadUserByOAuthUserResponse2(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setter_id = $setter . 'Id';
            $setter_token = $setter . 'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($username);
            $user->setEmail($username);
            $user->setPassword($username);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);
            return $user;
        }

        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }

    public function loadUserByOAuthUserResponse3(UserResponseInterface $response): User
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('App:User');

        $source = $response->getResourceOwner()->getName();
        $email = null;
        $data = [];
        $newUser = false;

        // Set email and socialUser.
        if ($source === 'twitter') {
            $data = $response->getData();
            $email = $data['email'];
        }

        // Check if this user already exists in our app.
        $user = $repo->findOneBy(['email' => $email]);

        if ($user === null) {
            $newUser = true;
            $user = new User();
            $user->setPassword($this->strand(32));
        }

        // Set session and user data based on source.
        if ($source === 'twitter') {
            $name = $data['name'];
            if ($newUser) {
                $user->setNickName($name);
                $user->setEmail($email);
                $em->persist($user);
                $em->flush();
            }
        }

        return $user;
    }
}