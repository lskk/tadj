<?php
namespace App\Libraries;

/**
 * SimpleLDAP
 *
 * An abstraction layer for LDAP server communication using PHP
 *
 * @author Klaus Silveira <contact@klaussilveira.com>
 * @package simpleldap
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version 0.1
 */
class SimpleLDAP
{

   /**
    * Holds the LDAP server connection
    *
    * @var resource
    * @access private
    */
   private $ldap;

   /**
    * Holds the default Distinguished Name. Ex.: ou=users,dc=demo,dc=com
    *
    * @var string
    * @access public
    */
   public $dn;

   /**
    * Holds the administrator-priviledge Distinguished Name and user. Ex.: cn=admin,dc=demo,dc=com
    *
    * @var string
    * @access public
    */
   public $adn;

   /**
    * Holds the administrator-priviledge user password. Ex.: 123456
    *
    * @var string
    * @access public
    */
   public $apass;

   /**
    * LDAP server connection
    *
    * In the constructor we initiate a connection with the specified LDAP server
    * and optionally allow the setup of LDAP protocol version
    *
    * @access public
    * @param string $hostname Hostname of your LDAP server
    * @param int $port Port of your LDAP server
    * @param int $protocol (optional) Protocol version of your LDAP server
    */
   public function __construct($hostname, $port, $protocol = null)
   {
      $this->ldap = ldap_connect($hostname, $port);

      if($protocol != null)
      {
         ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, $protocol);
      }
   }

   /**
    * Bind as an administrator in the LDAP server
    *
    * Bind as an administrator in order to execute admin-only tasks,
    * such as add, modify and delete users from the directory.
    *
    * @access private
    * @return bool Returns if the bind was successful or not
    */
   private function adminBind()
   {
      $bind = ldap_bind($this->ldap, $this->adn, $this->apass);
      return $bind;
   }

   /**
    * Authenticate an user and return it's information
    *
    * In this method we authenticate an user in the LDAP server with the specified username and password
    * If successful, we return the user information. Otherwise, we'll return false and throw exceptions with error information
    *
    * @access public
    * @param string $user Username to be authenticated
    * @param string $password Password to be authenticated
    * @return mixed User information, as an array, on successful authentication, false on error
    */
   public function auth($user, $password)
   {
      /**
       * We bind using the provided information in order to check if the user exists
       * in the directory and his credentials are valid
       */
      $bind = ldap_bind($this->ldap, "$user," . $this->dn, $password);

      if($bind)
      {
         /**
          * If the user is logged in, we bind as an administrator and search the directory
          * for the user information. If successful, we'll return that information as an array
          */
         if($this->adminBind())
         {
            $search = ldap_search($this->ldap, "$user," . $this->dn, "($user)");

            if( ! $search)
            {
               $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
               
            }

            $data = ldap_get_entries($this->ldap, $search);

            if( ! $data)
            {
               $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
               
            }

            return $data;
         }
         else
         {
            $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
            
            return false;
         }
      }
      else
      {
         $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
         
         return false;
      }
   }

   /**
    * Get users based on a query
    *
    * Returns information from users within the directory that match a certain query
    *
    * @access public
    * @param string $filter The search filter used to query the directory. For more info, see: http://www.mozilla.org/directory/csdk-docs/filter.htm
    * @param array $attributes (optional) An array containing all the attributes you want to request
    * @return mixed Returns the information if successful or false on error
    */
   public function hasUser($filter, $attributes = null)
   {
      if($this->adminBind())
      {
         if($attributes !== null)
         {
            $search = ldap_search($this->ldap, $this->dn, $filter, $attributes);

            if( ! $search)
            {
               $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
               
               return false;
            }

            return (ldap_count_entries($this->ldap, $search) != 0);
         }
         else
         {
            $search = ldap_search($this->ldap, $this->dn, $filter);

            if( ! $search)
            {
               $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
               
               return false;
            }

            return (ldap_count_entries($this->ldap, $search) != 0);
         }
      }
      else
      {
         $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
         
         return false;
      }
   }

   public function getUsers($filter, $attributes = null)
   {
      if($this->adminBind())
      {
         if($attributes !== null)
         {
            $search = ldap_search($this->ldap, $this->dn, $filter, $attributes);

            if( ! $search)
            {
               $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
               
               return false;
            }

            $data = ldap_get_entries($this->ldap, $search);
            return $data;
         }
         else
         {
            $search = ldap_search($this->ldap, $this->dn, $filter);

            if( ! $search)
            {
               $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
               
               return false;
            }

            $data = ldap_get_entries($this->ldap, $search);
            return $data;
         }
      }
      else
      {
         $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
         
         return false;
      }
   }

   /**
    * Inserts a new user in LDAP
    *
    * This method will take an array of information and create a new entry in the
    * LDAP directory using that information.
    *
    * @access public
    * @param string $uid Username that will be created
    * @param array $data Array of user information to be inserted
    * @return bool Returns true on success and false on error
    */
   public function addUser($user, $data)
   {
      if($this->adminBind())
      {
         $add = ldap_add($this->ldap, "$user," . $this->dn, $data);
         if( ! $add)
         {
            $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
            
            return false;
         }
         else
         {
            return true;
         }
      }
      else
      {
         $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
         
         return false;
      }
   }

   /**
    * Removes an existing user in LDAP
    *
    * This method will remove an existing user from the LDAP directory
    *
    * @access public
    * @param string $uid Username that will be removed
    * @return bool Returns true on success and false on error
    */
   public function removeUser($user)
   {
      if($this->adminBind())
      {
         $delete = ldap_delete($this->ldap, "$user," . $this->dn);
         if( ! $delete)
         {
            $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
            
            return false;
         }
         else
         {
            return true;
         }
      }
      else
      {
         $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
         
         return false;
      }
   }

   /**
    * Modifies an existing user in LDAP
    *
    * This method will take an array of information and modify an existing entry
    * in the LDAP directory using that information.
    *
    * @access public
    * @param string $uid Username that will be modified
    * @param array $data Array of user information to be modified
    * @return bool Returns true on success and false on error
    */
   public function modifyUser($user, $data)
   {
      if($this->adminBind())
      {
         $modify = ldap_modify($this->ldap, "$user," . $this->dn, $data);
         if( ! $modify)
         {
            $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
            
            return false;
         }
         else
         {
            return true;
         }
      }
      else
      {
         $error = ldap_errno($this->ldap) . ": " . ldap_error($this->ldap);
         
         return false;
      }
   }

   /**
    * Close the LDAP connection
    *
    * @access public
    */
   public function close()
   {
      ldap_close($this->ldap);
   }
}
