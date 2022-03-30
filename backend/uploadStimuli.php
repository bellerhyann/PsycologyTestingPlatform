<?php

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

  $filename = $_FILES['imgFile']['name'];
  $bucket = 'behaviorsci-assets';
  $file_Path = '/stimuli/images/'.DIRECTORY_SEPARATOR.$filename;
  $source = fopen($file_Path, 'rb');
  $key = basename($file_Path);

  echo "<br>";
  echo $file_Path;
  echo "<br>";

  $uploader = new ObjectUploader(
    $s3Client,
    $bucket,
    $key,
    $source,
    'public-read',
  );

  $destination_path = getcwd().DIRECTORY_SEPARATOR;

  if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $destination_path.basename($filename))) {
    try {
      $result = $uploader->upload();
      if ($result['@metadata']['statusCode'] == '200') {
        print('<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p>'); 
      }
    }
    catch (Aws\S3\Exception\S3Exception $e) {
      echo $e->getMessage();
    }
  }
?>
