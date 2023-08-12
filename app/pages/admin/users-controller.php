<?php
//add new
if ($action == 'add') {

  if (!empty($_POST)) {

    //validate
    $errors = [];

    if (empty($_POST['username'])) {

      $errors['username'] = "A username is required";
    } else if (!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {

      $errors['username'] = "Username can only have letters and no spaces";
    }

    $query = "select id from users where email = :email limit 1";

    $email = query($query, ['email' => $_POST['email']]);

    if (empty($_POST['email'])) {

      $errors['email'] = "A email is required";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

      $errors['email'] = "Email not valid";
    } else if ($email) {

      $errors['email'] = "That email is already in use";
    }

    if (empty($_POST['password'])) {

      $errors['password'] = "A password is required";
    } else  if (strlen($_POST['password']) < 8) {

      $errors['password'] = "Password must be 8 character or more";
    } else if ($_POST['password'] !== $_POST['retype_password']) {

      $errors['password'] = "Passwords do not match";
    }


    if (empty($errors)) {
      // Lấy dữ liệu từ biểu mẫu
      $data = [];
      $data['username'] = $_POST['username'];
      $data['email']    = $_POST['email'];
      $data['role']     = $_POST['role'];
      $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // Xử lý tải lên ảnh
      if (!empty($_FILES['image']['name'])) {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES['image']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra nếu tệp đã tồn tại
        if (file_exists($targetFile)) {
          $errors['image'] = "File already exists.";
          $uploadOk = 0;
        }

        // Kiểm tra kích thước ảnh
        if ($_FILES['image']['size'] > 5242880) { // Giới hạn 5MB
          $errors['image'] = "File size is too large.";
          $uploadOk = 0;
        }

        // Cho phép các định dạng ảnh cụ thể
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedFormats)) {
          $errors['image'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
          $uploadOk = 0;
        }

        // Nếu không có lỗi, thực hiện tải lên
        if ($uploadOk == 1) {
          if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Lưu đường dẫn vào cơ sở dữ liệu
            $data['image'] = $targetFile;
          } else {
            $errors['image'] = "Error uploading file.";
          }
        }
      }

      // Thêm thông tin vào cơ sở dữ liệu
      if (empty($errors)) {
        $query = "INSERT INTO users (username, email, password, role, image) VALUES (:username, :email, :password, :role, :image)";
        $data['image'] = $targetFile; // Nếu bạn muốn lưu đường dẫn ảnh vào cơ sở dữ liệu
        query($query, $data);
        redirect('admin/users');
      }
    }
  }
} else   if ($action == 'edit') {

  $query = "select * from users where id = :id limit 1";
  $row = query_row($query, ['id' => $id]);

  if (!empty($_POST)) {

    if ($row) {

      //validate
      $errors = [];

      if (empty($_POST['username'])) {
        $errors['username'] = "A username is required";
      } else
        if (!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
        $errors['username'] = "Username can only have letters and no spaces";
      }

      $query = "select id from users where email = :email && id != :id limit 1";
      $email = query($query, ['email' => $_POST['email'], 'id' => $id]);

      if (empty($_POST['email'])) {
        $errors['email'] = "A email is required";
      } else
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email not valid";
      } else
        if ($email) {
        $errors['email'] = "That email is already in use";
      }

      if (empty($_POST['password'])) {
      } else
        if (strlen($_POST['password']) < 8) {
        $errors['password'] = "Password must be 8 character or more";
      } else
        if ($_POST['password'] !== $_POST['retype_password']) {
        $errors['password'] = "Passwords do not match";
      }

      //validate image
      $allowed = ['image/jpeg', 'image/png', 'image/webp'];
      if (!empty($_FILES['image']['name'])) {
        $destination = "";
        if (!in_array($_FILES['image']['type'], $allowed)) {
          $errors['image'] = "Image format not supported";
        } else {
          $folder = "uploads/";
          if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
          }

          $destination = $folder . time() . $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'], $destination);


          // Update image path in the $data array
          $data['image'] = $destination;
        }
      }


      if (empty($errors)) {
        //save to database
        $data = [];
        $data['username'] = $_POST['username'];
        $data['email']    = $_POST['email'];
        $data['role']     = $_POST['role'];
        $data['id']       = $id;

        $password_str     = "";
        $image_str        = "";

        if (!empty($_POST['password'])) {
          $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
          $password_str = "password = :password, ";
        }

        if (!empty($destination)) {
          $image_str = "image = :image, "; // Add a comma here to separate the image column
          $data['image'] = $destination;
        }

        $query = "UPDATE users SET username = :username, email = :email, $password_str $image_str role = :role WHERE id = :id LIMIT 1";

        query($query, $data);
        redirect('admin/users');
      }
    }
  }
} else if ($action == 'delete') {

  $query = "select * from users where id = :id limit 1";

  $row = query_row($query, ['id' => $id]);

  if (!empty($_POST)) {

    if ($row) {

      //validate
      $errors = [];

      if (empty($_POST['username'])) {

        //delete from  database
        $data = [];

        $data['id']       = $id;
        if (!empty($_POST['delete_action']) && $_POST['delete_action'] === 'delete') {
          //delete action
          $query = "DELETE FROM users WHERE id = :id";
          query($query, ['id' => $id]);
          redirect('admin/users');
        }
      }
    }
  }
}
