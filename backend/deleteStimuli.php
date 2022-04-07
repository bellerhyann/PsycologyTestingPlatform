<?php
  // File that deletes a stimuli from S3 and the SQL DB
  define('HOST', 'https://s3.us-west-1.amazonaws.com');
  define('REGION', 'us-west-1');

  require 'vendor/autoload.php';
  
  use Aws\S3\S3Client;
  use Aws\S3\ObjectUploader;

  // Instantiate an Amazon S3 client.
  $s3Client = new S3Client([
      'version' => 'latest',
      'region'  => REGION,
      'endpoint' => HOST,
      'credentials' => [
          'key'    => $_SERVER["AWS_KEY"],
          'secret' => $_SERVER["AWS_SECRET_KEY"]
      ]
  ]);

  $stimuli = $_POST['stim_key']; 
  $bucket = 'behaviorsci-assets';

  try {
    $result = $s3Client->listObjects([
      'Bucket' => $bucket
    ]);


    foreach ($result['Contents'] as $object) {
      $keyWOExt = substr($object['Key'],0,2);
      if ($keyWOExt == $stimuli) {
        $deleteStimuli = $s3Client->deleteObjects([
          'Bucket' => $bucket,
          'Key' => $object
        ]);
      }
   }
  }
  catch (Aws\S3\Exception\S3Exception $e){
    echo $e->getMessage() . PHP_EOL;
  }
?>
