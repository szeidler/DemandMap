<h1>Resources</h1>
<div class="resource-content-left">
  <p>South Sudan DemandMap aims to comply with the principles of Open Source by
    making data and resources available, transparent, and accessible. This page
    will gather Open Source resources that pertain to South Sudan.</p>

  <div class="add-resource"><?php echo HTML::anchor("resources/submit#resource-submit", "+ Add a new resource"); ?></div>
  <div class="resources-list">
    <?php if ($resources->count() > 0) : ?>
      <?php foreach ($resources as $material) : ?>
        <?php
        $commentCount = ORM::Factory('talk')
          ->where('material_id', $material->id)
          ->count_all();
        ?>
        <div class="resources-item">
          <h3><?php echo HTML::anchor("resources/view/" . $material->id, $material->title); ?></h3>

          <div class="material-content"><?php echo $material->content; ?></div>
          <?php if (!empty($material->category->category_title)) : ?>
            <h4 class="material-category">
              Category: <?php echo $material->category->category_title; ?></h4>
          <?php endif; ?>
          <div class="action-line">
            <span class="commentcount"><?php echo HTML::anchor("resources/view/" . $material->id . "#resource-comments", $commentCount . ' comments'); ?></span>
            <span class="readmore"><?php echo HTML::anchor("resources/view/" . $material->id . "#resource-detail", 'Read more'); ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="no-matchings"><p>No matching resources found.</p></div>
    <?php endif; ?>
  </div>
</div>
<div class="resource-content-right">
  <div id="resource-filter">
    <?php echo Form::open('resources/filter', array('id' => 'resource-filter-form')); ?>
    <h2>Category Filter</h2>
    <?php
    Kohana::auto_load('Resourcecategory_Model');
    $selected_categories = (!empty($selected_category_ids) AND is_array($selected_category_ids)) ? $selected_categories = $selected_category_ids : array();
    if (!empty($categories)) {
      print '<ul class="category-column-resources" id="category-column-1">';
      foreach ($categories as $category) :
        if ($category->parent_id != 10) continue; // filter list to skilled labor request categories
        ?>
        <li>
          <label>
            <span class="resource-checkbox"><?php print Form::checkbox("categories[]", $category->id, (in_array($category->id, $selected_category_ids) ? TRUE : FALSE)); ?></span>
            <span class="resource-title"><?php print $category->category_title; ?></span>
          </label>
        </li>
      <?php
      endforeach;
      print '</ul>';
    }
    ?>
    <div class="form-action">
      <?php echo Form::submit("filter", "Filter", ' class="btn_green"'); ?>
      <input type="reset" value="reset" class="btn_reset">
    </div>
    <?php echo Form::close(); ?>
  </div>
</div>