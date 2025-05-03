<?php
session_start();
session_destroy();
echo '<script>
    localStorage.removeItem("userToken");
    window.location.href = "/public/paginicial.php";
</script>';
?>