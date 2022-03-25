<?php

  require 'vendor/autoload.php';
  
  use Aws\S3\S3Client;

  // Instantiate an Amazon S3 client.
  $s3Client = new S3Client([
      'version' => 'latest',
      'region'  => 'us-west-1',
      'credentials' => [
          'key'    => 'bernadetteko',
          'secret' => 'Ilovesecurity!'
      ]
  ]);
    
  $bucket = 'elasticbeanstalk-us-west-1-391170265189';
  $file_Path = $bucket . '/stimuli/images/' . $_FILES['imgFile']['name'];
  $key = basename($file_Path);

  echo $file_Path;
  echo "<br>";

  try {
    echo "Trying to upload";
    $result = $s3Client->putObject([
        'Bucket' => $bucket,
        'Key'    => $key,
        'SourceFile' => $file_Path,
        'ACL'    => 'public-read', // make file 'public'
    ]);
    echo "Image uploaded successfully. Image path is: ". $result->get('ObjectURL');
  } catch (Aws\S3\Exception\S3Exception $e) {
    echo "There was an error uploading the file.\n";
    echo $e->getMessage();
  }

?>
