<div class="jumbotron row playground">
  <div class="col-lg-7">
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <?php $this->showCardInPile(1,1); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <?php $this->showCardInPile(1,2); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <?php $this->showCardInPile(1,3); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
        <?php $this->showCardInPile(1,4); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:45%">
        <?php $this->showCardInPile(1,5); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
    </div>
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <?php $this->showCardInPile(2,1); ?>
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <?php $this->showCardInPile(2,2); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <?php $this->showCardInPile(2,3); ?>
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
        <?php $this->showCardInPile(2,4); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:45%">
        <?php $this->showCardInPile(2,5); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
    </div>
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <?php $this->showCardInPile(3,1); ?>
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <?php $this->showCardInPile(3,2); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <?php $this->showCardInPile(3,3); ?>
        <!-- <div class="card__content" id="card1" style="background-position: -345px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
        <?php $this->showCardInPile(3,4); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:45%">
        <?php $this->showCardInPile(3,5); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px 0px"></div> -->
      </div>
    </div>
    <div class="column">
      <div class="card card__on__table" style="margin-left:0;">
        <?php $this->showCardInPile(4,1); ?>
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:15%">
        <?php $this->showCardInPile(4,2); ?>
        <!-- <div class="card__content" id="card1" style="background-position: 0px -135px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:25%">
        <?php $this->showCardInPile(4,3); ?>
        <!-- <div class="card__content" id="card1" style="background-position: -85px 0px"></div> -->
      </div>
      <div class="card card__on__table" style="margin-left:35%">
        <?php $this->showCardInPile(4,4); ?>
      </div>
      <div class="card card__on__table" style="margin-left:45%">
        <?php $this->showCardInPile(4,5); ?>
      </div>
    </div>
  </div>
  <div class="col-lg-offset-1 col-lg-4" style="height:385px;">
    <div class="panel panel-round">
      <div class="panel-body" id="partie_log">
        <?php $this->print_log(); ?>
        <?php $this->lauchGame(); ?>
        <span id="bottom"></span>
      </div>
    </div>
  </div>
</div>
<form class="row form-horizontal" id="KonamiCode" action="index.html" method="post">
  <div class="col-xs-3">
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon1"><i class="fa fa-empire"></i></span>
      <input id="KonamiString" type="text" class="form-control" placeholder="66mph" aria-describedby="basic-addon1">
      <span class="input-group-btn">
        <input type="submit" class="btn" value="Go">
      </span>
    </div>
  </div>
</form>
<div class="jumbotron hand">
  <div class="card card__choosen">
    <?php $this->showCard(1); ?>
    1
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(2); ?>
    2
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(3); ?>
    3
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(4); ?>
    4
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(5); ?>
    5
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(6); ?>
    6
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(7); ?>
    7
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(8); ?>
    8
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(9); ?>
    9
  </div>
  <div class="card card__choosen">
    <?php $this->showCard(10); ?>
    10
  </div>
</div>
