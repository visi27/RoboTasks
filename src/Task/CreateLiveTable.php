<?php namespace Evis\Robo\Task;

use mysqli;
use RuntimeException;
use Robo\Result;
use Robo\Task\BaseTask;
use Robo\Common\DynamicParams;

trait CreateLiveTable
{
	protected function taskLiveTable()
	{
		return new CreateLiveTableTask();
	}
}
class CreateLiveTableTask extends BaseTask
{
	use DynamicParams;
	/** @var string */
	private $host = 'localhost';
	/** @var string */
	private $user = 'root';
	/** @var string */
	private $pass = '';
	/** @var string */
	private $name;
	/** @var boolean */
	private $dropTables = false;
	/**
	 * Executes the CreateLiveTableTask Task.
	 *
	 * Example usage:
	 * ```php
	 * $this->taskCreateLiveTableTask()
	 * 		->host('my.db.host')
	 * 		->user('my_db_user')
	 * 		->pass('P@ssw0rd')
	 * 		->name('the_table_to_create')
	 * ->run();
	 * ```
	 *
	 * @return Robo\Result
	 */
	public function run()
	{
		// Login to the db
		$this->printTaskInfo('Connecting to db server - <info>mysql://'.$this->user.':'.$this->pass.'@'.$this->host.'</info>');
		$db = new mysqli($this->host, $this->user, $this->pass);
		if ($db->connect_errno)
		{
			throw new RuntimeException
			(
				'Failed to connect to MySQL: ('.$db->connect_errno.') '.
				$db->connect_error
			);
		}
		// Create the table
		$query = "CREATE TABLE IF NOT EXISTS `".$this->name."` (
                  `id` bigint(20) NOT NULL,
                  `uniqueid` varchar(100) NOT NULL,
                  `client_name` varchar(32) DEFAULT NULL,
                  `provider_name` varchar(32) DEFAULT NULL,
                  `CLIENT_PEER` varchar(32) DEFAULT NULL,
                  `src` varchar(64) DEFAULT NULL,
                  `PROVIDER_PEER` varchar(32) DEFAULT NULL,
                  `dst` varchar(64) DEFAULT NULL,
                  `billsec` int(8) DEFAULT NULL,
                  `calldate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `callpickup` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `callhangup` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `userfield` varchar(100) DEFAULT NULL,
                  `rate_date` int(10) unsigned NOT NULL,
                  `sell_dname` varchar(255) DEFAULT NULL,
                  `cost_dname` varchar(255) DEFAULT NULL,
                  `sell_prefix` varchar(20) DEFAULT NULL,
                  `cost_prefix` varchar(20) DEFAULT NULL,
                  `sell_rate` varchar(20) DEFAULT NULL,
                  `cost_rate` varchar(20) DEFAULT NULL,
                  `processed` tinyint(2) NOT NULL DEFAULT '0',
                  `prov_processed` tinyint(2) NOT NULL DEFAULT '0',
                  `cdr_filename` varchar(100) DEFAULT NULL,
                  `sell_rate_id` bigint(20) unsigned DEFAULT NULL,
                  `cost_rate_id` bigint(20) unsigned DEFAULT NULL,
                  `sell_raw_rate` varchar(255) DEFAULT NULL,
                  `cost_raw_rate` varchar(255) DEFAULT NULL,
                  `src_prefix` varchar(20) DEFAULT NULL,
                  `src_dname` varchar(100) DEFAULT NULL,
                  `sell_surcharge_zone` varchar(100) DEFAULT NULL,
                  `sell_surcharge_rate` varchar(20) DEFAULT NULL,
                  `sell_surcharge_rate_id` bigint(20) unsigned DEFAULT NULL,
                  `sell_raw_surcharge` varchar(255) DEFAULT NULL,
                  `surcharge_processed` tinyint(2) NOT NULL DEFAULT '0',
                  `cost_surcharge_zone` varchar(100) DEFAULT NULL,
                  `cost_surcharge_rate` varchar(20) DEFAULT NULL,
                  `cost_surcharge_rate_id` bigint(20) unsigned DEFAULT NULL,
                  `cost_raw_surcharge` varchar(255) DEFAULT NULL,
                  `provider_surcharge_processed` tinyint(2) NOT NULL DEFAULT '0',
                  `client_FROM` varchar(32) DEFAULT NULL,
                  `client_PAI` varchar(32) DEFAULT NULL,
                  `client_SRC_surcharge` varchar(32) DEFAULT NULL,
                  `provider_FROM` varchar(32) DEFAULT NULL,
                  `provider_PAI` varchar(32) DEFAULT NULL,
                  `provider_SRC_surcharge` varchar(32) DEFAULT NULL,
                  PRIMARY KEY (`id`,`calldate`,`rate_date`),
                  KEY `client_name_processed_surcharge_processed` (`client_name`,`processed`,`surcharge_processed`)
                ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
		
		
		$this->printTaskInfo('Running query, creating table: - <info>'.$this->name.'</info>');
		if (!$db->query($query))
		{
			throw new RuntimeException
			(
				'Failed to create table: ('.$db->errorno.') '.
				$db->error
			);
		}
		
		// If we get to here assume everything worked
		return Result::success($this);
	}
}