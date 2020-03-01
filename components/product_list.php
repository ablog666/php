<section class="catalog">
  <div class="container">
    <h1 class="catalog-title">Каталог товаров</h1>
    <ul class="filters">
      <?php foreach($filters as $filter): ?>
      <?php $filter_class = 'filter'; ?>
      <?php if($type === $filter['url']): {
	      $filter_class = $filter_class . ' filter-current';
      } ?>
      <?php endif; ?>
      <li>
        <a class="<?= $filter_class ?>" href="catalog.php?product_type=<?= $filter['url'] ?>"><?= $filter['name'] ?></a>
      </li>
      <?php endforeach; ?>
    </ul>

     <ul class="products-list">
      <?php foreach($items as $item): ?>
      <?php if ($item['type'] === $type): ?>
      <li>
        <a class="product-card" href="#">
          <h3><?= $item['title'] ?></h3>
          <img src="<?= $item['img_url'] ?>" width="156" height="120" alt="<?= $item['title'] ?>">
          <div class="product-options">
            <span class="price"><?= $item['price'] ?></span>
            <ul class="colors-list">
              <?php foreach ($item['colors'] as $color): ?>
              <li class="color-<?= $color ?>"></li>
              <?php endforeach;?>
            </ul>
          </div>
        </a>
      </li>
      <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
