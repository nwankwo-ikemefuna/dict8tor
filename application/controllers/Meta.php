<?php
defined('BASEPATH') or die('Direct access not allowed');

/**
 * This controller exists for handling git operations and db synchronizations. The schema file must be an sql file saved in directory specified as $schema_path
 * To sync visit {BASE_URL}/meta/sync?schema={schema file w/o ext}&key={pass code}
 * E.g. /meta/sync?schema=main&key=123
*/

class Meta extends Core_controller {
    public function __construct() {
        parent::__construct();
        //allow db sync
        $this->allow_sync = true;
        //sync pass key
        $this->sync_key = LOCAL_APP_CONFIG['sync_key'] ?: '';
        //git branch
        $this->git_branch = (defined('LOCAL_APP_CONFIG') && LOCAL_APP_CONFIG['git_branch']) ? LOCAL_APP_CONFIG['git_branch'] : 'master';
    }


    /**
     * Used to pull updates to server from a remote git repository using webhooks
     * The web hook event fires whenever there's a push to remote repository
     */
    public function pull() {
        //ensure exec is enabled on server
        $shell_enabled = is_callable('exec') && false === stripos(ini_get('disable_functions'), 'exec');
        if (!$shell_enabled) die('exec function not enabled on server!');

        //ensure user supplied a valid passkey 
        $key = xget('key');
        if ($key != $this->sync_key) die('Invalid or no pass key!');

        //request method
        $method = $this->input->method();
        if ($method == 'post') { //most likey from remote git repo webhook
            //get webhook payload
            $payload = json_decode(file_get_contents('php://input'), true);
            $ref_arr = explode('/', $payload['ref']); //ref eg refs/heads/master
            //branch from which event was fired
            $e_branch = strtolower($ref_arr[2]);
        } else { 
            $e_branch = strtolower(xget('branch'));
        }

        //ensure branch pushed from is same as branch from which updates are pulled
        if ($e_branch != $this->git_branch) die('Branch must be ' . $this->git_branch);

        set_time_limit(120);

        $commands = [
            'cd ' . FCPATH, //navigate to project root just in case
            'echo $PWD', //confirm working directory
            'whoami', //who's doing it?
            'git add .',
            'git commit -m "Saved local"',
            'git pull origin ' . $this->git_branch
        ];
        //execute the commands...
        $outputs = '';
        foreach($commands as $command){
            $cmd_output = exec($command);
            $outputs .= '$ '. $command . "\n";
            $outputs .= ($cmd_output) ? htmlentities(trim($cmd_output)) . "\n" : '';
        }
        echo $outputs; 
    }


    /**
     * Used to synchronize a schema to database
     */
    public function sync() {

        //ensure sync is allowed
        if (!$this->allow_sync) {
            show_error('Synchronization not allowed!', HTTP_SERVER_ERROR, 'Sync Error!');
        }

        //ensure user supplied a valid passkey 
        $key = xget('key');
        if ($key != $this->sync_key) {
            show_error('Invalid or no pass key!', HTTP_SERVER_ERROR, 'Sync Error!');
        }

        //is schema supplied in get? Use default schema file otherwise
        $schema = $_GET['schema'] ?? 'main';
        $schema_file = FCPATH.'/schema/' . $schema . '.sql';

        //does schema file exist?
        if (!file_exists($schema_file)) {
            show_error('Schema file not found!', HTTP_SERVER_ERROR, 'Sync Error!');
        }

        //fetch query from file and execute
        $query = file_get_contents($schema_file);
        if (!$query) {
            show_error('Query cannot be empty. Ensure schema file is not empty', HTTP_SERVER_ERROR, 'Sync Error!');
        }

        $queries = explode(";", $query);
        $queries = array_map('trim', $queries);
        $exec = 0;
        
        //begin transaction
        $this->db->trans_start();
        //run query/queries
        foreach ($queries as $qry) {
            if (!$qry) continue; //skip empty strings
            $run = $this->db->query($qry);
            if ($run) $exec++;
        }
        //end transaction
        $this->db->trans_complete();

        if ($exec) {
            die("Database synchronized successfully! {$exec} total queries executed successfully");
        } 
    }

}