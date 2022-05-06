//Author: CJ Hess 
//
// Updates the files stored in S3 Bucket for the stimuli
// Also updates the stimuli_T with same information
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

  $fileName = $_POST['stim_key'].substr($_FILES['imgFile']['name'],-4);
  $fileType = $_FILES['imgFile']['type'];
  $bucket = 'behaviorsci-assets';
  $destination_path = getcwd().DIRECTORY_SEPARATOR;


  //INSERT INTO SQL HERE
  $stimName = $_POST['stim_key'];
  $stimTYP = $_POST['stim_ext'];

  // SQL - Done by Bernadette Kornberger
  $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
  if (!$conn)
    die("Username or Password not found: Database Error.".mysqli_connect_error());

  $queryString = "UPDATE stimuli_T SET stimtype = \"$stimTYP\" WHERE stimID = \"$stimName\"";
  $queryUPD = mysqli_query($conn, $queryString);
  

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
        print('<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p><br>'); 
      }
    }
    catch (Aws\S3\Exception\S3Exception $e) {
      echo $e->getMessage();
    }

    print('<a href="editStim.php">Return to Edit Stim</a>');
  }
?>
