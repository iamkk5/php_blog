<?php

session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) &&  empty($_SESSION['logged_in'])) {
      header('Location: login.php');
}
if ($_POST) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $content = $_POST['content'];

  if ($_FILES['image']['name'] !=null) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);

      if ($imageType != 'png' && $imageType != 'jpeg' && $imageType != 'jpg') {
        echo "<script>alert('Image must be png, jpeg and jpg!!')</script>";
      }else {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $stmt = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image'  WHERE id='$id'");
        $result = $stmt->execute();
        if ($result) {
          echo "<script>alert('Sucessfully Updated!!');window.location.href='index.php';</script>";
        }
    }
  }else {
        $stmt = $pdo->prepare("UPDATE posts SET title='$title',content='$content'  WHERE id='$id'");
        $result = $stmt->execute();
        if ($result) {
          echo "<script>alert('Sucessfully Updated!!');window.location.href='index.php';</script>";
        }
    }
  }


$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

 ?>

   <?php include 'header.html'; ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="">Content</label><br>
                    <textarea class="form-control" name="content" rows="8" cols="80"><?php echo $result[0]['content']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Image</label><br>
                    <img src="images/<?php echo $result[0]['image']; ?>" width="150" height="150" alt=""><br><br>
                    <input type="file" name="image" value="">
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                    <a href="index.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card -->


            <!-- /.card -->
          </div>

          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <?php include 'footer.html'; ?>
