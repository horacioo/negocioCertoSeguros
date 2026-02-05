<!-- Seção do Blog -->
<section id="blog" itemscope itemtype="https://schema.org/Blog">

  <h2 itemprop="name">Nosso Blog</h2>








  <ul class="lista-blog">
    <?php
    $args = [
      'post_type'      => 'post',
      'posts_per_page' => 10,
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
    ?>
        <li itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
          <article>
            <?php if ($thumb) : ?>
              <img
                src="<?php echo esc_url($thumb); ?>"
                alt="<?php the_title_attribute(); ?>"
                itemprop="image">
            <?php endif; ?>

            <h3 itemprop="headline">
              <?php the_title(); ?>
            </h3>

            <p itemprop="articleSection">
              <?php
              $categorias = get_the_category(get_the_ID());

              if (!empty($categorias)) {
                echo esc_html($categorias[0]->name);
              }
              ?>
            </p>

            <a
              href="<?php the_permalink(); ?>"
              class="link btn"
              itemprop="url"
              aria-label="Ler artigo completo sobre <?php the_title_attribute(); ?>">
              Veja mais
            </a>
          </article>
        </li>
    <?php
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p>Nenhum post encontrado.</p>';
    endif;
    ?>
  </ul>






  </ul>

</section>