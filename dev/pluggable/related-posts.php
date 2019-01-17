<?php
/**
 * Related Posts Module for testing
 */
function wprig_jp_related_posts() {
  $categories = get_the_category();
  
  // WP_Query arguments
  $args = array(
    'post_status'         => array( 'publish' ),
    'posts_per_page'      => '4',
    'ignore_sticky_posts' => true,
    'category_name'       => $categories[0]->name,
  );

  // The Query
  $query = new WP_Query( $args );

  // The Loop
  if ( $query->hav_posts() ) :
  ?>
  <div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
    <h3 class="jp-relatedposts-headline"><em>Related</em></h3>

    <div class="jp-relatedposts-items jp-relatedposts-items-visual jp-relatedposts-grid">
    <?php
    while ( $query->have_posts() ) : $query->the_post();
      $count = 0;
      ?>
      <div class="jp-relatedposts-post jp-relatedposts-post<?php echo $count; ?> jp-relatedposts-post-thumbs" data-post-id="<?php the_ID(); ?>" data-post-format="false">
        <a class="jp-relatedposts-post-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="nofollow" data-origin="<?php the_ID();?>" data-position="<?php echo $count; ?>">
          <?php the_thumbnail( 'medium' ); ?>
        </a>
        <h4 class="jp-relatedposts-post-title"><?php the_title(); ?></h4>
        <p class="jp-relatedposts-post-excerpt"><?php the_excerpt(); ?></p>
        <p class="jp-relatedposts-post-date" style="display: block;"><?php wprig_posted_on(); ?></p>
        <p class="jp-relatedposts-post-context"><?php wprig_post_categories(); ?></p>
      </div>
    <?php
      $count++;
    endwhile;
    ?>
    </div>
  
  </div>
  <?php
  else: ?>
    <div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
    <h3 class="jp-relatedposts-headline"><em>Default Related</em></h3>

    <div class="jp-relatedposts-items jp-relatedposts-items-visual jp-relatedposts-grid">
    <?php
    for ( $count = 1; $count < 5; $count++ ) : 
      ?>
      <div class="jp-relatedposts-post jp-relatedposts-post<?php echo $count; ?> jp-relatedposts-post-thumbs" data-post-id="<?php echo $count; ?>" data-post-format="false">
        <a class="jp-relatedposts-post-a" href="<?php the_permalink(); ?>" title="Fake Jetpack Related Post <?php echo $count; ?>" rel="nofollow" data-origin="<?php echo $count; ?>" data-position="<?php echo $count; ?>">
        <div style="width: 200px; height: 160px; background: #428bca; color: #fff; line-height: 160px; text-align: center; ">Fake Thumbnail</div>
        </a>
        <h4 class="jp-relatedposts-post-title">Fake JetPack Related Post <?php echo $count; ?></h4>
        <p class="jp-relatedposts-post-excerpt">Here's a short fake sentence for an excerpt blah blah blah. "I don't say, 'Blah blah blah!'" says Drac.</p>
        <p class="jp-relatedposts-post-date" style="display: block;">August 17, 2018</p>
        <p class="jp-relatedposts-post-context">Uncategorized &bull; JetPack &bull; Testing</p>
      </div>
    <?php
    endfor;
    ?>
    </div>
  
  </div>
  <?php
  endif;

  // Restore original Post Data
  wp_reset_postdata();
}