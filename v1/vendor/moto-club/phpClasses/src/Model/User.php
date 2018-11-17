<?php 

    namespace ApiMotoClub\Model;

    use \ApiMotoClub\Model;
    use \ApiMotoClub\DB\SQL;

    class User extends Model
    {
        const SESSION = 'user';
        protected $fields = ["id", "name_user", "last_name", "city", "state", "maritial_state", "motocycle", "email_user", "pass_user", "dt_cadastro" ];


        public function session()
		{
			return $_SESSION[User::SESSION]['id'];
		}
		
		public function registerUser()
		{
			$sql = new Sql();
			$userResult = $sql->SELECT("SELECT email_user FROM usuario WHERE email_user = :USER", array(
                ":USER"=>$this->getemail_user()
            ));

			if (count($userResult) > 0) {
				return array(
					"status"=>1,//quando for 1 é por que já existe um usuario
					"msg"=>"existing user"
				);
			} else {

                $result = $sql->SELECT("CALL register_user(:NAME, :LASTNAME, :CITY, :STATE, :MARITIAL, :MOTOCYCLE, :EMAIL, :PASS)",
                    array(
                        ":NAME" => $this->getname_user(),
                        ":LASTNAME" => $this->getlast_name(),
                        ":CITY" => $this->getcity(),
                        "STATE" => $this->getstate(),
                        ":MARITIAL" => $this->getmaritial_state(),
                        ":MOTOCYCLE" => $this->getmotocycle(),
                        "EMAIL" => $this->getemail_user(),
                        "PASS" => $this->getpass_user()
                    ));
                    
                if(count($result) === 0){
                    return array(
                        "status" => 500,
                        "msg" => "Operacao nao pode ser completada"
                    );
                } else {
                    return array(
                        "status" => 200,
                        "msg" => "usuario inserido"
                    );
                }

			}
        }
        
        public function login($login, $pass)
        {
            $sql = new Sql();
            $user = $sql->SELECT("SELECT * FROM usuario WHERE email_user = :USER AND pass_user = :PASS", array(
                ":USER"=>$login,
                ":PASS"=>$pass
            ));

            if(count($user) === 0){
                return array(
                    "status" => 404,
                    "msg" => "Usuario nao encontrado"
                );
            } else {
                
                $user[0]["status"] = 302;
                $user[0]["msg"] = "Usuario Encontrado";

                return $user[0];

                /*return array(
                    "status" => 302,
                    "msg" => "Usuario Encontrado"
                );*/
            }
        }

        public function listUser($email)
        {
            $sql = new Sql();
            $result = $sql->SELECT("SELECT  name_user, last_name, city, state, maritial_state, motocycle, email_user, pass_user  FROM usuario WHERE email_user = :USER", array(
                ":USER" => $email
            ));

            return json_encode($result);
        }
    }

?>