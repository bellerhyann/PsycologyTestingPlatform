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

  $soundFile = $_POST['stim_key'] . '.wav';
  $imgFile = $_POST['stim_key'] . '.png';

  $filename = $_POST['stim_key'].substr($_FILES['imgFile']['name'],-4);
  echo $filename;
  $bucket = 'behaviorsci-assets';
  $destination_path = getcwd().DIRECTORY_SEPARATOR;
  
  // First check if a file exists with the stim_key same, but not same extension
  $soundFileExists = $s3Client->doesObjectExist($bucket, $soundFile);
  $imgFileExists = $s3Client->doesObjectExist($bucket, $imgFile);

  // If we catch that case - delete the current file
  try {
    if ($soundFileExists and $soundFile != $filename) {
      // delete sound file
      $deleteStimuli = $s3Client->deleteObject([
        'Bucket' => $bucket,
        'Key' => $soundFile
      ]);
      if ($deleteStimuli['DeleteMarker']) {
        echo '<p> Successfully deleted ' . $soundFile . ' </p>' . PHP_EOL;
      }
    }
    else if ($imgFileExists and $imgFile != $filename) {
      // delete image file
      $deleteStimuli = $s3Client->deleteObject([
        'Bucket' => $bucket,
        'Key' => $imgFile
      ]);
      if ($deleteStimuli['DeleteMarker']) {
        echo '<p> Successfully deleted ' . $imgFile . ' </p>' . PHP_EOL;
      }
    }
  }
  catch (Aws\S3\Exception\S3Exception $e) {
    echo $e->getMessage();
  }

  // Then we upload to S3 normally
  // Uploading something that has the same full name - will just update on upload

  // Upload file to S3
  if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $destination_path.basename($filename))) {
    try {
      $file_Path = $destination_path.basename($filename);
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
