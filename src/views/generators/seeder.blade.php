use Illuminate\Database\Seeder;

class AircraftsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the aircrafts table
        DB::table(\Config::get('aircrafts.table_name'))->delete();

        //Get all of the aircrafts
        $aircrafts = Aircrafts::getList();
        foreach ($aircrafts as $aircraftId => $aircraft){
            DB::table(\Config::get('aircrafts.table_name'))->insert(array(
                'id' => $aircraftId,
                'code' => $aircraft['code'],
                'name' => $aircraft['name'],
                'updated' => $aircraft['updated'],
            ));
        }
    }
}
