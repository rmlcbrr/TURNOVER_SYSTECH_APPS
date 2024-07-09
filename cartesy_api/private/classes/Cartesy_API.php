<?php

    class Cartesy_API{
       public $MODE;
       public $BRANCH_ID;
       public $QUEUE_ID;
       public $INSPECTION_ID;
       public $INSPECTOR_USERNAME;
       public $STAGE_NO;
       public $INSPECTION_REF_NO;
       public $TRANSACTION_NO;
       public $PURPOSE;
       public $PMVIC_CENTER;
       public $VEHICLE_INFORMATION;
       public $NOISE;
       public $EMISSIONS;
       public $OPACITY;
       public $LIGHTS;
       public $SIDESLIP;
       public $SUSPENSION;
       public $BRAKES;
       public $SPEEDOMETER;
       public $DEFECTS;

       
        private $conn;

        public function __construct(){
            $db = new Database();
            $this->conn = $db->getConnection();
        }

        public function Save_API(){

        }
    }    