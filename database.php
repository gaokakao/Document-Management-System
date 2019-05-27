<?
/**
* Darbas su MySQL duomenu baze
*
*/


class Database 
{
    /**
    * Linkas i MySQL susijungima 
    * @var mysqli_link
    */
	var $link;


    /**
    * Prisijungusio vartotojo numeris
    * @var mysqli_link
    */



	/**
	* Konstruktorius  
	* Vykdomas prisijungimas prie MySQL duomenu bazes
	*
	* @param string $mysql MySQL serverio prisijungimo duomenys
	*/
	function Database($mysql)
	{

		$this->link = new mysqli('localhost','sutartys','geras','sutartys');
	
//mysqli_set_charset($this->link,"utf8");
$this->link->set_charset("utf8");

	}


	/**
	* Atlieka standartine MySQL uzklausa, grazina mysqli_result rezultata
	* Zurnale fiksuojamos vykdomos uzklausos
	*
	* @param string	$query SQL uzklausa
	* @return mysqli_result uzklausos rezultatas
	*/		
	function Query($query)
	{
		$safe = $query;
		/**
		$safe = str_ireplace ( 'insert',  ' ', $query);
		$safe = str_ireplace ( 'update',  ' ', $safe);
		$safe = str_ireplace ( 'delete',  ' ', $safe);
		$safe = str_ireplace ( 'database',  ' ', $safe);
		$safe = str_ireplace ( 'show',  ' ', $safe);
		$safe = str_ireplace ( 'table',  ' ', $safe);
		*/
		
		return mysqli_query($this->link,$safe);
	}	



	/**
	* Atlieka MySQL uzklausa, grazina resultata masyve
	*
	* @param string $query SQL uzklausa
	* @return array rezultatas masyve
	*/		
	function QueryRow($query)
	{
		$result = $this->Query($query);
		return mysqli_fetch_row($result);
	}



	/**
	* Atlieka MySQL uzklausa, grazina resultata indeksuotame masyve
	*
	* @param string $query SQL uzklausa
	* @return array rezultatas indeksuotame masyve
	*/		
	function QueryAssoc($query)
	{
		$result = $this->Query($query);
		return mysqli_fetch_assoc($result);
	}



	/**
	* Atlieka MySQL uzklausa, grazina eiluciu skaiciu rezultate
	*
	* @param string $query SQL uzklausa
	* @return numeric eiluciu skaicius rezultate
	*/		
	function QueryNumRows($query)
	{
		$result = $this->Query($query);
		return mysqli_num_rows($result);
	}



	/**
	* Atsijungimas nuo MySQL duomenu bazes
	*
	*/	
	function Disconnect()
	{
		mysqli_close($this->link);
	}
}
?>