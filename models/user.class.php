<?php
/**
 * Author: Kierra White
 * Date: 12/5/24
 * File: user.class.php
 * Description: This class represents an user
 */
class User{
  private int $userId;
  private string $username, $passwordHash, $email, $role, $dateCreated;
  private ?string $firstName, $lastName;

  //constructor
  public function __construct ($userId, $username, $passwordHash, $email, $role, $dateCreated, $firstName, $lastName){
    $this->userId = $userId;
    $this->username = $username;
    $this->passwordHash = $passwordHash;
    $this->email = $email;
    $this->role = $role;
    $this->dateCreated = $dateCreated;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
  }
  //get the userID
  public function getUserId(): int{
    return $this->userId;
  }
  //get the username
  public function getUsername(): string {
    return $this->username;
  }
  //get the password
  public function getPasswordHash(): string {
    return $this->passwordHash;
  }
  //get the email
  public function getEmail(): string {
    return $this->email;
  }
  //get the role
  public function getRole(): string{
    return $this->role;
  }
  //get the date the user was created
  public function getDateCreated(): string{
    return $this->dateCreated;
  }
  //get the first name
  public function getFirstName(): ?string {
    return $this->firstName;
  }
  //get the last name
  public function getLastName(): ?string {
    return $this->lastName;
  }
  //Set the user id
  public function setUserId( int $userId){
    return $this->userId;
  }
}
?>
