<div class="bbn-grid-fields bbn-l">
  <div>
    <span class="label-icon">
      <i class="nf nf-fa-user label-icon"></i>
    </span>
    <?=_('Staff')?>
  </div>
  <a :href="linkCard" v-text="staff"></a>

  <div>
    <span class="label-icon">
      <i class="nf nf-mdi-beach label-icon"></i>
    </span>
    <?=_('Pour')?>
  </div>
  <div v-text="type" :style="{color: color}"></div>

  <div>
    <span class="label-icon">
      <i class="nf nf-fa-calendar label-icon"></i>
    </span>
    <?=_('Du/Au')?>
  </div>

  <div>
    <span v-text="start"></span>
    <i class="bbn-hsmargin nf nf-fa-long_arrow_right"></i>
    <span v-text="end"></span>
  </div>
</div>