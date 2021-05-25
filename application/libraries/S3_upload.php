<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH . '/application/third_party/aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3_upload
{

    private $ci;
    private $s3_config = [
        'credentials' => [
            'key'       => AWS_S3_CONFIG['access_key'],
            'secret'    => AWS_S3_CONFIG['secret_key']
        ],
        'region'  => AWS_S3_CONFIG['region'],
        'version' => 'latest'
    ];

    public function __construct()
    {
        $this->ci = &get_instance();
    }


    public function upload($path, $file_name)
    {
        if (!AWS_S3_CONFIG['enabled']) {
            return ['status' => false, 'error' => 'AWS S3 upload not enabled!'];
        }

        try {
            $client = S3Client::factory($this->s3_config);
        } catch (Exception $e) {
            // return ['status' => false, 'error' => $e->getMessage()];
            die("Error: " . $e->getMessage());
        }

        try {
            $source_file = $path . '/' . $file_name;
            $s3_file = AWS_S3_CONFIG['upload_dir'] . '/' . $source_file;
            $s3_object = [
                'Bucket'        => AWS_S3_CONFIG['bucket'],
                'Key'           => $s3_file,
                'SourceFile'    => $source_file,
                'StorageClass'  => 'REDUCED_REDUNDANCY',
                'ACL'           => 'public-read'
            ];
            if ($client->putObject($s3_object)) {
                return ['status' => true, 'file_name' => $file_name];
            } else {
                return ['status' => false, 'error' => "Unable to upload file [{$source_file}] to s3 bucket [" . AWS_S3_CONFIG['bucket'] . "]"];
            }
        } catch (S3Exception $e) {
            // return ['status' => false, 'error' => $e->getMessage()];
            die('Error:' . $e->getMessage());
        } catch (Exception $e) {
            // return ['status' => false, 'error' => $e->getMessage()];
            die('Error:' . $e->getMessage());
        }
    }

    public function delete($path, $delete_thumb = false)
    {
        if (!AWS_S3_CONFIG['enabled']) {
            return false;
        }

        try {
            $file = AWS_S3_CONFIG['upload_dir'].'/uploads/'.$path;
            // var_dump($file); die;
            $client = S3Client::factory($this->s3_config);
            $result = $client->deleteObject([
                'Bucket'        => AWS_S3_CONFIG['bucket'],
                'Key'           => $file,
            ]);
            return $result;
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function download($path)
    {
        if (!AWS_S3_CONFIG['enabled']) {
            return ['status' => false, 'error' => 'AWS S3 upload not enabled!'];
        }

        try {
            $file = AWS_S3_CONFIG['upload_dir'].'/uploads/'.$path;
            $client = S3Client::factory($this->s3_config);
            $result = $client->getObject([
                'Bucket'        => AWS_S3_CONFIG['bucket'],
                'Key'           => $file,
            ]);
            header("Content-Type: {$result['ContentType']}");
            $s3_file = $result['Body'];
            echo $s3_file;
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }


    public function listObjects($upload_dir = null)
    {
        if (!AWS_S3_CONFIG['enabled']) {
            return ['status' => false, 'error' => 'AWS S3 upload not enabled!'];
        }

        try {
            $client = S3Client::factory($this->s3_config);
            $iterator = $client->getIterator('ListObjects', array(
                'Bucket' => AWS_S3_CONFIG['bucket']
            ));
            foreach ($iterator as $object) {
                if ($upload_dir) {
                    if (strpos($object['Key'], $upload_dir) === false) {
                        continue;
                    }
                }
                echo $object['Key'] . "<br/>";
            }
            die;
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
