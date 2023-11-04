<?php
  session_start();
  session_abort();
  session_unset();

?>

<script>
 location.assign("../index.php");
</script>