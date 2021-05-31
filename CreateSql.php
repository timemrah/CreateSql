<?php




class CreateSql
{

    public $where, $limit, $param;


    public function createLimit(int $part = 1, int $piece = 10):void{
        //Exit if no limit is specified.
        if(!is_numeric($piece) && !is_numeric($part)){ return; }
        $start = $piece * ($part - 1);
        $this->limit = "LIMIT {$start}, {$piece}";
    }


    public function createWhere($dbColName, $value, $logic = 'AND'):void{
        if($value === null){ return; }

        $colVarName = $this->createColVarName($dbColName);

        $this->where .= ($this->where) ? "{$logic} " : 'WHERE ';
        $this->where .= "{$dbColName}=:{$colVarName} ";

        $this->param[$colVarName] = $value;
    }


    public function createWhereNull($dbColName, $null, $valueString = false, $valueRevers = false, $logic = 'AND'):void{

        // VALIDATION :
        if($valueString){
            //If the value of $null is not boolean, check if the valıe is a string expression 'true' or 'false'
            if(!getValueIsInArray($null, ['true', 'false'], NULL)){ return; }

            $null = str2Bool($null);

        } else if(!is_bool($null)){
            //If null is not to be expressed as a string, it must be boolean. If not, return.
            return;
        }

        if($valueRevers){
            //If it is desired that the null state be the opposite of the specified condition.
            $null = substitutionBool($null);
        }

        //Create Where Sql Codes
        $this->where .= ($this->where) ? "{$logic} " : 'WHERE ';
        $this->where .= "{$dbColName} ";
        $this->where .= $null ? 'IS NULL ' : 'IS NOT NULL ' ;
    }


    public function createWhereLike($dbColName, $like, $logic = 'AND'):void{

        $checkLike = str_replace('%', '', $like);
        if(!$checkLike){ return; }

        $colVarName = $this->createColVarName($dbColName);
        $this->where .= ($this->where) ? "{$logic} " : 'WHERE ';
        $this->where .= "{$dbColName} LIKE :{$colVarName} ";
        $this->param[$colVarName] = $like;

    }




    //PRIVATE:
    private function createColVarName(string $dbColName):string{
        $colNameExplode = explode('.', $dbColName);
        return count($colNameExplode) > 1 ? strtolower($colNameExplode[1]) : strtolower($dbColName);
    }


    private function str2Bool(){
    	$nullValueString = ['true' => true, 'false' => false]; //Convert string value to boolean
        return $nullValueString[$value]; //$null value is now boolean
    }


    private substitutionBool($value){
    	$nullRevers = [true => false, false => true];
        return $nullRevers[$value];
    }



}