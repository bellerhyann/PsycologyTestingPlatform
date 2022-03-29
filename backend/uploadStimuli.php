<?php

  define('AWS_KEY', 'AKIAVWE4QSBSUPIB62WQ');
  define('AWS_SECRET_KEY', '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');
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
          'key'    => AWS_KEY,
          'secret' => AWS_SECRET_KEY
      ]
  ]);

  $filename = $_FILES['imgFile']['name'];
  $bucket = 'behaviorsci-assets';
  $file_Path = '/stimuli/images/' . $filename;
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

  if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $filename)) {
    try {
      $result = $uploader->upload();
      if ($result['@metadata']['statusCode'] == '200') {
        print('<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p>'); 
      }
    }
    catch (Exception $e) {
      print($e);
    }
  }
  /*
  if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $filename)) {
    try {
      echo "Trying to upload";
      $result = $s3Client->putObject([
          'Bucket' => $bucket,
          'Key'    => $key,
          'SourceFile' => fopen($file_Path,'r'),
          'ACL'    => 'public-read', // make file 'public'
      ]);
      echo "Image uploaded successfully. Image path is: ". $result->get('ObjectURL');
    } catch (Aws\S3\Exception\S3Exception $e) {
      echo "There was an error uploading the file.\n";
      echo $e->getMessage();
    }
  }
  */
?>
