<?php include("partials/_header.php"); ?>

  
    <header class="page-header">
      <h1>Shop Demo</h1>
    </header>

    <main>
      <div class="container">
        <div class="products">
          <div class="products__top">
            <div class="products__filters">
              <form action="." method="POST">
                <div class="filter-item">
                  <span>Szín</span>
                  <select name="color-select" id="colorSelect">
                    <option value="all">Összes</option>
                    <?php 
                      foreach($colors as $color) {
                        echo '<option value="'.$color['name'].'">'.$color['name'].'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="filter-item">
                  <span>Méret</span>
                  <select name="size-select" id="sizeSelect">
                    <option value="all">Összes</option>
                    <?php 
                      foreach($sizes as $size) {
                          echo '<option value="'.$size['name'].'">'.$size['name'].'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="filter-item">
                  <span>Rendezés</span>
                  <select name="order-select" id="orderSelect">
                    <option value="1">legújabb termékek</option>
                    <option value="2">legrégebbi termékek</option>
                    <option value="3">legdrágább termékek</option>
                    <option value="4">legolcsóbb termékek</option>
                  </select>
                </div>
                <div>
                  <button type="button" class="reset-btn">Reset</button>
                </div>
              </form>
            </div>

            <div class="products__pagination">
              <div class="product-numbers"><span class="value"><?php echo $allProductsCount; ?></span> db termék</div>
              <div class="steps">
                <button class="step-back__first" data-page="first"><span>&laquo;</span></button>
                <button class="step-back__one" data-page="-1"><span>&lsaquo;</span></button>
              </div>
                    
              <div class="counter"><span class="current">1</span> / <span class="all"><?php echo ceil(($allProductsCount / 8)); ?></span></div>

              <div class="steps">
                  <button class="step-next__one" data-page="+1"><span>&rsaquo;</span></button>
                  <button class="step-next__last" data-page="last"><span>&raquo;</span></button>
              </div>
            </div>
          </div>

          <div class="products__list">
            <?php foreach($products as $product) {?>
            <div class="products__item">
                <div class="item-img">
                  <img src="img/<?php echo $product['image']; ?>" alt="product name">
                </div>
                <div class="item-data">
                  <h2 class="item-name"><?php echo $product['name']; ?></h2>
                  <div class="item-price">
                    <span class="normal-price  <?php if($product['isSale'] == 1) { echo " isSale"; } ?>"><?php echo number_format($product['price'],
                    0, '', ' '); ?> Ft</span>
                    <?php if($product['isSale'] == 1) { ?>
                      <span class="sale-price"><?php echo number_format($product['price'],
                    0, '', ' '); ?> Ft</span>
                    <?php } ?>
                  </div>
                </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>

<?php include("partials/_footer.php"); ?>