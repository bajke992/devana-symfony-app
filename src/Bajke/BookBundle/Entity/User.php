<?php

namespace Bajke\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\EquatableInterface;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends OAuthUser implements EquatableInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255, unique=true, nullable=true)
     */
    private $googleId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $realname;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @var mixed
     *
     * @ORM\OneToMany(targetEntity="Book", mappedBy="owner")
     */
    private $books;

    public function __construct(){
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getBooks() {
        return $this->books;
    }

    /**
     * @param mixed $books
     */
    public function setBooks($books) {
        $this->books = $books;
    }

    /**
     * @return string
     */
    public function getGoogleId() {
        return $this->googleId;
    }

    /**
     * @param string $googleId
     */
    public function setGoogleId($googleId) {
        $this->googleId = $googleId;
    }

    /**
     * @return string
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * @param string $realname
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function getRoles() {
        return array('USER_ROLE');
    }

    public function eraseCredentials() {
    }

    public function equals(UserInterface $user)
    {
        return parent::equals($user); // TODO: Change the autogenerated stub
    }

    public function serialize() {
        return serialize(array(
            $this->id
        ));
    }

    public function unserialize($serialized) {
        list (
            $this->id,
            ) = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user) {
        if((int)$this->getId() == $user->getId()){
            return true;
        }
        return false;
    }
}

