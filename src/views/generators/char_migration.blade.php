use Illuminate\Database\Migrations\Migration;

class CharifyAircraftsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table(\Config::get('aircrafts.table_name'), function($table)
            {
								DB::statement("ALTER TABLE " . DB::getTablePrefix() . \Config::get('aircrafts.table_name') . " MODIFY code CHAR(3) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . \Config::get('aircrafts.table_name') . " MODIFY name CHAR(255) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . \Config::get('aircrafts.table_name') . " MODIFY updated CHAR(50) NOT NULL DEFAULT ''");
            });
        }


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table(\Config::get('aircrafts.table_name'), function($table)
            {
							DB::statement("ALTER TABLE " . DB::getTablePrefix() . \Config::get('aircrafts.table_name') . " MODIFY code CHAR(3) NOT NULL DEFAULT ''");
							DB::statement("ALTER TABLE " . DB::getTablePrefix() . \Config::get('aircrafts.table_name') . " MODIFY name CHAR(255) NOT NULL DEFAULT ''");
							DB::statement("ALTER TABLE " . DB::getTablePrefix() . \Config::get('aircrafts.table_name') . " MODIFY updated CHAR(50) NOT NULL DEFAULT ''");
            });
	}

}
