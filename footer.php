  <!-- plugins:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/data-table.js"></script>
  <script src="js/dataTables.bootstrap4.js"></script>
  <!-- End custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <!-- Data table JS -->

  <script type="text/javascript" src="js/mis_codigo.js"></script>
  <script language="JavaScript">
    function mueveReloj() {
      momentoActual = new Date();

      ciudad = "La Virginia, Risaralda";
      hora = momentoActual.getHours();
      minuto = momentoActual.getMinutes();
      segundo = momentoActual.getSeconds();

      horaImprimible = ciudad + " : " + hora + " : " + minuto + " : " + segundo

      document.form_reloj.reloj.value = horaImprimible

      //La función se tendrá que llamar así misma para que sea dinámica, 
      //de esta forma:

      setTimeout(mueveReloj, 1000)
    }
  </script>

</body>

</html>