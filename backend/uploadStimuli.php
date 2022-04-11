<?php
  // File that uploads stimuli to S3 and adds info the SQL DB

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

  $fileName = $_POST['stim_key'];
  echo $fileName."<br>";
  $fileType = $_FILES['imgFile']['type'];
  echo $fileType."<br>";
  $bucket = 'behaviorsci-assets';
  $destination_path = getcwd().DIRECTORY_SEPARATOR;
  

  // Upload file to S3
  if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $destination_path.basename($fileName))) {
    try {
      $file_Path = $destination_path.basename($fileName);
      $key = basename($file_Path);
      $source = fopen($file_Path, 'rb');

      $uploader = new ObjectUploader(
        $s3Client,
        $bucket,
        $key,
        $source,
        'public-read',
      );
    
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
