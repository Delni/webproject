<?php var_dump($this->liste_cartes) ?>
<div class="jumbotron row playground">
  <div class="col-lg-7">
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:45%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
    </div>
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:45%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
    </div>
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <!-- <div class="card__content" id="card1" style="background-position: -345px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:45%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
    </div>
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <!-- <div class="card__content" id="card1" style="background-position: 0px -135px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
      </div>
      <div class="card card__on__table" style="margin-left:45%">
      </div>
    </div>
  </div>
  <div class="col-lg-offset-1 col-lg-4" style="height:385px;">
    <div class="panel panel-round">
      <div class="panel-body" id="partie_log">
        <?php $this->print_log(); ?>
        <?php $this->lauchGame(); ?>
      </div>
    </div>
  </div>
</div>

<div class="jumbotron hand">
  <div class="card">
    <?php $this->showCard(1); ?>
    1
  </div>
  <div class="card">
    <?php $this->showCard(2); ?>
    2
  </div>
  <div class="card">
    <?php $this->showCard(3); ?>
    3
  </div>
  <div class="card">
    <?php $this->showCard(4); ?>
    4
  </div>
  <div class="card">
    <?php $this->showCard(5); ?>
    5
  </div>
  <div class="card">
    <?php $this->showCard(6); ?>
    6
  </div>
  <div class="card">
    <?php $this->showCard(7); ?>
    7
  </div>
  <div class="card">
    <?php $this->showCard(8); ?>
    8
  </div>
  <div class="card">
    <?php $this->showCard(9); ?>
    9
  </div>
  <div class="card">
    <?php $this->showCard(10); ?>
    10
  </div>
</div>
