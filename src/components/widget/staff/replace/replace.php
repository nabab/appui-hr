<div class="bbn-grid-fields bbn-l">
  <div>
    <span class="label-icon">
      <i class="nf nf-fa-user label-icon"></i>
    </span>   
    <?=_('Employee')?>
  </div>
  <a :href="root + 'page/card/' + source.id_employe" 
             v-text="employee"
  ></a>
  
  <div>
    <span class="label-icon">
      <i class="nf nf-mdi-beach label-icon"></i>
    </span>  
    <?=_('For')?>
  </div>
  <div v-text="type" 
       :style="{color: color}"
  ></div>
  
  <div>
    <span class="label-icon">
      <i class="nf nf-fa-calendar label-icon"></i>
    </span>  
    <?=_('From/To')?>
  </div>
  <div>
    <span v-text="start"></span>
    <i class="bbn-hsmargin nf nf-fa-long_arrow_right"></i>
    <span v-text="end"></span>
  </div>

</div>