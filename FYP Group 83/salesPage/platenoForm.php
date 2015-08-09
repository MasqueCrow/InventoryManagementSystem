<!DOCTYPE html>
<html>
    <?php include '../database/myDb.php';
    include'platenoSelect.php';?>
    <?php $vb=new Demo(); ?>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <script src="../jquery/jquery-1.11.1.min.js"></script>
          <script>
        
              </script>
              
    </head>
    <body>
        <div>TODO write content</div>
        <!--htmlspecialchars prevents cross site scripting -->
        <form method='post' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>'>
            <input id='carNumber' name='plateno'/>
           <button id='plateno_submit'>Submit</button>
            <div id='result'>
            </div>
        
            <br/>
            <br/>
            <select>
                 <?php $vb->getModel($conn,$_POST['plateno'])?>
                </select>
             <select>
                 <?php $vb->getMake($conn,$_POST['plateno'])?>
                </select>
            
            
        </form>
        
        
    </body>
</html>
