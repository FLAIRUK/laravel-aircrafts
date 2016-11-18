<?php

namespace ijeffro\Aircrafts;

use Illuminate\Database\Eloquent\Model;

/**
 * AircraftList
 *
 */
class Aircrafts extends Model {

	/**
	 * @var string
	 * Path to the directory containing aircrafts data.
	 */
	protected $aircrafts;

	/**
	 * @var string
	 * The table for the aircrafts in the database, is "aircrafts" by default.
	 */
	protected $table;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
       $this->table = \Config::get('aircrafts.table_name');
    }

    /**
     * Get the aircrafts from the JSON file, if it hasn't already been loaded.
     *
     * @return array
     */
    protected function getAircrafts()
    {
        //Get the aircrafts from the JSON file
        if (sizeof($this->aircrafts) == 0){
            $this->aircrafts = json_decode(file_get_contents(__DIR__ . '/Models/aircrafts.json'), true);
        }

        //Return the aircrafts
        return $this->aircrafts;
    }

	/**
	 * Returns one aircraft
	 *
	 * @param string $id The aircraft id
     *
	 * @return array
	 */
	public function getOne($id)
	{
        $aircrafts = $this->getAircrafts();
		return $aircrafts[$id];
	}

	/**
	 * Returns a list of aircrafts
	 *
	 * @param string sort
	 *
	 * @return array
	 */
	public function getList($sort = null)
	{
	    //Get the aircrafts list
	    $aircrafts = $this->getAircrafts();

	    //Sorting
	    $validSorts = array(
					'code',
					'name',
					'updated',
        );

	    if (!is_null($sort) && in_array($sort, $validSorts)){
	        uasort($aircrafts, function($a, $b) use ($sort) {
	            if (!isset($a[$sort]) && !isset($b[$sort])){
	                return 0;
	            } elseif (!isset($a[$sort])){
	                return -1;
	            } elseif (!isset($b[$sort])){
	                return 1;
	            } else {
	                return strcasecmp($a[$sort], $b[$sort]);
	            }
	        });
	    }

	    //Return the aircrafts
		return $aircrafts;
	}

	/**
	 * Returns a list of aircrafts suitable to use with a select element in Laravelcollective\html
	 *
	 * @param string sort
	 *
	 * @return array
	 */
	public function getListForSelect($sort = null)
	{
		foreach ($this->getList('name') as $key => $value) {
			$aircrafts[$key] = $value['name'];
		}

		//return the array
		return $aircrafts;
	}
}
