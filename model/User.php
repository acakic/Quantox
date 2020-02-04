<?php 

class User
{
	protected $conn = null;
	public function __construct($db)
	{
		$this->conn = $db;
	}
	/*
     * Method for check if  that email is free to use registration!
     */ 
    public function checkIfAvailable($email)
    {
    	$query = 'select * from users where email = :email';
		$stmt = $this->conn->prepare($query);
    	$stmt->bindParam(':email', $email);
    	$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		//if is not found return true (email not exists in db)
		if (!$result) {
			return true;			
		}
		return false;
    }
     /*
     * Method for saving data into USERS table.
     */
    public function register($name, $email, $password, $role_id, $subrole_id, $sub_subrole_id)
    {
    	$query = 'insert into users (name, email, password, role_id, subrole_id, sub_subrole_id) values (:name, :email, :password, :role_id, :subrole_id, :sub_subrole_id)';
		$stmt = $this->conn->prepare($query);
    	$stmt->bindParam(':name', $name);
    	$stmt->bindParam(':email', $email);
    	$stmt->bindParam(':password', $password);
    	$stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':subrole_id', $subrole_id);
        $stmt->bindParam(':sub_subrole_id', $sub_subrole_id);
    	if ($stmt->execute()) {
    		return true;
    	}
    	return false;
    }
    /*
     * Method for check if that email exists, login!
     */
    public function checkUser($email)
	{
		$query = 'select * from users where email = :email';
		$stmt = $this->conn->prepare($query);
    	$stmt->bindParam(':email', $email);
    	$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			return $result;
		}
		return false;
	}
    /*
     * Method for returning one user!
     */
    public function getOneUser($id_user)
    {
        $query  = 'select u.id_user, u.name, u.email, u.password, r.description, s.sdescription, ss.ssdescription';
        $query .= ' from users as u';
        $query .= ' join roles as r on u.role_id = r.id_role';
        $query .= ' join subroles as s on u.subrole_id = s.id_subroles';
        $query .= ' join sub_subroles as ss on u.sub_subrole_id = ss.id_sub_subroles';
        $query .= ' where id_user = :id_user';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        }
        return false;
    }
    /*
     * Method for saving (updateing) new user data into users table!
     */
    public function Update($id_user, $name, $email, $password, $role_id, $subrole_id, $sub_subrole_id)
    {
        $query = 'update users set name = :name, email = :email, password = :password, role_id = :role_id, subrole_id = :subrole_id, sub_subrole_id = :sub_subrole_id where id_user = :id'; 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':subrole_id', $subrole_id);
        $stmt->bindParam(':sub_subrole_id', $sub_subrole_id);
        $stmt->bindParam(':id', $id_user);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    /*
     * Method for deleting user from users tables.
     */
    public function deleteUser($id_user)
    {
        $query = 'delete from users where id_user = :id_user';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    /*
     * Method for Finding users from search form!
     */
    public function getAllUsers($roleId = null, $name = null)
    {
        $query  = 'select u.id_user, u.name, u.email, u.password, r.description, r.id_role as roleId, s.sdescription, s.id_subroles as subroleId, ss.ssdescription, ss.id_sub_subroles as subsubrolesId';
        $query .= ' from users as u';
        $query .= ' join roles as r on u.role_id = r.id_role';
        $query .= ' join subroles as s on u.subrole_id = s.id_subroles';
        $query .= ' join sub_subroles as ss on u.sub_subrole_id = ss.id_sub_subroles';
        if($roleId && $name) {
            $query .= ' where r.id_role = ' . $roleId;
            $query .= ' and u.name like \'%' . $name . '%\'';
        } else if ($roleId) {
            $query .= ' where r.id_role = ' . $roleId;
        } else if ($name) {
            $query .= ' where u.name like \'%' . $name . '%\'';
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result;
        }
        return false;
    }
    /*
     * Method for Finding users from fillter form!
     */
    public function getAllUsersByFilter($filters) 
    {
        $query  = 'select u.id_user, u.name, u.email, u.password, r.description, r.id_role as roleId, s.sdescription, s.id_subroles as subroleId, ss.ssdescription, ss.id_sub_subroles as subsubrolesId';
        $query .= ' from users as u';
        $query .= ' join roles as r on u.role_id = r.id_role';
        $query .= ' join subroles as s on u.subrole_id = s.id_subroles';
        $query .= ' join sub_subroles as ss on u.sub_subrole_id = ss.id_sub_subroles';

        if(isset($filters['role']) && isset($filters['subrole']) && isset($filters['subsubrole'])) {
            var_dump($filters);
            $query .= ' where r.id_role IN (' . implode(',', array_map('intval', $filters['role'])) . ') or';
            $query .= '  s.id_subroles IN (' . implode(',', array_map('intval', $filters['subrole'])) . ') or';
            $query .= '  ss.id_sub_subroles IN (' . implode(',', array_map('intval', $filters['subsubrole'])) . ')';
        } else if (isset($filters['role']) && isset($filters['subrole'])) {
            $query .= ' where r.id_role IN (' . implode(',', array_map('intval', $filters['role'])) . ') or';
            $query .= ' s.id_subroles IN (' . implode(',', array_map('intval', $filters['subrole'])) . ')';
        } else if (isset($filters['subrole']) && isset($filters['subsubrole'])) {
            $query .= ' where s.id_subroles IN (' . implode(',', array_map('intval', $filters['subrole'])) . ') or';
            $query .= ' ss.id_sub_subroles IN (' . implode(',', array_map('intval', $filters['subsubrole'])) . ')';
        } else if (isset($filters['role']) && isset($filters['subsubrole'])) {
            $query .= ' where r.id_role IN (' . implode(',', array_map('intval', $filters['role'])) . ') or';
            $query .= ' ss.id_sub_subroles IN (' . implode(',', array_map('intval', $filters['subsubrole'])) . ')';
        } else if (isset($filters['role'])) {
            $query .= ' where r.id_role IN (' . implode(',', array_map('intval', $filters['role'])) . ')';
        } else if (isset($filters['subrole'])) {
            $query .= ' where s.id_subroles IN (' . implode(',', array_map('intval', $filters['subrole'])) . ')';
        } else if (isset($filters['subsubrole'])) {
            $query .= ' where ss.id_sub_subroles IN (' . implode(',', array_map('intval', $filters['subsubrole'])) . ')';
        }
        $stmt = $this->conn->prepare($query);
        // var_dump($stmt);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result;
        }
        return false;
    }
    /*
     * Method for returning subroles!
     */
    public function getSubRolesByRole($roleId)
    {
        $query = 'select id_subroles, sdescription from subroles where roles_id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $roleId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        }
        return false;
    }
    /*
     * Method for returning subsubroles!
     */
    public function getSubSubRoleBySubRole($subroleId)
    {
        $query = 'select id_sub_subroles, ssdescription from sub_subroles where subrole_id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $subroleId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        }
        return false;
    }
}