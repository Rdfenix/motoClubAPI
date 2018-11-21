<?php 

    namespace ApiMotoClub\Model;

    use \ApiMotoClub\Model;
    use \ApiMotoClub\DB\SQL;

    class EventUser extends Model
    {
        protected $fields = ["id", "title", "local", "horario", "author", "lat", "lon", "dt_cadastro"];

        public function registerEvent()
        {
            $sql = new Sql();
            $eventResult = $sql->SELECT("SELECT title FROM evento WHERE title = :TITLE", array(
                ":TITLE"=>$this->gettitle()
            ));

			if (count($eventResult) > 0) {
				return array(
					"status"=>1,//quando for 1 é por que já existe um usuario
					"msg"=>"existing event"
				);
            } else {

                $result = $sql->SELECT("CALL register_event(:TITLE, :LOCAL, :HORARIO, :AUTHOR, :LAT, :LON)",
                array(
                    ":TITLE" => $this->gettitle(),
                    ":LOCAL" => $this->getlocal(),
                    ":HORARIO" => $this->gethorario(),
                    ":AUTHOR" => $this->getauthor(),
                    "LAT" => $this->getlat(),
                    ":LON" => $this->getlon()
                ));
                
                if(count($result) === 0){
                    return array(
                        "status" => 500,
                        "msg" => "Operacao nao pode ser completada"
                    );
                } else {
                    return array(
                        "status" => 200,
                        "msg" => "Evento criado"
                    );
                }
            }
        }

        public function getAllEvents()
        {
            $sql = new Sql();
            $result = $sql->SELECT("SELECT * FROM evento ORDER BY dt_cadastro DESC");
            return $result;
        }
    }

?>