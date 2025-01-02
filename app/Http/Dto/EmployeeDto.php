<?php
namespace App\Http\Dto;
 class EmployeeDto
{
    /**
     * @var string
     */
    public $search;
    /**
     * @var string
     */
    public $firstName;
    /**
     * @var string
     */
    public $lastName;
     /**
     * @var string
     */
    public $middleName;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */

    public $address;
    /**
     * @var string
     */
    public $gender;
    /**
     * @var string
     */
    public $dateOfBirth;
    /**
     * @var string
     */
    public $dateOfEmployment;
    /**
     * @var string
     */ 
    public $departmentId;
    /**
     * @var string
     */
    public $designationId;
    /**
     * @var string
     */
    public $lineManagerId;
    /**
     * @var string
     */
    public $status;
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
     public $marritalStatus;

     public function __construct( $search, $firstName, $lastName, $middleName, $email, $phone, $address, $gender, $dateOfBirth, $dateOfEmployment, $departmentId, $designationId, $lineManagerId, $status, $id, $marritalStatus)
     {
         $this->search = $search;
         $this->firstName = $firstName;
         $this->lastName = $lastName;
         $this->middleName = $middleName;
         $this->email = $email;
         $this->phone = $phone;
         $this->address = $address;
         $this->gender = $gender;
         $this->dateOfBirth = $dateOfBirth;
         $this->dateOfEmployment = $dateOfEmployment
         ? $dateOfEmployment : null;
        $this->departmentId = $departmentId;
        $this->designationId = $designationId;
        $this->lineManagerId = $lineManagerId;
        $this->status = $status;
        $this->marritalStatus = $marritalStatus;
        $this->id = $id;
     }
}
?>