<?php

use Service\AuthServiceImpl;

?>


</div> <!-- content -->
<?php if (AuthServiceImpl::getInstance()->getCurrentAgentId() > 0) { ?>

    <footer class="bg-white sticky-footer">
        <div class="container my-auto">
            <div class="text-center my-auto copyright"><span>Copyright © Hive 2020</span></div>
        </div>
    </footer>

<?php } ?>
</div> <!-- content-wrapper -->
</div> <!-- wrapper -->

<a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
<script src="assets/js/Bootstrap-Tags-Input.js"></script>
<script src="assets/js/theme.js"></script>
<script src="assets/js/script.js"></script>

</body>

</html>