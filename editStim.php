<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./src/styles.css">
        <title>Stimuli Editor</title>
    </head>
    <style>
        #edit_stim_body
            {
                background: url("images/backgroundphoto1.jpg");
                background-size: cover;
                justify-content: center;
                vertical-align: center;
            } 

        #dashboard
        {
            color: #6C2037;
            border-radius: 50px;
            margin-top: 5%;
            margin-bottom: auto;
            margin-left: auto;
            margin-right: auto;
            width: 60pc;
            height: 35pc;
        }

        #content
        {
            margin-left: 250px;
        }

        table, th, td 
        {
            background-color: white;
            border-radius: 5px;
            margin-top: 10px;
            margin-left: 280px;
            color: black;
            border: 1px solid black;
        }  

        .dropbtn {
            background-color: #6C2037;
            color: black;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

                .dropdown-content a:hover {
                    background-color: #ddd;
                }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #706538;
        }
    </style>
    <body class="body">
        <div id="dashboard">
            <table>
                <tr>
                    <th>Stimulant ID</th>
                    <th>File Type</th>
                    <th>Catagory/ Note</th>
                </tr>
                <tr>

                    <td>Stim 1</td>
                    <td>PNG File</td>
                    <td>Catagory 2</td>
                </tr>
                <tr>
                    
                    <td>Stim 4</td>
                    <td>PNG File</td>
                    <td>Catagory 1</td>
                </tr>
                <tr>
                    
                    <td>Stim 2</td>
                    <td>Audio File</td>
                    <td>Catagory 1</td>
                </tr>
            </table>
            <div id="content">
                <form action="" id="upload_stim" method="post" enctype="multipart/form-data">
                    <div class="dropdown"><input name="imgFile" type="file" class="dropbtn">
                    
                    <select id="stim_key" name="stim_key">
                        <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="B3">B3</option>
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="C3">C3</option>
                    </select>

                    <select id="stim_ext" name="stim_ext">
                        <option value="image">image</option>
                        <option value="sound">sound</option>
                    </select>
                    </div>
                    <div class="dropdown"><input type="submit" name="submit" value="Upload" class="dropbtn"></div>
                </form>
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

                    /*
                        INSERT INTO SQL HERE
                    */
                    

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
            </div>
        </div>
    </body>
</html>