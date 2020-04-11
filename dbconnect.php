<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_reporting(E_ALL);

  class dbconnector
  {
    var $dblink;
    function connect()
    {
      global $dblink;
      $dblink = new mysqli("localhost","root","","kb_storage");//DATABASE CONNECTION
      if($dblink == false)
      {
        die("ERROR: Could not connect. " . mysqli_connect_error());//shows error on erroneous connection
      }
    }

// Function to verify user credentials

    public function checkLogin($username, $password)//checks username and password from the table of the databse
    {
      global $dblink;
      $query = $dblink->prepare("SELECT id, username, name, role_type FROM login_credentials WHERE username = ? AND password = ? AND disabled = 0");
      $query->bind_param("ss", $username, $password);
      $query->execute();
      return $query->get_result();
    }

// Functio to register a new users

    public function register($name, $username, $password, $email, $role)
    {
      global $dblink;
      $query = $dblink->prepare("INSERT INTO login_credentials (name, username, password, email, role_type) values(?, ?, ?, ?, ?)");
      $query->bind_param("sssss", $name, $username, $password, $email, $role);
      if($query->execute())
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }

// Functio to check username availability

    public function checkavailability($username)
    {
      global $dblink;
      $query = $dblink->prepare("SELECT username FROM login_credentials WHERE username = ?");
      $query->bind_param("s", $username);
      $query->execute();
      return $query->get_result();
    }

// Function to add a new issue

    public function addIssue($title, $description, $resolution, $user_id, $auth_id1, $auth_id2)//SQL in php for insertion of new data in posts table
    {
      global $dblink;
      $currenttime = time();
      $query = $dblink->prepare("INSERT INTO posts (title, description, resolution, user_id, auth_id1, auth_id2, creation_time, lastemail_time) values(?, ?, ?, ?, ?, ?, now(), $currenttime)");
      $query->bind_param("sssiii", $title, $description, $resolution, $user_id, $auth_id1, $auth_id2);
      return array($query->execute(), $dblink->insert_id);
    }

// Function to search approved posts accessible to admins

    public function search($searchquery)//accessing posts table from kb databse to give search results
    {
      global $dblink;
      $query =  $dblink->prepare("SELECT post_id, title, description FROM posts WHERE MATCH (title,description, resolution) AGAINST (? IN NATURAL LANGUAGE MODE) AND approved=1");
      $query->bind_param('s', $searchquery);
      $query->execute();
      return ($query->get_result())->fetch_all(MYSQLI_ASSOC);
    }

// Function to get an approved post

    public function getPost($id)
    {
      global $dblink;
      $query = $dblink->prepare("SELECT login_credentials.name, login_credentials.username, post_id ,title, description, resolution, approved, creation_time FROM posts INNER JOIN login_credentials ON posts.user_id=login_credentials.id WHERE post_id = ?");//showing of the local results after accessing results from the posts table
      $query->bind_param("i", $id);
      $query->execute();
      return ($query->get_result())->fetch_array(MYSQLI_ASSOC);
    }

// Function to get an unapproved post

    public function getunapproved($auth_id){
    global $dblink;
    $query = $dblink->prepare("SELECT login_credentials.name, login_credentials.username, post_id ,title, description, resolution, approved, creation_time FROM posts INNER JOIN login_credentials ON posts.user_id=login_credentials.id WHERE auth_id1 = ? OR auth_id2 = ?");//showing of the local results after accessing results from the posts table
    $query->bind_param("ii", $auth_id, $auth_id);
    $query->execute();
    return ($query->get_result());
  }

// Funtion for approving a post by an admin

  public function approvepost($id, $is_superadmin){
  global $dblink;
  if($is_superadmin)
  {
    $query = $dblink->prepare("SELECT approved FROM posts WHERE post_id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    if($result->num_rows > 0)
    {
      $query = $dblink->prepare("UPDATE posts SET approved = 1 WHERE post_id = ?");
      $query->bind_param("i", $id);
      $query->execute();
      return 1;
    }
    else
    {
      return 0;
    }
  }
  else
  {
  $query = $dblink->prepare("SELECT post_id, auth_id1, auth_id2 FROM posts WHERE auth_id1 = ? OR auth_id2 = ?");
  $query->bind_param("ii", $id, $id);
  $query->execute();
  $result = $query->get_result();
  if($result->num_rows > 0)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if($row['auth_id1'] == $id)
    {
      $target = 'auth_id1';
      $other_authid = 'auth_id2';
    }
    else
    {
      $target = 'auth_id2';
      $other_authid = 'auth_id1';
    }
    $query = $dblink->prepare("UPDATE posts SET $target = 0 WHERE auth_id1 = ? OR auth_id2 = ?");
    $query->bind_param("ii", $id, $id);
    $query->execute();
    if($row[$other_authid] == 0)
    {
      $query = $dblink->prepare("UPDATE posts SET approved = 1 WHERE post_id = ".$row['post_id']);
      $query->execute();
    }
    return 1;
  }
  else
  {
    return 0;
  }
  }
  }

// Function to get all posts (approved and unapproved)

  public function getallPosts()
  {
    global $dblink;
    $query = $dblink->prepare("SELECT login_credentials.name, post_id ,title, description, resolution, approved, creation_time FROM posts INNER JOIN login_credentials ON posts.user_id=login_credentials.id ORDER BY creation_time DESC");
    $query->execute();
    return ($query->get_result())->fetch_all(MYSQLI_ASSOC);
  }

// Function to delete a post in superadmin Panel

  public function deletePost($post_id)
  {
    global $dblink;
    $query = $dblink->prepare("DELETE FROM posts WHERE post_id = ?");
    $query->bind_param("s", $post_id);
    $query->execute();
  }

// Function to edit a post in superadmin Panel

  public function editPost($title, $description, $resolution, $post_id)
{
  global $dblink;
  $query = $dblink->prepare("UPDATE posts SET title = ?, description = ?, resolution = ? WHERE post_id = ?");
  $query->bind_param("ssss", $title,$description,$resolution,$post_id);
  $query->execute();
}

// Function to display all users in superadmin panel

public function getUsers()
{
  global $dblink;
  $query = $dblink->prepare("SELECT id, name, username, password, role_type FROM login_credentials WHERE disabled = 0");
  $query->execute();
  return ($query->get_result())->fetch_all(MYSQLI_ASSOC);
}

public function getUser($id)
{
  global $dblink;
  $query = $dblink->prepare("SELECT id, name, username, role_type, email, password FROM login_credentials WHERE id = ?");
  $query->bind_param("i", $id);
  $query->execute();
  return ($query->get_result())->fetch_array(MYSQLI_ASSOC);
}

public function updateUser($name, $username, $password, $email, $role_type, $id)
{
  global $dblink;
  $query = $dblink->prepare("UPDATE login_credentials SET name = ?,  username = ?, password = ?, email = ?, role_type = ? WHERE id = ?");
  $query->bind_param("sssssi", $name, $username, $password, $email, $role_type, $id);
  $query->execute();
}

/*Function to delete User.
 *Instead of completely deleting user details from database, simply sets a disabled field
 *in order to preserve user details(Name, Username) to display on the posts created by the user.
 */
public function deleteUser($id)
{
  global $dblink;
  $query = $dblink->prepare("UPDATE login_credentials SET disabled = 1 WHERE id = ?");
  $query->bind_param("i", $id);
  $query->execute();
}

}
