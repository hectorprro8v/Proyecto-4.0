<?php
    session_start();?>
Finalizando sesión...
<script type="text/javascript">
    function Redirect()
    {
        <?php session_destroy(); ?>
        window.location="index.php";
    }
    setTimeout('Redirect()', 1500);
</script>