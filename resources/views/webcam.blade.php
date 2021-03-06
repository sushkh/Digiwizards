<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>InstaToll</title>
    <style type="text/css">
        body { font-family: Helvetica, sans-serif; }
        h2, h3 { margin-top:0; }
        form { margin-top: 15px; }
        form > input { margin-right: 15px; }
        #results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
    </style>
</head>
<body>
    <div id="results">Your captured image will appear here...</div>
    
    <h1>InstaToll Image Recognition System</h1>
    
    <div id="my_camera"></div>
    
    <!-- First, include the Webcam.js JavaScript Library -->
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('js/webcam.js')}}"></script>
    
    <!-- Configure a few settings and attach camera -->
    <script language="JavaScript">
        Webcam.set({
            width: 500,
            height: 400,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
    </script>
    
    <!-- A button for taking snaps -->
    <form>
        <input type="button" value="Access Camera" onClick="setup(); $(this).hide().next().show();">
        <input type="button" value="Take Snapshot" onClick="take_snapshot()" style="display:none">
    </form>
    
    <!-- Code to handle taking the snapshot and displaying it locally -->
    <script language="JavaScript">
        function setup() {
            Webcam.reset();
            Webcam.attach( '#my_camera' );
        }
        
        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                // display results in page
                document.getElementById('results').innerHTML = 
                    '<h2>Here is your image:</h2>' + 
                    '<img src="'+data_uri+'"/>';
                    console.log(data_uri);
                    $.ajax({
                      url:"{{URL::asset('upload_image')}}",
                      // send the base64 post parameter
                      data:{
                        base64: data_uri
                      },
                      // important POST method !
                      type:"post",
                      success:function(){
                        window.location = "http://localhost:8000/textrecognition";
                      }
                    });

            } );
        }
    </script>
    
</body>
</html>