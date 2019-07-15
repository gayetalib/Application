<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *   fields="Matricule",
 *   message="Ce matricule existe déjà. Veuillez entrer un autre"
 * )
 * @UniqueEntity(
 *   fields="username",
 *   message="Username déjà utilisé. Veuillez entrer un autre"
 * )
 * @UniqueEntity(
 *   fields="Email",
 *   message="Email déjà utilisé. Veuillez entrer un autre"
 * )
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getRoles()
    {
        return $this->roles;
        // return array('ROLE_USER');
    }

    public function getRolesCollection()
    {
        return $this->roles;
    }
    
// /**
//  * @ORM\Column(type="json")
//  */
// private $roles;

// public function getRoles(): array
// {
//    return  $roles = $this->roles;
//     // guarantee every user at least has ROLE_USER
//     // $roles = ['ROLE_USER'];

    
// }

    // /**
    //  * @ORM\Column(type="json")
    //  */
    // private $roles;
    
    //     /**
    //  * Returns the roles granted to the user.
    //  * 
    //  * @return Role[] The user roles
    //  */
    // public function getRoles()
    // {
    //         return $this->roles;   

    //         // return array('ROLE_USER'); regle le probleme
    // }
    // public function getRoles()
    // {
    //     return $this->roles;
    // }
     

    //     public function getRoles()
    // {
    //     return array('ROLE_USER');
    // }

        // public function getRoles()
        // {
        //     $roles = $this->roles;
        //      var_dump($roles);
        //     if ($roles != NULL) {
        //         return explode(" ",$roles);
        //     }else {
        //        return $this->roles;
        //     }
        // }
    

        //     public function __construct()
        //   {
        //    $this->roles=array('searcher' ,'annoucer');
        //  }
        // public function getRoles(): array
        // {
        //  $roles = $this->roles;
        // // guarantee every user at least has ROLE_USER
        //  return $roles= [
        //     'ROLE_USER'
        // ];

        // //    return array_unique($roles);
        // }

        // public function __construct()
        // {
        //     $this->roles = [];
        // }
   
        // public function getRoles(): array
        // {

           
        //     return ['ROLE_USER'];  //marche pour la connexion
            // return $this->roles;  //marche pour ajouter User
           
        // }

        // public function getRoles()
        // {
               
               
        //         return ['ROLE_ADMIN'];
        // }

        public function setRoles($roles): self
        {
            $this->roles = $roles;

            return $this;
        }

    //Ajot donctionne avec json_array de setRoles    

        /**
         * Returns the password used to authenticate the user.
         *
         * This should be the encoded password. On authentication, a plain-text
         * password will be salted, encoded, and then compared to this value.
         *
         * @return string The password
         */
        // public function getPassword();
    
        /**
         * Returns the salt that was originally used to encode the password.
         *
         * This can return null if the password was not encoded using a salt.
         *
         * @return string|null The salt
         */
        public function getSalt(){}
    
        /**
         * Returns the username used to authenticate the user.
         *
         * @return string The username
         */
        // public function getUsername();
    
        /**
         * Removes sensitive data from the user.
         *
         * This is important if, at any given point, sensitive information like
         * the plain-text password is stored on this object.
         */
        public function eraseCredentials(){}

        /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->Nom,
            $this->Prenom,
            $this->Matricule,
            $this->Email,
            $this->username,
            $this->password,
            $this->roles,
            // see section on salt below
            // $this->salt,
        ]);
    }
    
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->Nom,
            $this->Prenom,
            $this->Matricule,
            $this->Email,
            $this->username,
            $this->password,
            $this->roles,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            $role->removeUser($this);
        }

        return $this;
    }

}