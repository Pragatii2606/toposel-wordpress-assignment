<?php
get_header();

/* ========== Announcement Bar ========== */
$announcement = get_field('announcement_text');
if ($announcement): ?>
  <div class="announcement-bar">
    <?php echo esc_html($announcement); ?>
  </div>
<?php endif; ?>


<!-- ========== Hero Section ========== -->
<section class="hero">
  <?php
  $hero_image = get_field('hero_image');
  if (is_array($hero_image)):
  ?>
    <img src="<?php echo esc_url($hero_image['url']); ?>" alt="">
  <?php endif; ?>

  <?php if (get_field('hero_heading')): ?>
    <h1><?php the_field('hero_heading'); ?></h1>
  <?php endif; ?>

  <?php if (get_field('hero_subheading')): ?>
    <p><?php the_field('hero_subheading'); ?></p>
  <?php endif; ?>

  <?php
  $hero_link = get_field('hero_button_link'); // URL field
  if (!empty($hero_link)):
  ?>
    <a href="<?php echo esc_url($hero_link); ?>" class="hero-btn">
      Shop Now
    </a>
  <?php endif; ?>
</section>


<!-- ========== Brand Logos ========== -->
<section class="brands">
  <?php for ($i = 1; $i <= 4; $i++): ?>
    <?php
    $logo = get_field("brand_logo_$i");
    if (is_array($logo)):
    ?>
      <img src="<?php echo esc_url($logo['url']); ?>" alt="">
    <?php endif; ?>
  <?php endfor; ?>
</section>


<!-- ========== New Arrivals ========== -->
<section class="new-arrivals">
  <h2>New Arrivals</h2>

  <?php
  $category = get_field('new_arrivals_category');

  // ACF taxonomy field may return an object, an array, or just an ID.
  $term_id = 0;
  if ($category) {
      if (is_array($category)) {
          if (isset($category['term_id'])) {
              $term_id = $category['term_id'];
          } elseif (!empty($category[0]) && is_object($category[0]) && isset($category[0]->term_id)) {
              $term_id = $category[0]->term_id;
          } elseif (isset($category[0])) {
              $term_id = intval($category[0]);
          }
      } elseif (is_object($category) && isset($category->term_id)) {
          $term_id = $category->term_id;
      } else {
          $term_id = intval($category);
      }
  }

  if ($term_id):
    $products = new WP_Query([
      'post_type' => 'product',
      'posts_per_page' => 2,
      'tax_query' => [[
        'taxonomy' => 'product_cat',
        'field' => 'term_id',
        'terms' => $term_id,
      ]]
    ]);
  ?>

  <div class="products">
    <?php while ($products->have_posts()): $products->the_post(); global $product; ?>
      <div class="product-card">
        <?php
          // show featured image if set, otherwise WooCommerce placeholder
          if ( has_post_thumbnail( $product->get_id() ) ) {
              echo get_the_post_thumbnail( $product->get_id(), 'medium' );
          } else {
              echo wc_placeholder_img( 'medium' );
          }
        ?>
        <h3><?php the_title(); ?></h3>
        <p><?php echo wc_price($product->get_price()); ?></p>
      </div>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>

  <?php endif; ?>
</section>
<?php get_footer(); ?>
