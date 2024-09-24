<?php
    require "../models/ContactModel.php";
    require "../services/db.php";

    interface IContactRepository{
        public function getContactsByUser(int $id): ?array;
        public function createContact(ContactModel $contact): bool;
        public function updateContact(ContactModel $contact): bool;
        public function deleteContactById(int $id): bool;
    }


    class ContactRepository implements IContactRepository{

        private mysqli $conn = getDbConnection();
        
        public function getContactsByUser(int $userid): ?array{
            try{
                $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE user_id = $userid");
                $stmt->bind_param("i", $userid);
                $stmt->execute();
    
                $result = $stmt->get_result();

                if(!$result)
                    return null;
    
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            catch(mysqli_sql_exception $e){
                return null;
            }
        }
        public function updateContact(ContactModel $contact): bool{

        }

        public function createContact(ContactModel $contact): bool{

        }

        public function deleteContactById(int $id): bool{

        }
    }