<?php

class Transaction
{

    public $id;
    public $transact_id;
    public $pmvic_name;
    public $transact_data;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function vehicleType($data)
    {
        $newdata = json_decode($data['transact_data']);

        foreach (json_decode($newdata->vehicleTpye) as $vtype) {
            echo "<p>$vtype</p>";
        }
    }

    public function amountPerUpload($data)
    {
        $newdata = json_decode($data['transact_data']);

        foreach (json_decode($newdata->amounPerUpload) as $amount) {
            echo "<p>$amount</p>";
        }
    }

    public function countNumbersOfUploads($data)
    {
        $newdata = json_decode($data->transact_data);
        $pmvic_name = $data->pmvic_name;
        $resultTransact=0;

        foreach (json_decode($newdata->stageType) as $stageno) {
            $query = "SELECT * FROM tbl_dermalog WHERE PMVIC_CENTER = '$pmvic_name' AND STAGE_NO='$stageno' AND DATE(DATE_CREATED)=DATE(NOW())";
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultTransact = $stmt->rowCount();

            $res[]=$resultTransact;
        }

        echo json_encode([
            'message' => $res,
            'status'  => 200
        ]);
    }
  
    public function totalUploads($data)
    {
        $newdata = json_decode($data->transact_data);
        $pmvic_name = $data->pmvic_name;
        $resultTransact=0;
      	$i=0;
        $total=0;

        foreach (json_decode($newdata->stageType) as $stageno) {
          
          	$query = "SELECT * FROM tbl_dermalog WHERE PMVIC_CENTER = '$pmvic_name' AND STAGE_NO='$stageno' AND DATE(DATE_CREATED)=DATE(NOW())";
          
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultTransact = $stmt->rowCount();
          
          	$total= $resultTransact * json_decode($newdata->amounPerUpload)[$i]; 
            
              $res[]=$total;

          $i++;
        }

        echo json_encode([
            'message' => $res,
            'status'  => 200
        ]);
    }
  
    public function getLiveTransact()
    {
        $login = new Login();
        $pmvicName=$login->get_userdata()['pmvicName'];

        $query = "SELECT * FROM tbl_daily_transact where pmvic_name='$pmvicName'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultTransact = $stmt->fetchAll();

        return $resultTransact;
    }

    public function checkTransactionValue($pmvicName)
    {
        $query = "SELECT* FROM tbl_daily_transact where pmvic_name='$pmvicName'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultTransact = $stmt->rowCount();

        return $resultTransact;
    }

    public function save()
    {
        $data = [
            'pmvic_name'     => $this->pmvic_name,
            'transact_data' => $this->transact_data
        ];

        if (
            $this->checkTransactionValue($this->pmvic_name) > 0
        ) {
            echo 'duplicate';
            die();
        }

        try {
            $query = "INSERT INTO tbl_daily_transact (pmvic_name, transact_data) 
                                VALUES(:pmvic_name, :transact_data)";
            $stmt   = $this->conn->prepare($query);
            $result = $stmt->execute($data);
        } catch (Exception $e) {
            $result = 'Save ' . $e->getMessage();
        }

        echo $result;
    }

    public function UpdateTransact()
    {
        $data = [
            'transact_data' => $this->transact_data,
            'transact_id'  => $this->id
        ];

        try {
            $query = "UPDATE tbl_daily_transact SET transact_data=:transact_data WHERE transact_id=:transact_id";

            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($data);
        } catch (Exception $e) {
            $result = 'Save ' . $e->getMessage();
        }

        echo $result;
    }

    public  function fetchTransact($user_id)
    {
        $query = "SELECT * FROM tbl_daily_transact WHERE  transact_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        return $user;
    }

    public function getTransact()
    {
        $query = '';

        $query .= "SELECT * FROM tbl_daily_transact ";
        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE transact_id LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR pmvic_name LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR transact_data LIKE "%' . $_POST["search"]["value"] . '%" ';
        }

        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY transact_id DESC ';
        }

        if ($_POST["length"] != -1) {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }


        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultTransact = $stmt->fetchAll();

        return $resultTransact;
    }


    public function get_total_all_transact_records()
    {
        $query = "SELECT * FROM tbl_daily_transact";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function fetchpmvic($user_id)
    {
        $query = "SELECT * FROM tbl_users WHERE  user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        return $user;
    }

    public function DeleteTransact()
    {
        $data = [
            'transact_id' => $this->transact_id,
        ];
        $query = "DELETE FROM tbl_daily_transact WHERE transact_id= :transact_id";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute($data);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
