<script src="<?php echo tema; ?>/javascript/jquery.slim.min.js"></script>



<?php
if (is_home()) {
    echo '
       <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
       <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

       ';
    echo "<script src='" . tema . "/javascript/slickAtribuicoes.js'></script>";
}
?>


<script type="text/javascript" src="<?php echo tema ?>/javascript/menu.js"></script>


<script>
        document.addEventListener('DOMContentLoaded', () => {
            const botoes = document.querySelectorAll('.btn');

            botoes.forEach((botao, index) => {
                setTimeout(() => {
                    botao.classList.add('pulse');
                }, index * 500); // 500ms = 0,5s
            });
        });
</script>

    <?php wp_footer(); ?>

        </body>

        </html>