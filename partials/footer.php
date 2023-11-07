<div class="containter overflow-hidden">
  <div class="row bg-dark text-light pt-2">
    <div class="col-md">
      <p class="text-center py-2 fw-bold">Copyright &copy;
        <?php echo date("Y"); ?> All rights reserved
      </p>
    </div>
  </div>
</div>
<script src="bootstrap/js/jquery.js"></script>
<script src="bootstrap/js/jquery.dataTables.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function () {
    $("#account_no").hide();
    $("#mySelect").change(function () {
      if ($(this).val() == "2") {
        $("#account_no").show();
      } else {
        $("#account_no").hide();
      }
    });

    $("#fetchData").change(function () {
      //alert("Hello");
      let loan_type = $('#fetchData').val();
      //alert(loan_type);

      $.ajax({
        url: './ajax/retrieve_rate.php',
        type: 'POST',
        data: { loan_type: loan_type },
        success: function (data) {
          console.log(data);
          $('#dataDisplay').html(data);
          $('#rate').val(data);
        },
        error: function () {
          $('#dataDisplay').html('Error fetching data.');
        }
      })
    })

    $("#durationSelect").change(function () {
      //alert('hello');
      let selectedDuration = $("#durationSelect").val();
      let currentDate = new Date();
      let futureDate = new Date(currentDate);

      if (selectedDuration == 1) {
        futureDate.setDate(currentDate.getDate() + 7);
      } else if (selectedDuration == 2) {
        futureDate.setDate(currentDate.getDate() + 14);
      } else if (selectedDuration == 3) {
        futureDate.setDate(currentDate.getDate() + 21);
      } else if (selectedDuration == 4) {
        futureDate.setMonth(currentDate.getMonth() + 1);
      } else if (selectedDuration == 5) {
        futureDate.setMonth(currentDate.getMonth() + 3);
      } else if (selectedDuration == 6) {
        futureDate.setMonth(currentDate.getMonth() + 6);
      } else if (selectedDuration == 7) {
        futureDate.setFullYear(currentDate.getFullYear() + 1);
      }

      var timeDifference = futureDate - currentDate;
      var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));


      var amt = $("#amount").val(); // Corrected selector
      var amt_rate = $("#rate").val();
      let int = (amt * amt_rate * daysDifference) / 364
      let amt_due = Number(amt) + Number(int);

      let futureDateString = futureDate.toISOString().split('T')[0];
      $("#result").html("Amount Due: " + amt_due.toFixed(2));
      $("#futureDateInput").val(futureDateString);
      $("#amount_due").val(amt_due.toFixed(2));


    });
  });
</script>
<script>
  new DataTable('#transaction');
</script>
</body>

</html>