<?php
session_start();
include ("db_connect.php");


if (isset($_GET['update_id'])) {
  $id = mysqli_real_escape_string($conn, $_GET['update_id']);
  $sql = "SELECT * FROM customers WHERE id='$id'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $remarks = $row['remarks'];

    if (isset($_POST['submit'])) {
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

      $update_sql = "UPDATE customers SET name='$name', remarks='$remarks' WHERE id='$id'";
      $update_result = mysqli_query($conn, $update_sql);

      if ($update_result) {
        header("Location: admin.php");
        exit();
      } else {
        $error = "Error updating record: " . mysqli_error($conn);
      }
    }
  } else {
    $error = "No customer found with the given ID";
  }
} else {
  $error = "No customer ID provided";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/output.css">
  <title>Document</title>
</head>

<body class="min-h-screen bg-blue-400 py-16 relative">
  <main class="container mx-auto ma-w-7xl w-11/12">
    <button onClick="handleBackButton()" type="button"
      class="flex items-center gap-2 border border-white mb-4 rounded-md hover:bg-white/[.5] transition-all px-6 py-3">
      <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-undo-2">
        <path d="M9 14 4 9l5-5" />
        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11" />
      </svg>
      <span class="text-white">Back</span>
    </button>
    <h1 class="font-display text-white text-4xl text-center text-pink">
      Edit Information
    </h1>
    <form method="post" class="max-w-2xl mx-auto w-full mt-12">
      <div class="flex items-center gap-2 mb-3">
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required
          class="border border-white rounded-md mb-3 min-w-0 bg-blue px-6 py-4 block w-full" placeholder="Name" />
      </div>
      <textarea placeholder="<?php echo $remarks; ?>" class="w-full mb-6 p-3" name="remarks" id="remarks" cols="30"
        rows="10"></textarea>
      <div class="flex items-center gap-2">
        <button type="button" onClick="handleClearFields()"
          class="px-6 py-4 rounded-md border text-white border-white hover:bg-white/[.5] transition-all">
          Clear
        </button>
        <button type="submit" name="submit"
          class="bg-blue-600 text-white rounded-md px-6 py-4 border border-white w-full transition-all">
          Update
        </button>
      </div>
    </form>
  </main>
</body>
<script>
  function handleClearFields() {
    // console.log("run");
    const inputs = document.querySelectorAll("input");
    // console.log(inputs);
    inputs.forEach((input) => (input.value = ""));
  }

  function handleBackButton() {
    window.history.back();
  }
</script>

</html>