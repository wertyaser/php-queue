$("#generateQueueBtn").click(function () {
  (async () => {
    var selectedType = document.querySelector("select[name='type']").value;

    if (selectedType === "") {
      alert("Please select a transaction type.");
      return;
    }

    var queueNumber = Math.floor(Math.random() * 9000) + 1000;

    document.getElementById("queueNumberInput").value = queueNumber;
    // document.getElementById("queueNumberInput").disabled = false;
    document.querySelector("form").submit();

    const { value: formValues } = await Swal.fire({
      title: "Generate Queue Number",
      html:
        '<input type="text" id="queueNumberInput" name="queue_number" value="' +
        queueNumber +
        '" disabled>',
      showCancelButton: false,
    });

    if (formValues) {
      var data = {
        num: $("#queueNumberInput").val(),
      };

      $.ajax({
        url: "home.php",
        type: "post",
        data: data,
        success: function () {
          Swal.fire({
            icon: "success",
            title: "Generated Successfully",
            html: "Your Queue Number : " + data["num"],
          }).then((result) => {
            if (result.isConfirmed) {
              // Optional: Redirect or perform additional actions
            }
          });
        },
      });
    }
  })();
});

// document.getElementById("generateQueueBtn").addEventListener("click", function () {
//   var selectedType = document.querySelector("select[name='type']").value;
//   if (selectedType === "") {
//     alert("Please select a transaction type.");
//     return;
//   }

//   // Generate random number (e.g., between 1000 and 9999)
//   var queueNumber = Math.floor(Math.random() * 9000) + 1000;

//   // Set the generated queue number in the input field
//   document.getElementById("queueNumberInput").value = queueNumber;

//   // Enable the input field before submitting the form
//   document.getElementById("queueNumberInput").disabled = false;

//   // Submit the form
//   document.querySelector("form").submit();

// });
