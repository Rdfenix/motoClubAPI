<?php

    namespace ApiMotoClub\Model;

    use \ApiMotoClub\Model;
    use \ApiMotoClub\DB\SQL;

    class Group extends Model
    {
        protected $fields = ["id", "title", "description", "moto_category", "city", "state", "qdt_members", "id_usuario", "dt_cadastro"];

        public function registerGroup()
        {
            $sql = new Sql();
            $groupResult = $sql->SELECT("SELECT * FROM grupo WHERE title = :TITLE", array(
                ":TITLE" => $this->gettitle()
            ));

            if(count($groupResult) > 0){
                return array(
                    "status" => 1,
                    "msg" => "Grupo ja existente"
                );
            } else {
                $result = $sql->SELECT("CALL register_group(:TITLE, :DESC, :MOTOCAT, :CITY, :STATE, :QTDMEM, :IDUSU)",
                    array(
                        ":TITLE" => $this->gettitle(),
                        ":DESC" => $this->getdescription(),
                        ":MOTOCAT" => $this->getmoto_category(),
                        ":CITY" => $this->getcity(),
                        ":STATE" => $this->getstate(),
                        ":QTDMEM" => $this->getqdt_members(),
                        ":IDUSU" => $this->getid_usuario()
                    ));

                    if(count($result) === 0){
                        return array(
                            "status" => 500,
                            "msg" => "Operacao nao pode ser completada"
                        );
                    } else {
                        return array(
                            "status" => 200,
                            "msg" => "Grupo inserido"
                        );
                    }
            }
        }

        public function getAllGroups()
        {
            $sql = new Sql();
            $result = $sql->SELECT("SELECT * FROM grupo ORDER BY dt_cadastro DESC");
            return $result;
        }

    }

?>